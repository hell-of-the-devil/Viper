<?php
require_once 'CommandHandler.php';
require_once 'PrivateMessageHandler.php';
require_once 'libirc/Database.php';
class Bot {
        
    public function __construct(Socket $socket) {
        while (true) {
            if ($socket->ready()) {
                $raw = $socket->read();

                if (trim($raw) == "") {
                    continue;
                }

                echo $raw;
                $from = explode(" ", trim($raw));

                if ($from[0] === "PING") {
                    $socket->write("PONG " . $from[1]);
                }
                
                if ($from[1] == "PRIVMSG") {
                    $commander = $this->getCommander($from[0]);
                    $rawmode = $from[1];
                    $cich = str_split($from[2]);

                    if ($cich[0] === '#') {
                        $channel = $from[2];
                    } else {
                        $channel = null;
                    }
                    $args = array_slice($from, 3);
                    
                    if($args[0] === NULL) {
                        $cic = str_split($args[1]);
                    } else {
                        $cic = str_split($args[0]);
                    }    
                        
                    if ($cic[1] == $socket->config['cmdid']) {
                        if($channel != NULL) {
                            new CommandHandler($this, $socket, $commander, $rawmode, $channel, $args);
                        } 
                    } else {
                        if($channel == NULL) {
                            new PrivateMessageHandler($this, $socket, $commander, $args);
                        }
                    }
                }

                if ($from[0] === "ERROR") {
                    
                }

                if ($from[1] == "353") {
                    $ul = array();
                    $chan = $from[4];
                    $pl = array_slice($from, 5);
                    $pl[0] = ltrim($pl[0], ':');
                    foreach ($pl as $u) {
                        $m = substr($u, 0, 1);
                        if (!in_array($m, array('~', '&', '@', '%', '+')))
                            $m = '';
                        else
                            $u = substr($u, 1);

                        $ub = array('user' => $u, 'mode' => $m);
                        $ul[] = $ub;
                    }
                    $e = array('users' => $ul, 'chan' => $chan);
                    $this->channels[$chan] = $e['users'];
                }
                
                if($from[1] == "001") {
                    $socket->loadOnStart();
                }

                if ($from[1] == "PART") {
                    $chan = $from[2];
                    $user = $this->getCommander($from[0]);
                    if (!isset($this->channels[$chan])) continue;
                    foreach ($this->channels[$chan] as $k => $u) {
                        if ($u['user'] == $user) {
                            unset($this->channels[$chan][$k]);
                        }
                    }
                    
                    if($this->userCheck($user)) {
                        Database::update_where("user", "active='false'", "nick='$user'");
                    }
                }
                
                if ($from[1] == "JOIN") {
                    $chan = ltrim($from[2], ':');
                    $user = $this->getCommander($from[0]);

                    if (!isset($this->channels[$chan]))
                        $this->channels[$chan] = array();
                    $this->channels[$chan][] = array('user' => $user, 'mode' => '');
                }
                
                if ($from[1] == "QUIT") {
                    $user = $this->getCommander($from[0]);
                    foreach ($this->channels as $chan => $ul) {
                        foreach ($ul as $k => $u) {
                            if ($user == $u['user']) {
                                unset($this->channels[$chan][$k]);
                            }
                        }
                    }
                    if($this->userCheck($user)) {
                        Database::update_where("user", "active='false'", "nick='$user'");
                    }
                }
                
                if ($from[1] == "KICK") {
                    $chan = $from[2];
                    $user = $from[3];
                    if (!isset($this->channels[$chan])) continue;
                    foreach ($this->channels[$chan] as $k => $u) {
                        if ($u['user'] == $user) {
                            unset($this->channels[$chan][$k]);
                        }
                    }
                    if($this->userCheck($user)) {
                        Database::update_where("user", "active='false'", "nick='$user'");
                    }
                }
                
                if ($from[1] == "NICK") {
                    $oldnick = $this->getCommander($from[0]);
                    $newnick = ltrim($from[2], ':');
                    
                    foreach ($this->channels as $chan => $ul) {
                        foreach ($ul as $k => $u) {
                            if ($u['user'] == $oldnick) {
                                unset($this->channels[$chan][$k]);
                                $this->channels[$chan][] = array('user' => $newnick, 'mode' => '');
                            }
                        }
                    }
                    if($this->userCheck($oldnick)) {
                        Database::update_where("user", "active='false'", "nick='$oldnick'");
                    }
                }
            }
        }
    }
    
    public function userCheck($str) {
        $res = Database::select_all_where("user", "nick='$str'");
        if(count($res) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function ison($nick, $chan) {
        if (!isset($this->channels[$chan]))
            return false;
        foreach ($this->channels[$chan] as $k => $u) {
            if ($u['user'] == $nick)
                return true;
        }
        return false;
    }

    public function getCommander($str) {
        return ltrim(implode("", array_slice(explode("!", $str, 2), 0, 1)), ":");
    }
    
    public function getDatabase() {
        $db = new Database();
        return $db;
    }
}

?>