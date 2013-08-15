<?php
    class HashCheck {
        public static function check($pass, $hash) {
            var_dump($hash['password']);
            if(password_verify($pass, $hash['password'])) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
