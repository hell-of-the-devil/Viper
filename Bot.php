<?php
    class Bot {
        public function __construct(Socket $socket) {
            while(true) {
                $read = array($socket->getSocket());
                $n = null;
                
                if(socket_select($read, $n, $n, 0) > 0) {
                    $raw = socket_read($socket->getSocket(), 1024);
                    echo $raw;
                    $from = explode(" ", $raw);
                    
                    if($from[0] === "PING") {
                        $socket->write("PONG ".$from[1]);
                    }
                }
            }
        }
    }
?>