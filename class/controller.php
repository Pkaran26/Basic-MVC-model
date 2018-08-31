<?php
require_once('config.php');

class Controller{
    protected $ob;

    public function __construct(){
        $this->ob = new Connect();
    }

    public function submitData($tablename){
        $values = $this->getFormFields($tablename);
        $fields = $this->getTableFields($tablename);
        $sql = "insert into ".$tablename."(";
            $quest = "";
            for($i=1;$i<count($fields);$i++){
                $sql .= $fields[$i].", ";
                $quest .= "?, ";
            }
            $sql = substr($sql,0,strlen($sql)-2).") values (".substr($quest,0,strlen($quest)-2).")";
         //print_r($values);
              return $this->ob->ProcessQuery($sql, $values);
    }

    public function updateData($tablename, $key){
        $values = $this->getFormFields($tablename);
        $fields = $this->getTableFields($tablename);
        $sql = "update ".$tablename." set ";
            for($i=1;$i<count($fields);$i++){
                $sql .= $fields[$i]." = ?, ";
            }
            $sql = substr($sql,0,strlen($sql)-2)." where ".$fields[0]." = ?";
            array_push($values, $key);
            return $this->ob->ProcessQuery($sql, $values);
    }

    public function deleteData($tablename, $key){
        $sql = "delete from ".$tablename." where id = ?";
          return $this->ob->ProcessQuery($sql, $key);
    }

    public function selectData($tablename, $key=null, $fields=null){
        if (empty($fields)){
            $fields = $this->getTableFields($tablename);
        }
        $sql = "select ";
        for($i=0;$i<count($fields);$i++){
            $sql .= $fields[$i].", ";
        }
        $sql = substr($sql,0,strlen($sql)-2)." from ".$tablename;
        if(!empty($key)){
            $sql .= " where ".$fields[0]." = ?";
            return $this->ob->select_data($sql,[$key]);
        }else{
            return $this->ob->select_data($sql,[]);
        }
    }

    public function getFields($table){
        $sql = "SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? and TABLE_SCHEMA = ?";
        return $this->ob->select_data($sql,[$table,$this->ob->db]);
    }

    public function getFormFields($table){
        $fields = $this->getFields($table);
        $data = [];
        for($i=1;$i<count($fields);$i++){
            array_push($data, $_POST[$fields[$i][0]]);
        }
        return $data;
    }

    public function getTableFields($table){
        $fields = $this->getFields($table);
        $data = [];
        for($i=0;$i<count($fields);$i++){
            array_push($data, $fields[$i][0]);
        }
        return $data;
    }
}
?>