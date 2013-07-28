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
    require_once 'command/CommandHelp.php';
    
    class CommandHandler extends Database {
        public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
            $command = trim($args[0], $charlist = ":~");
            
            if($this->getCommandRanks($commander, $command) == "dummy") {
                new CommandDummy($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "eval") {
                new CommandEval($bot, $socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "register") {
                new CommandRegister($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "identify") {
                new CommandIdentify($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "die") {
                new CommandDie($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "quit") {
                new CommandQuit($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "reboot") {
                new CommandReboot($socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "db") {
                new CommandDb($bot, $socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "help") {
                new CommandHelp($bot, $socket, $commander, $rawmode, $chan, $args);
            }
            
            if($this->getCommandRanks($commander, $command) == "failed") {
                $socket->notice($commander, "you do not have access to this command");
            }
            
            /*old command limiter code
             switch($command) {
             case "dummy" :
                 new CommandDummy($socket, $commander, $rawmode, $chan, $args);
                 break;
                }
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
             case "help" :
                 new CommandHelp($bot, $socket, $commander, $rawmode, $chan, $args);
                 break;
            }*/
        }
     
        public function getRank($commander) {
            return $this->select($this->getConnectionSocket(), "SELECT rank FROM user WHERE nick='$commander'");
        }
        
        public function getCommandRanks($commander, $command) {
            $ranks = array(
                'owner', 
                'co-owner', 
                'admin', 
                'op', 
                'janitor', 
                'friend'
            );
            
            $currentrank = implode(" ", $this->getRank($commander));
            if($command == "dummy") {
                if(in_array($currentrank, $ranks)) {
                    return $command;
                } else {
                    return "failed";
                }
            } else {
                if($command == "eval") {
                    if(in_array($currentrank, $ranks)) {
                        if($currentrank == "owner" or $currentrank == "co-owner") {
                            return $command;
                        } else {
                            return "failed";
                        }
                    }
                } else {
                    if($command == "register") {
                        if(in_array($currentrank, $ranks)) {
                            if($currentrank == "friend") {
                                return "failed";
                            } else {
                                return $command;
                            }
                        }
                    } else {
                        if($command == "identify") {
                            if(in_array($currentrank, $ranks)) {
                                if($currentrank == "friend") {
                                    return "failed";
                                } else {
                                    return $command;
                                }
                            }
                        } else {
                            if($command == "die") {
                                if(in_array($currentrank, $ranks)) {
                                    if($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin") {
                                        return $command;
                                    } else {
                                        return "failed";
                                    }
                                }
                            } else {
                                if($command == "quit") {
                                    if(in_array($currentrank, $ranks)) {
                                        if($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin") {
                                            return $command;
                                        } else {
                                            return "failed";
                                        }
                                    }
                                } else {
                                    if($command == "reboot") {
                                        if(in_array($currentrank, $ranks)) {
                                            if($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin" or $currentrank == "op") {
                                                return $command;
                                            } else {
                                                return "failed";
                                            }
                                        }
                                    } else {
                                        if($command == "db") {
                                            if(in_array($currentrank, $ranks)) {
                                                if($currentrank == "owner" or $currentrank == "co-owner") {
                                                    return $command;
                                                } else {
                                                    return "failed";
                                                }
                                            }
                                        } else {
                                            if($command == "help") {
                                                return $command;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        public function ischan($str) {
            echo $str;
            if($str[0] == '#') {
                return true;
            } else {
                return false;
            }
        }
    }
?>
