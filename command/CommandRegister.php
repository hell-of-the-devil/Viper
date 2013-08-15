<?php
require_once 'Tag.php';
class CommandRegister {
    public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
        $socket->write("PRIVMSG nickserv :register ".$socket->config['nspass']." ".$socket->config['email']);
        $socket->write("PRIVMSG $chan :".Tag::getTag("Register")." Registered to Nickname services (Alias: nickserv)");
    }
}
?>
