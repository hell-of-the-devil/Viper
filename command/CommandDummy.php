<?php
require_once 'Dec.php';
require_once 'RandomString.php';
class CommandDummy {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $randstr = new RandomString(10);
        $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Dummy".Dec::dgreen."]".Dec::bold.Dec::orange."This is a dummy command");
        $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Random String".Dec::dgreen."]".Dec::bold.Dec::orange.$randstr);
    }
}
?>
