<?php
require_once 'libirc/Reader.php';
class CommandHelp {
    
    public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        if(count($args) < 2) {
            $socket->notice($commander, Reader::read_file("files/help/help"));
            return;
        }
        
        switch($args[1]) {
            case "db" :
                $socket->notice($commander, Reader::read_file("files/help/help_db"));
                break;
            case "die" :
                $socket->notice($commander, Reader::read_file("files/help/help_die"));
                break;
            case "dummy" :
                $socket->notice($commander, Reader::read_file("files/help/help_dummy"));
                break;
            case "eval" :
                $socket->notice($commander, Reader::read_file("files/help/help_eval"));
                break;
            case "identify" :
                $socket->notice($commander, Reader::read_file("files/help/help_identify"));
                break;
            case "quit" :
                $socket->notice($commander, Reader::read_file("files/help/help_quit"));
                break;
            case "reboot" :
                $socket->notice($commander, Reader::read_file("files/help/help_reboot"));
                break;
            case "register" :
                $socket->notice($commander, Reader::read_file("files/help/help_register"));
                break;
        }
    }
}
?>
