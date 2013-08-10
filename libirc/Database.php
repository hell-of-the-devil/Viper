<?php
class Database {    
    public function connection() {
        $this->socket = mysqli_connect("127.0.0.1", "viper", "ViPeRbOt", "viper");
    }
    
    public function select_all ($table) {
        $connection = $this->getConnectionSocket();
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
    
    public function select_what($what, $table) {
        $connection = $this->getConnectionSocket();
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

    public function select_all_where($table, $where) {
        $connection = $this->getConnectionSocket();
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
    
    public function select_what_where($what, $table, $where) {
        $connection = $this->getConnectionSocket();
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
    
    //INSERT INTO user set nick='$args[2]', login=' ', password=' ' , flags=' ', rank=' ';
    public function insertinto($table, $args) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, "INSERT INTO $table SET $args");
        if (!$result) {
            echo 'MySQL query error: '. mysqli_error($connection);
            return;
        }
    }
    
    //UPDATE user SET login='$args[4]' where nick='$args[2]'
    public function update($table, $what) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, "UPDATE $table SET $what");
        if(!$result) {
            echo 'MySQL query error: '.  mysqli_error($connection);
            return;
        }
    }
    
    public function update_where($table, $what, $where) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, "UPDATE $table SET $what WHERE $where");
        
        if(!$result) {
            echo 'MySQL query error: '.mysqli_error($connection);
            return;
        }
    }
    
    //DELETE FROM user WHERE nick='$args[2]'
    public function delete($table, $args0) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, "DELETE FROM $table where $args0");

        if(!$result) {
            echo 'MySQL query error: '.mysqli_error($connection);
            return;
        }
    }
    
    public function getConnectionSocket() {
        $this->connection();
        return $this->socket;
    }
    
    public function ConnectionClose() {
        return mysqli_close($this->getConnectionSocket());
    }
}
?>