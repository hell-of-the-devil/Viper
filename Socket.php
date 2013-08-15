<?php
    require 'Authentication.php';
    require 'Bot.php';
    
    class Socket {
        public $bot;
        public $config = array(
            'server'    =>  '92.24.11.204', //irc server to connect to
            'port'      =>  '6667', //server port
            'nick'      =>  'Viper', //nick
            'user'      =>  'Viper', //username
            'name'      =>  'o0 Viper 0o', //realname
            'cmdid'     =>  '~', //command trigger character
            'email'     =>  'viper@null.null', //email to register with
            'nspass'    =>  'vIpErRuLeS', //password to register and identify with
        );
        
        private $socket;
        public static $autoexec = 0;
        
        public function __construct() {
            $this->createSocket();
            $this->connect();
            $this->bot = new Bot($this);
        }
        
        public function loadOnStart() {
            $this->write("MODE ".$this->config['nick']." +B");
            $this->message("nickserv", "identify ".$this->config['nspass']);
        }
        
        public function createSocket() {
            return $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        }
        
        public function connect() {
            $connect = socket_connect($this->getSocket(), $this->config['server'], $this->config['port']);
            if ($connect == true) {
                new Authentication($this);
            } else {
                echo "Failed to connect to server!";
                die();
            }
        }
        
        public function close() {
            socket_close($this->getSocket());
        }
        
        public function getSocket() {
            return $this->socket;
        }
        
        public function write($str) {
            socket_write($this->getSocket(), $str."\n");
        }
        
        public function message($dest, $contents) {
            foreach(explode("\n", $contents) as $s) {
                $this->write("PRIVMSG $dest :".$s);
            }
        }
        
        public function notice($dest, $contents) {
            foreach(explode("\n", $contents) as $s) {
                $this->write("NOTICE $dest :".$s);
            }
        }
        
        public function ready() {
            $read = array($this->getSocket());
            $n = null;
            if (socket_Select($read, $n, $n, 0) > 0) return true;
            else return false;
        }
        
        public function read() {
            $r = socket_read($this->getSocket(), 1024, PHP_NORMAL_READ);
            return $r;
        }
    }
    
    new Socket();
?>
