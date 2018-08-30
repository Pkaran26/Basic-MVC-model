<?php
    require_once('config.php');
    class FormBuilder{
        private $tableInfo="";
        private $fields = array();
        private $ob;
        private $table="";
        private $dt = array(
            'varchar'=>'text',
            'int' => "number",
            'date' => 'date',
            'datetime' => 'datetime-local',
            'char' => 'text'
        );
        function __construct($table){
            $this->ob = new Connect();
            $this->table = $table;
            $sql = "SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? and TABLE_SCHEMA = ? and COLUMN_NAME != 'id'";
            $this->tableInfo = $this->ob->select_data($sql,[$this->table,'formbuilder']);
            //print_r($this->tableInfo);
        }

        function generateForm(){
            $x = count($this->tableInfo);
            if($x>1){
                $form = "<div>
                <form action='../class/submit.php' method='post'>
                <table>";
                for($i=0;$i<$x;$i++){
                    $form .= "<tr>";
                    $form .= $this->inputs($this->tableInfo[$i]["COLUMN_NAME"], $this->tableInfo[$i]["DATA_TYPE"]);
                    $form .= "</tr>";
                }
                echo $form .= "<tr><td></td><td><input type='submit' name='formdata' value='submit' />
                </td></tr>
                </table>
                </form></div>";
            }else{
                return 0;
            }
        }

        function inputs($fname, $type){
            $str = "";
            if($fname=="password"){
                $str = "password";
            }else{
                $str = $this->replaceDatatype($type);
            }
            return $str = "<td>".$fname."</td>
            <td><input type='".$str."' name='".$fname."' required='required' /></td>";
        }

        function replaceDatatype($type){
            if (array_key_exists($type, $this->dt)){
                return $this->dt[$type];
            }else{
                $this->dt['varchar'];
            }
        }
        function getFields(){
            $x = count($this->tableInfo);
            for($i=0;$i<$x;$i++){
                array_push($this->fields, $this->tableInfo[$i]["COLUMN_NAME"]);
            }
            return $this->fields;
        }
        function setFormData($data){
            $sql = "insert into ".$this->table."(";
            $quest = "";
            foreach($this->fields as $f){
                $sql .= $f.", ";
                $quest .= "?, ";
            }
            $sql = substr($sql,0,strlen($sql)-2).") values (".substr($quest,0,strlen($quest)-2).")";
            return $this->ob->ProcessQuery($sql, $data);
        }
    }
?>