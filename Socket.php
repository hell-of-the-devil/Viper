<?php
    require 'Authentication.php';
    require 'Bot.php';
    
    class Socket {
        public $bot;
        public $config = array(
            'server'    =>  '92.24.11.204',
            'port'      =>  '6667',
            'nick'      =>  'Viper',
            'user'      =>  'Viper',
            'name'      =>  'o0 Viper 0o',
            'cmdid'     =>  '~',
            'email'     =>  'hell_of_the_devil@hotmail.co.uk',
            'nspass'    =>  'hello-fuckers',
            'owners'    =>  array('hell-of-the-dev', 'JoshG')
        );
        
        private $socket;

        public function __construct() {
            $this->createSocket();
            $this->connect();
            $this->bot = new Bot($this);
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
            foreach (explode("\n", $contents) as $s) {
                $this->write("PRIVMSG $dest :".$s);
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
