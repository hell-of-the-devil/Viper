<?php
    require 'CommandHandler.php';
    class Bot {
        public function __construct(Socket $socket) {
            while(true) {
                $read = array($socket->getSocket());
                $n = null;
                
                if($socket->ready()) {
                    $raw = $socket->read();
                    if (trim($raw) == "") continue;
                    
                    echo $raw;
                    $from = explode(" ", trim($raw));
                                        
                    if($from[0] === "PING") {
                        $socket->write("PONG ".$from[1]);
                    }
                    //Data Handler :hell-of-the-dev!Hell@EABCCCEA.69AF8BC5.A3113BC8.IP PRIVMSG #hell :lalalalal
                    if($from[1] == "PRIVMSG") {
                        $commander = $this->getCommander($from[0]);
                        $rawmode = $from[1];
                        $cich = str_split($from[2]);

                        if($cich[0] === '#') {
                            $channel = $from[2];
                        } else {
                            $channel = null;
                        }
                        $args = array_slice($from, 3);
                        $cic = str_split($args[0]);
                        
                        if($cic[1] === $socket->config['cmdid']) {
                            new CommandHandler($socket, $commander, $rawmode, $channel, $args);
                        }
                    }
                }
            }
        }
        
        public function getCommander($str) {
            return ltrim(implode("", array_slice(explode("!", $str, 2), 0, 1)), ":");
        }
    }
?>