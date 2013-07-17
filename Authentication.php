<?php
    class Authentication {
        public function __construct(Socket $socket) {
            $socket->write("NICK ".$socket->config['nick']);
            $socket->write("USER ".$socket->config['user']." 0 * :".$socket->config['name']);
        }
    }
?>
