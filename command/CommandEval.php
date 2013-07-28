<?php
require_once 'Dec.php';
class CommandEval {
    public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        ob_start();
        eval(implode(" ", array_slice($args, 1)));
        $returned = ob_get_clean();
        $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."Evaluation".Dec::dgreen."] ".Dec::bold.Dec::orange.$returned);

    }
}
?>
