<?php
class CommandQuit {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->close();
        die();
    }
}
?>
