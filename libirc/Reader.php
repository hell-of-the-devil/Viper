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
    
    public static function read_file($file) {
        if(file_exists($file)) {
            if(is_readable($file)) {
                return file_get_contents($file);
            } else {
                echo "Could not read $file, file seems to be corrupted";
            }
        } else {
            echo "Could not read $file, file is missing";
        }
    }
    
    public static function read_file_by_line($file) {
        $str = self::read_file($file);
        $str = explode("\n", $str);
        return $str;
    }
}
?>
