<?php
    require_once 'FileManager.php';
    
    class Writer {
        public static function write_file($file, $str) {
            file_put_contents($file, $str);
            echo "Wrote `$str` to `$file`";
        }
        
        public static function append_file($file, $str) {
            if(FileManager::func_001($file)) {
                $open = fopen($file, 'a');
                fwrite($open, $str."\n");
                fclose($open);
            } else {
                echo "failed to append file `$file`";
            }
        }
    }
?>
