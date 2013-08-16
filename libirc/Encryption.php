<?php
    class Encryption {
        public static function SHA256($str) {
            $str = sha1($str);
            return $str;
        }
    }
?>
