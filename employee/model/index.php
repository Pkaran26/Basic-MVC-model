<?php
        require_once("../../class/models.php");
        class employee{
            private $Object;
            public function __construct(){
                $this->Object = new Models();
                $this->Object->genMeta($this->MetaData(), get_class());
            }
        
            private function MetaData(){
                $meta = [];
               
               //Meta Data Examples
                $meta[0] = $this->Object->primaryKeyField("id", 10);
                $meta[1] = $this->Object->textField("name");
                $meta[2] = $this->Object->textField("Course");
                $meta[3] = $this->Object->dateField("dob", "NOT NULL");
                $meta[4] = $this->Object->charField("grade",2);
                $meta[5] = $this->Object->passwordField(25);
               // $meta[6] = $this->Object->foreignKeyField("userid", "users", "id");
                
                return $meta;
            }
        }
        $ob = new employee();
        header("Refresh:1; url=../");
        ?>