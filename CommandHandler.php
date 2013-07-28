<?php
    /*
     * this is a TEMPORARY COMMAND HANDLER
     * it will be upgraded when i can figure out the best way to handle args 
     * and other information
     */

    require_once 'Dec.php';
    require_once 'libirc/Reader.php';
    require_once 'command/CommandDummy.php';
    require_once 'command/CommandEval.php';
    require_once 'command/CommandRegister.php';
    require_once 'command/CommandIdentify.php';
    require_once 'command/CommandDie.php';
    require_once 'command/CommandQuit.php';
    require_once 'command/CommandReboot.php';
    require_once 'command/CommandDb.php';
    
    class CommandHandler {
        public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
            $command = trim($args[0], $charlist = ":~");
            
            if(in_array($commander, $socket->config['owners'])) {
                switch($command) {
                 case "dummy" :
                     new CommandDummy($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "eval" :
                    ob_start();
                    eval(implode(" ", array_slice($args, 1)));
                    $returned = ob_get_clean();
                    $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Evaluation".Dec::dgreen."] ".Dec::bold.Dec::orange.$returned);
                     break;
                 case "register" :
                     new CommandRegister($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "identify" :
                     new CommandIdentify($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "die" :
                     new CommandDie($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "quit" :
                     new CommandQuit($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "reboot" :
                     new CommandReboot($socket, $commander, $rawmode, $chan, $args);
                     break;
                 case "db" :
                     new CommandDb($bot, $socket, $commander, $rawmode, $chan, $args);
                     break;
                }
            } else {
                $socket->write("PRIVMSG $chan :$commander, you do not have access to this command!");
            }
        }
    }
?>
