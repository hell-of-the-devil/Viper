<?php
class Database {
    public static function getConnectionSocket() {
        $socket = mysqli_connect("127.0.0.1", "mysql login", "mysql password", "Database");
        return $socket;
    }
    
    public static function select_all ($table) {
        $connection = self::getConnectionSocket();
        $result = mysql_query($connection, "SELECT * FROM $table");
        
        if(!$result) {
            echo 'MySQL query error: '. mysqli_error($connection);
            return;
        }
        
        if($result->numrows == 1) {
            return mysqli_fetch_assoc($result);
        } else {
            if ($result->numrows > 1) {
                $r = array();
                while ($row = $result->fetch_assoc()) {
                    $r[] = $row;
                }
                return $r;                
            }
        }
    }
    
    public static function select_what($what, $table) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "SELECT $what FROM $table");
        
        if (!$result) {
            echo 'MySQL query error: '.  mysqli_error($connection);
            return;
        }

        if ($result->num_rows == 1)  {
            return mysqli_fetch_assoc($result);
        } else {
            if ($result->num_rows > 1) {
            $r = array();
                while ($row = $result->fetch_assoc()) {
                    $r[] = $row;
                }
            return $r;
            }
        }
    }

    public static function select_all_where($table, $where) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "SELECT * FROM $table WHERE $where");
        
        if(!$result) {
            echo 'MySQL query error: '.  mysqli_error($connection);
            return;
        }
        
        if($result->num_rows == 1) {
            return mysqli_fetch_assoc($result);
        } else {
            if($result->num_rows > 1) {
                $r = array();
                while($row = $result->fetch_assoc()) {
                    $r[] = $row;
                }
                return $r;
            }
        }
    }
    
    public static function select_what_where($what, $table, $where) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "SELECT $what FROM $table WHERE $where");
        
        if(!$result) {
            echo 'MySQL query error: '.  mysqli_error($connection);
            return;
        }
        
        if($result->num_rows == 1) {
            return mysqli_fetch_assoc($result);
        } else {
            if($result->num_rows > 1) {
                $r = array();
                while($row = $result->fetch_assoc()) {
                    $r[] = $row;
                }
                return $r;
            }
        }
    }
    
    public static function insertinto($table, $args) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "INSERT INTO $table SET $args");
        if (!$result) {
            echo 'MySQL query error: '. mysqli_error($connection);
            return;
        }
    }
    
    public static function update($table, $what) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "UPDATE $table SET $what");
        if(!$result) {
            echo 'MySQL query error: '.  mysqli_error($connection);
            return;
        }
    }
    
    public static function update_where($table, $what, $where) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "UPDATE $table SET $what WHERE $where");
        
        if(!$result) {
            echo 'MySQL query error: '.mysqli_error($connection);
            return;
        }
    }
    
    public static function delete($table, $args0) {
        $connection = self::getConnectionSocket();
        $result = mysqli_query($connection, "DELETE FROM $table where $args0");

        if(!$result) {
            echo 'MySQL query error: '.mysqli_error($connection);
            return;
        }
    }
    
    public static function ConnectionClose() {
        return mysqli_close(self::getConnectionSocket());
    }
}
?>