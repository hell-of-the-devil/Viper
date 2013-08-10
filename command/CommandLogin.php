<?php
    class CommandLogin extends Database {
        public function __construct(Socket $socket, $commander, $args) {
            if($chan === NULL) {
                var_dump($args);
            } else {
                $socket->notice($commander, Dec::bold.Dec::dgreen."[".Dec::dgray."AUTHSERV".Dec::dgreen."]".Dec::bold.Dec::orange." This command is pm execution only");
            }
        }
    }
?>
