<?php
    class HashCheck {
        public static function check($pass, $hash) {
            $pass = sha1($pass);
            
            if($pass == $hash) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
