<?php
class Reader {
    public static function readini($file) {
        if(file_exists($file) && is_readable($file)) {
            $settings = parse_ini_file($file, true);
            return $settings;
        } else {
            return "Cannot Parse Ini File";
        }
    }
    
    public function readfile($file) {
        if(file_exists($file) && is_readable($file)) {
            $data = readfile($file);
            $lines = array(read);
        }
    }
}
?>
