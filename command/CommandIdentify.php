<?php
require_once 'Tag.php';
class CommandIdentify {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
         $socket->write("PRIVMSG nickserv :identify ".$socket->config['nspass']);
         $socket->write("PRIVMSG $chan :".Tag::getTag("Identify")." Identified to NickName Services (Alias: NickServ)");
    }
}
?>
