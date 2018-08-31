<?php
dirname(__DIR__);
//$base = str_replace('\\', '/', __DIR__)."/<br/>";
//echo $_SERVER['HTTP_HOST']."/<br/>";
require_once('class/controller.php');
require_once("class/formBuilder.php");

class Employee extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        echo "this is index";
    }

    public function form(){
        $ob = new FormBuilder('employee');
        $ob->generateForm();
    
        if (isset($_POST['formdata'])){
            echo $res = $this->submitData('employee');
          /*  if($res==1){
               echo "success";
            }else{
              echo "try again";
            }*/
        }
    }

    public function show(){
        $data = $this->selectData('employee');
       // print_r(array_keys($data[0]));
        echo "<table>";
        for($i=0;$i<count($data);$i++){
            echo "<tr>
                <td>".$data[$i]['name']."</td>
                <td>".$data[$i]['Course']."</td>
                <td>".$data[$i]['dob']."</td>
                <td>".$data[$i]['grade']."</td>
            </tr>";  
        }
    }
}
?>