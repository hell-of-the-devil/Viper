<?php
    class Encryption {
        public static function SHA256($str) {
            $str = password_hash($str, PASSWORD_DEFAULT);
            return $str;
        }
    }
?>
