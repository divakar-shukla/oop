<?php

class Database{

   private $host = "localhost";
   private $user_name = "root";
   private $db_pass = "";
   private $db_name = "user";

   private $mysqli = "";
   private $result = array();
   private $conn = false;
   public function __construct(){
    if(!$this->conn){
        $this->mysqli = new mysqli($this->host, $this->user_name, $this->db_pass, $this->db_name);
        if($this->mysqli->connect_error){
            array_push($this->result, $this->mysqli->connect_error);
            // echo $this->result;
            return false;
        }else{
            $this->conn = true;
            return true;
        }
    }
   }

   
   public function insert($table, $params= array()){
       if($this->table_exists($table)){
        //    print_r($params);
           $column_name = implode(",", array_keys($params));
           $column_value = implode(" ','", $params);
           $sql = "INSERT INTO $table ($column_name) VALUES ('$column_value')";
           if($this->mysqli->query($sql)){
            array_push($this->result, $this->mysqli->insert_id);
            return true;
           }else{
            array_push($this->result, $this->mysqli->error);
            return false;
           }

        }
        
    }
    

    public function getResult(){
        $value = $this->result;
        $this->result = array();
        return $value;
    }
    
    public function update($table, $params, $where = null){

        if($this->table_exists($table)){
        $setValues = array();
          foreach($params as $keys=>$values){
            array_push($setValues, "$keys = '$values'");
          }
           $setquery = implode(", ", $setValues);
         echo $sql = "UPDATE $table SET $setquery WHERE $where";

        
          if($this->mysqli->query($sql)){
            // echo "Updated succesfully";
          }else{
            echo $this->mysqli->error;
          }

    }else{
        array_push($this->result, $this->mysqli->error);
        return false;
       }
    }


    public function select($table, $column = " * ", $join = null, $where = null, $order = null, $limit = null){
        if($this->table_exists($table)){
            $sql = "SELECT $column FROM $table";
            $queryData = $this->mysqli->query($sql);
            if($queryData){
                $this->result = $queryData->fetch_all();
                // echo"<pre>";
                // print_r($this->result);
                // echo"</pre>"; 7
                return true;
            }else{
                echo $this->mysqli->error;
                return false;
            }
        }
    }
    
    public function delete($table, $where){
        if($this->table_exists($table)){
            $sql = "DELETE FROM $table WHERE $where";
            if($this->mysqli->query($sql)){
                echo " Data Deleted";
            }
        }else{
            array_push($this->result, $table_name . "is not exist in this database");
            return false;
        }
      }
     
       private function table_exists($table_name){
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table_name'";
        $tableINdb = $this->mysqli->query($sql);
        // print_r($tableINdb->num_rows);
        if($tableINdb->num_rows == 1){
            return true;
    
        }else{
            array_push($this->result, $table_name . "is not exist in this database");
            return false;
        }
      }
   public function __destruct(){
    if($this->conn){
        if($this->mysqli->close()){
            $this->conn = false;
            return true;
        }
    }else{
        return false;
    }
   }
}

?>


