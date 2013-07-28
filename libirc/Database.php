<?php
class Database {    
    public function connection() {
        $this->socket = mysqli_connect("192.168.1.70", "viper", "1029adc", "viper");
    }
    
    public function select($connection, $query) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, $query);
        if (!$result) {
            echo 'MySQL query error: '.  mysqli_error($this->getConnectionSocket());
            return;
        }
        return mysqli_fetch_assoc($result);
    }
    
    public function insert($connection, $query) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, $query);
        if (!$result) {
            echo 'MySQL query error: '. mysqli_error($this->getConnectionSocket());
            return;
        }
    }
    
    public function update($connection, $query) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, $query);
        if(!$result) {
            echo 'MySQL query error: '.  mysqli_error($this->getConnectionSocket());
            return;
        }
    }
    
    public function delete($connection, $query) {
        $connection = $this->getConnectionSocket();
        $result = mysqli_query($connection, $query);
        
        if(!$result) {
            echo 'MySQL query error: '.mysqli_error($this->getConnectionSocket());
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
