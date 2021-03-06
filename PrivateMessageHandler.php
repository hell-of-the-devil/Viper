<?php
    require_once 'libirc/Database.php';
    class PrivateMessageHandler {

        public function __construct(Bot $bot, Socket $socket, $commander, $args) {
            $command = trim($args[0], $charlist = ":");
            $active = Database::select_what_where("active", "user", "nick='$commander'");
            if($active['active']) {
                if ($this->getCommandRanks($commander, $command) == "login") {
                    new CommandLogin($bot, $socket, $commander, $args);
                }
            }

            if ($this->getCommandRanks($commander, $command) == "failed") {
                $socket->notice($commander, "you do not have access to this command");
            }
        }

        public function getRank($commander) {
            return Database::select_what_where("rank", "user", "nick='$commander'");
        }

        public function getCommandRanks($commander, $command) {
            $ranks = array(
                'owner',
                'co-owner',
                'admin',
                'op',
                'janitor',
                'friend'
            );

            $currentrank = implode(" ", $this->getRank($commander));
            if ($command == "login") {
                if ($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin" or $currentrank == "op" or $currentrank == "janitor" or $currentrank == "friend") {
                    return $command;
                } else {
                    return "failed";
                }
            } else {
                if ($command == "dummy") {
                    if (in_array($currentrank, $ranks)) {
                        return $command;
                    } else {
                        return "failed";
                    }
                } else {
                    if ($command == "eval") {
                        if (in_array($currentrank, $ranks)) {
                            if ($currentrank == "owner" or $currentrank == "co-owner") {
                                return $command;
                            } else {
                                return "failed";
                            }
                        }
                    } else {
                        if ($command == "register") {
                            if (in_array($currentrank, $ranks)) {
                                if ($currentrank == "friend") {
                                    return "failed";
                                } else {
                                    return $command;
                                }
                            }
                        } else {
                            if ($command == "identify") {
                                if (in_array($currentrank, $ranks)) {
                                    if ($currentrank == "friend") {
                                        return "failed";
                                    } else {
                                        return $command;
                                    }
                                }
                            } else {
                                if ($command == "die") {
                                    if (in_array($currentrank, $ranks)) {
                                        if ($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin") {
                                            return $command;
                                        } else {
                                            return "failed";
                                        }
                                    }
                                } else {
                                    if ($command == "quit") {
                                        if (in_array($currentrank, $ranks)) {
                                            if ($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin") {
                                                return $command;
                                            } else {
                                                return "failed";
                                            }
                                        }
                                    } else {
                                        if ($command == "reboot") {
                                            if (in_array($currentrank, $ranks)) {
                                                if ($currentrank == "owner" or $currentrank == "co-owner" or $currentrank == "admin" or $currentrank == "op") {
                                                    return $command;
                                                } else {
                                                    return "failed";
                                                }
                                            }
                                        } else {
                                            if ($command == "db") {
                                                if (in_array($currentrank, $ranks)) {
                                                    if ($currentrank == "owner" or $currentrank == "co-owner") {
                                                        return $command;
                                                    } else {
                                                        return "failed";
                                                    }
                                                }
                                            } else {
                                                if ($command == "help") {
                                                    return $command;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

?>
