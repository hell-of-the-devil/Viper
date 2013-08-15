<?php
require_once 'Tag.php';
class CommandDie {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->write("PRIVMSG $chan :".Tag::getTag("Die")." DIS SHIT IS GOING DOWN!");
        die();
    }    
}
?>
