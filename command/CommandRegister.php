<?php
require_once 'Dec.php';
class CommandRegister {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->write("PRIVMSG nickserv :register".$socket->config['email']." ".$socket->config['nspass']);
        $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Registration".Dec::dgreen."]".Dec::bold.Dec::orange."Registered to Nickname services (Alias: nickserv)");
    }
}
?>
