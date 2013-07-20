<?php
    /*
     * this is a TEMPORARY COMMAND HANDLER
     * it will be upgraded when i can figure out the best way to handle args 
     * and other information
     */

    require_once 'Dec.php';
    class CommandHandler {
        public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
            $command = trim($args[0], $charlist = ":~");
            
            switch($command) {
                case "dummy" :
                    $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Dummy".Dec::dgreen."]".Dec::orange." This is a dummy command used for testing");
                    break;
                case "eval" :
                    ob_start();
                    eval(implode(" ", array_slice($args, 1)));
                    $returned = ob_get_clean();
                    $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Evaluation".Dec::dgreen."]".Dec::bold.Dec::orange." $returned");
                    break;
                case "register" :
                    $socket->write("PRIVMSG nickserv :register ".$socket->config['nspass']." ".$socket->config['email']);
                    $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Registration".Dec::dgreen."]".Dec::bold.Dec::orange." Registered to NickName Services (Alias: NickServ)");
                    break;
                case "identify" :
                    $socket->write("PRIVMSG nickserv :identify ".$socket->config['nspass']);
                    $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Identification".Dec::dgreen."]".Dec::bold.Dec::orange." Identified to NickName Services (Alias: NickServ)");
                    break;
                case "die" :
                    die();
                    break;
            }
        }
    }
?>
