<?php
require_once 'Tag.php';
class CommandEval {
    public function __construct(CommandHandler $ch, Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        ob_start();
        eval(implode(" ", array_slice($args, 1)));
        $returned = ob_get_clean();
        $socket->message($chan, Tag::getTag("Evaluation")." ".$returned);
    }
}
?>
