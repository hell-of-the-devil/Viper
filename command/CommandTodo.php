<?php
    require_once 'libirc/Writer.php';
    class CommandTodo {
        public function __construct(Socket $socket, $commander, $rawmode, $chan, $args) {
            if(count($args) > 1) {
                switch ($args[1]) {
                    case "read" :
                        $str = Reader::read_file_by_line("files/todo/todo.TODO");
                        if($str[0] != "") {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."TOFO".Dec::dgreen."]".Dec::bold.Dec::orange." ".$str[0]);
                        } else {
                            $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."TODO".Dec::dgreen."]".Dec::bold.Dec::orange." Shit boy, you ain't got shit to do");
                        }
                        break;

                    case "write" :
                        Writer::append_file("files/todo/todo.TODO", implode(" ", array_slice($args, 2))."\n");
                        $socket->message($chan, Dec::bold.Dec::dgreen."[".Dec::dgray."TODO".Dec::dgreen."]".Dec::bold.Dec::orange." Added `".implode(" ", array_slice($args, 2))."` to `TODO` list");
                        break;
                }
            }
        }
    }
?>
