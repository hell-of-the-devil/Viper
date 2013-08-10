<?php
    class HashCheck {
        public function check($pass, $hash) {
            if(password_verify($pass, $hash)) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
