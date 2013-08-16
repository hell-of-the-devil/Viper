<?php
require_once 'libirc/Database.php';
require_once 'libirc/Encryption.php';
require_once 'Tag.php';

class CommandDb extends Database {
    public function __construct(Bot $bot, Socket $socket, $commander, $rawmode, $chan, $args) {
        if(count($args) < 2) {
            $socket->notice($commander, Tag::getTag("Database").Reader::read_file("files/help/help_db"));
            return;
        }
        
        switch ($args[1]) {
            case "adduser" :
                if(count($args) > 1) {
                    if(!$bot->userCheck($args[2])) {
                        $socket->message($chan, Tag::getTag("Database")." Adding `$args[2]` to the datbase");
                        $this->insertinto("user", "nick='$args[2]'");
                        $socket->message($chan, Tag::getTag("Database")." Added $args[2] to database");
                    } else {
                        $socket->message($chan, Tag::getTag("Database")." $args[2] already exists on the database");
                    }
                } else {
                    $socket->message($chan, Tag::getTag("Database")." Usage :: ~db adduser <nick>");
                }
                break;
            case "edituser" :
                    if(count($args) > 2) {
                        if($bot->userCheck($args[2])) {
                            switch($args[3]) {
                                case "login" :
                                    $socket->notice($commander, Tag::getTag("Database")." Editing variable login on nick $args[2]");
                                    $this->update_where("user", "login='$args[4]'", "nick='$args[2]'");
                                    $socket->notice($commander, Tag::getTag("Database")." set login for $args[2] to $args[4]");
                                    break;
                                case "password" :
                                    $socket->notice($commander, Tag::getTag("Database")." Editing variable password on nick $args[2]");
                                    $args[4] = Encryption::SHA256($args[4]);
                                    $this->update_where("user", "password='$args[4]'", "nick='$args[2]'");
                                    $socket->notice($commander, Tag::getTag("Database")." set password for $args[2] to *****");
                                    break;
                                case "flags" :
                                    $socket->notice($commander, Tag::getTag("Database")." Editing variable flags on nick $args[2]");
                                    $this->update_where("user", "flags='$args[4]'", "nick='$args[2]'");
                                    $socket->notice($commander, Tag::getTag("Database")." set flags for $args[2] to $args[4]");
                                    break;
                                case "rank" :
                                    $oldrank = $this->getRank($args[2]);
                                    if($this->rankCheck($this->getRank($commander))) {
                                        $newrank = $args[4];
                                        if($this->rankCheck($newrank)) {
                                            if($this->rankupdown($oldrank, $newrank) == "up") {
                                                $socket->message($chan, Tag::getTag("Database")." Congrats $args[2], you just ranked up from $oldrank to $newrank");
                                                echo "up";
                                            } elseif($this->rankupdown($oldrank, $newrank) == "down") {
                                                $socket->message($chan, Tag::getTag("Database")." Fuck you $args[2], you have been deranked from $oldrank to $newrank for your incompetence");
                                                echo "down";
                                            } elseif($this->rankupdown($oldrank, $newrank) === null) {
                                                $socket->notice($commander, Tag::getTag("Database")." $args[2] is already a(n) $newrank");
                                                echo "null";
                                                return;
                                            } else {
                                                echo "fuck do i know how you got here :/";
                                                return;
                                            }
                                        } else {
                                            $socket->notice($commander, Tag::getTag("Database")." $newrank is not a valid rank....");
                                            return;
                                        }
                                    }
                                    $this->update_where("user", "rank='$args[4]'", "nick='$args[2]'");
                                    break;
                                }
                            } else {
                                $socket->notice($commander, Tag::getTag("Database")." $args[2] is not listed on the database");
                            }
                    } else {
                        $socket->notice($commander, Tag::getTag("Database")." Not enough Parameters Defined.");
                    }
                break;
            case "viewuser" :
                if($bot->userCheck($args[2])) {
                    $socket->message($chan, Tag::getTag("Database")." Retreiving stats for $args[2]");
                    $data = $this->select_all_where("user", "nick='$args[2]'");
                    $socket->message($chan, Tag::getTag("Database")." UserID ".Dec::purple.">>".Dec::orange." ".$data['id']);
                    $socket->message($chan, Tag::getTag("Database")." Nick ".Dec::purple.">>".Dec::orange." ".$data['nick']);
                    $socket->message($chan, Tag::getTag("Database")." Login ".Dec::purple.">>".Dec::orange." ".$data['login']);
                    $socket->message($chan, Tag::getTag("Database")." Password ".Dec::purple.">>".Dec::orange." ".$data['password']);
                    $socket->message($chan, Tag::getTag("Database")." Flags ".Dec::purple.">>".Dec::orange." ".$data['flags']);
                    $socket->message($chan, Tag::getTag("Database")." Rank ".Dec::purple.">>".Dec::orange." ".$data['rank']);
                } else {
                    $socket->message($chan, Tag::getTag("Database")." $args[2] is not listed on the database");
                }
                break;
            case "remuser" :
                if($bot->userCheck($args[2])) {
                    $socket->notice($commander, Tag::getTag("Database")." Attempting to delete $args[2] permanently");
                    $this->delete("user", "nick='$args[2]'");
                    $socket->notice($commander, Tag::getTag("Database")." $args[2] account deleted permanently...");
                } else {
                    $socket->message($chan, Tag::getTag("Database")." $args[2] is not listed on the database");
                }
                break;
            case "listusers" :
                $socket->message($chan, Tag::getTag("Database")." Checking UserList");
                $data = $this->select_what("nick", "user");
                foreach ($data as $k) {
                    $socket->message($chan, Tag::getTag("Database")." NICK : ".$k['nick']);
                }
                break;
        }
    }
    
    public function rankCheck($str) {
        $ranks = array(
            'owner',
            'co-owner',
            'admin',
            'op',
            'janitor',
            'friend'
        );
        
        for($i = 0; $i < count($ranks); $i++) {
            if($str == $ranks[$i]) {
                echo "TRUE \n";
                return true;
            }
        }
    }
    
    public function getRank($commander) {
        $rank = $this->select_what_where("rank", "user", "nick='$commander'");
        return implode(" ", $rank);
    }
    
    public function rankupdown($oldrank, $newrank) {
        switch($oldrank) {
            case "owner" :
                if($newrank == "owner") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "co-owner" :
                if($newrank == "owner") {
                    return "up";
                } elseif ($newrank == "co-owner") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "admin" :
                if($newrank == "owner" or $newrank == "co-owner") {
                    return "up";
                } elseif($newrank == "admin") {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "op" :
                if($newrank == "owner" or $newrank == "co-owner" or $newrank == "admin") {
                    return "up";
                } elseif($newrank == $oldrank) {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "janitor" :
                if($newrank == "owner" or $newrank == "co-owner" or $newrank == "admin" or $newrank == "op") {
                    return "up";
                } elseif($newrank == $oldrank) {
                    return null;
                } else {
                    return "down";
                }
                break;
            case "friend" :
                if($newrank == $oldrank) {
                    return null;
                } else {
                    return "up";
                }
                break;
            case "" :
                return "up";
                break;
        }
    }
}
?>