<?php
require 'libirc/Database.php';
require_once 'Dec.php';
class CommandDb extends Database {
    public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        if(count($args) < 2) {
            $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database Help".Dec::dgreen."]".Dec::bold.Dec::orange.Reader::read_file("files/help/help_db"));
            return;
        }
        
        switch ($args[1]) {
            case "adduser" :
                if(count($args) > 1) {
                    if($bot->ison($args[2], $chan)) {
                        if(!$this->userCheck($args[2])) {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Adding `$args[2]` to the datbase");
                            $this->insert($this->getConnectionSocket(), "INSERT INTO user set nick='$args[2]', login=' ', password=' ' , flags=' ', rank=' ';");
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Added $args[2] to database");
                        } else {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] already exists on the database");
                        }
                    } else {
                        $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] needs to be in $chan to be added to the database (Security Feature) \\being phased out\\");
                    }
                } else {
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Usage :: ~db adduser <nick>");
                }
                break;
            case "edituser" :
                    if(count($args) > 2) {
                        if($bot->ison($args[2], $chan)) {
                            if($this->userCheck($args[2])) {
                                switch($args[3]) {
                                    case "login" :
                                        echo "LOGIN";
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Editing variable login on nick $args[2]");
                                        $this->update($this->getConnectionSocket(), "UPDATE user SET login='$args[4]' where nick='$args[2]'");
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." set login for $args[2] to $args[4]");
                                        break;
                                    case "password" :
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Editing variable password on nick $args[2]");
                                        $this->update($this->getConnectionSocket(), "UPDATE user SET password='$args[4]' where nick='$args[2]'");
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." set password for $args[2] to *****");
                                        break;
                                    case "flags" :
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Editing variable flags on nick $args[2]");
                                        $this->update($this->getConnectionSocket(), "UPDATE user SET flags='$args[4]' where nick='$args[2]'");
                                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." set flags for $args[2] to $args[4]");
                                        break;
                                    case "rank" :
                                        $oldrank = $this->getRank($args[2]);
                                        if($this->rankCheck($this->getRank($commander))) {
                                            $newrank = $args[4];
                                            echo $this->rankupdown($oldrank, $newrank);
                                            if($this->rankupdown($oldrank, $newrank) == "up") {
                                                $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Congrats $args[2], you just ranked up from $oldrank to $newrank");
                                                echo "up";
                                            } elseif($this->rankupdown($oldrank, $newrank) == "down") {
                                                $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Fuck you $args[2], you have been deranked from $oldrank to $newrank for your incompetence");
                                                echo "down";
                                            } elseif($this->rankupdown($oldrank, $newrank) === null) {
                                                $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] is already a(n) $newrank");
                                                echo "null";
                                                return;
                                            } else {
                                                echo "fuck do i know how you got here :/";
                                                return;
                                            }
                                        }
                                        $this->update($this->getConnectionSocket(), "UPDATE user SET rank='$args[4]' WHERE nick='$args[2]'");
                                        break;
                                }
                            } else {
                                $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] is not listed on the database");
                            }
                        } else {
                            $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] needs to be in $chan to be added to the database (Security Feature) \\being phased out\\");
                        }
                    } else {
                        $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Not enough Parameters Defined.");
                    }
                break;
            case "viewuser" :
                if($this->userCheck($args[2])) {
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Retreiving stats for $args[2]");
                    $data = $this->select($this->getConnectionSocket(), "SELECT * FROM user WHERE nick='$args[2]'");
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." UserID ".Dec::purple.">>".Dec::orange." ".$data['id']);
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Nick ".Dec::purple.">>".Dec::orange." ".$data['nick']);
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Login ".Dec::purple.">>".Dec::orange." ".$data['login']);
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Password ".Dec::purple.">>".Dec::orange." ".$data['password']);
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Flags ".Dec::purple.">>".Dec::orange." ".$data['flags']);
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Rank ".Dec::purple.">>".Dec::orange." ".$data['rank']);
                } else {
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] is not listed on the database");
                }
                break;
            case "remuser" :
                if($this->userCheck($args[2])) {
                    $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Attempting to delete $args[2] permanently");
                    $this->delete($this->getConnectionSocket(), "DELETE FROM user WHERE nick='$args[2]'");
                    $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] account deleted permanently...");
                } else {
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[2] is not listed on the database");
                }
                break;
        }
    }
    
    public function userCheck($str) {
        $res = $this->select($this->connection(), "SELECT * FROM user WHERE nick='$str'");
        var_dump(count($res));
        if(count($res) > 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function rankCheck($str) {
        $ranks = array(
            'owner',
            'co-owner',
            'admin',
            'op',
            'janitor',
            'friend'
        );
        
        if(in_array($str, $ranks)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getRank($commander) {
        $rank = $this->select($this->getConnectionSocket(), "SELECT rank FROM user WHERE nick='$commander'");
        return implode(" ", $rank);  
    }
    
    public function rankupdown($oldrank, $newrank) {
        switch($oldrank) {
            case "owner" :
                if($newrank == "owner") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "co-owner" :
                if($newrank == "owner") {
                    return "up";
                } elseif ($newrank == "co-owner") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "admin" :
                if($newrank == "owner" or $newrank == "co-owner") {
                    return "up";
                } elseif($newrank == "admin") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "op" :
                if($newrank == "owner" or $newrank == "co-owner" or $newrank == "admin") {
                    return "up";
                } elseif($newrank == $oldrank) {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "janitor" :
                if($newrank == "owner" or $newrank == "co-owner" or $newrank == "admin" or $newrank == "op") {
                    return "up";
                } elseif($newrank == $oldrank) {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "friend" :
                if($newrank == $oldrank) {
                    return null;
                } else {
                    return "up";
                }
                break;
        }
    }
}
?>