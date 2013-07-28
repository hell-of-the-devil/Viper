<?php
class CommandReboot {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->message($chan, "$commander requested I reboot");
        $socket->close();
        $socket->createSocket();
        $socket->connect();
    }
}
?>