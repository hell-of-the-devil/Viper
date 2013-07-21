<?php
require_once 'Dec.php';
class CommandDie {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Die".Dec::dgreen."]".Dec::bold.Dec::orange."DIS SHIT IS GOING DOWN!");
        die();
    }    
}
?>
