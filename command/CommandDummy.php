<?php
require_once 'RandomString.php';
class CommandDummy {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $randstr = new RandomString(10);
        $socket->write("PRIVMSG $chan :".Tag::getTag("Random String")." This is a dummy command");
        $socket->write("PRIVMSG $chan :".Tag::getTag("Random String")." ".$randstr);
    }
}
?>
