<?php
require_once 'Dec.php';
class CommandIdentify {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
         $socket->write("PRIVMSG nickserv :identify ".$socket->config['nspass']);
         $socket->write("PRIVMSG $chan :".Dec::bold.Dec::dgreen."[".Dec::dgray."Identification".Dec::dgreen."]".Dec::bold.Dec::orange." Identified to NickName Services (Alias: NickServ)");
    }
}
?>
