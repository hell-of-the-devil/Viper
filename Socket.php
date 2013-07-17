<?php
    require 'Authentication.php';
    require 'Bot.php';
    
    class Socket {
        public $config = array(
            'server'    =>  '92.24.11.204',
            'port'      =>  '6667',
            'nick'      =>  'Viper',
            'user'      =>  'Viper',
            'name'      =>  'o0 Viper 0o'
        );
        private $socket;

        public function __construct() {
            $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $connect = socket_connect($this->getSocket(), $this->config['server'], $this->config['port']);
            if ($connect == true) {
                new Authentication($this);
            } else {
                echo "Failed to connect to server!";
                die();
            }
            $bot = new Bot($this);
        }
        
        public function getSocket() {
            return $this->socket;
        }
        
        public function write($str) {
            socket_write($this->getSocket(), $str."\n");
        }
    }
    
    new Socket();
?>
