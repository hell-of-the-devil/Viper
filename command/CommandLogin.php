<?php
    require_once 'libirc/HashCheck.php';
    require_once 'Tag.php';
    class CommandLogin extends Database {
        public function __construct(Bot $bot, Socket $socket, $commander, $args) {
            $login = $args[1];
            $pass = $args[2];
            
            if(count($args) < 3) {
                $socket->notice($commander, Tag::getTag("AuthServ")." Usage >> login <login> <password>");
                return;
            }
            
            if($bot->userCheck($commander)) {
                $getlogin = Database::select_what_where("login", "user", "nick='$commander'");
                if($getlogin['login'] == $login) {
                    if(HashCheck::check($pass, Database::select_what_where("password", "user", "nick='$commander'"))) {
                        Database::update_where("user", "active='true'", "nick='$commander'");
                        $socket->message($commander, Tag::getTag("AuthServ")." You have logged in as $login");
                    } else {
                        $socket->message($commander, "HASHCHECK");
                        $socket->message($commander, Tag::getTag("AuthServ")." Invalid username and/or password");
                    }
                } else {
                    $socket->message($commander, "LOGINCHECK");
                    $socket->message($commander, Tag::getTag("AuthServ")." Invalid username and/or password");
                }
            } else {
                $socket->message($commander, Tag::getTag("AuthServ")." Your Nick is not listed on the Database $commander");
            }
        }
    }
?>
