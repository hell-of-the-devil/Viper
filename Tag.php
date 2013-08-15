<?php
    require_once 'Dec.php';
    class Tag {
        public static function getTag($str) {
            return Dec::bold.Dec::dgreen."[".Dec::dgray.$str.Dec::dgreen."]".Dec::orange;
        }
    }
?>
