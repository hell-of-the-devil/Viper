<?php
    class FileManager {        
        public static function func_001($file) { //file exists check
            if(file_exists($file)) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
