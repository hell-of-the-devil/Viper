<?php
require 'libirc/Database.php';
require_once 'Dec.php';
class CommandDb extends Database {
    public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        $args = array_splice($args, 1);
        switch ($args[0]) {
            case "adduser" :
                if(count($args) > 1) {
                    if($bot->ison($args[1], $chan)) {
                        if(!$this->userCheck($bot, $args[1])) {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." Adding `$args[1]` to the datbase");
                        } else {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange." $args[1] already exists on the database");
                        }
                    } else {
                        $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange."$args[1] needs to be in $chan to be added to the database (Security Feature)");
                    }
                } else {
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Database".Dec::dgreen."]".Dec::bold.Dec::orange."Usage :: ~db adduser <nick>");
                }
                break;
        }
    }
    
    public function userCheck(Bot $bot, $str) {
        $res = $this->select($this->connection(), "SELECT * FROM user WHERE nick='$str'");
        var_dump(count($res));
        if(count($res) > 1) {
            return true;
        } else {
            return false;
        }
    }
}
?>
