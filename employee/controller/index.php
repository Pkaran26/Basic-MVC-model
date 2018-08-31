<?php
dirname(__DIR__);
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
            if($res==1){
               echo "success";
            }else{
              echo "try again";
            }
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
                <td><a href='update/".$data[$i]['id']."'>Update</a></td>
                <td><a href='delete/".$data[$i]['id']."'>Delete</a></td>
            </tr>";  
        }
    }

    public function delete($key){
        $res = $this->deleteData('employee', [$key]);
        if($res==1){
            echo "success";
        }else{
            echo "try again";
        }
        header('refresh:1;url=../show');
    }

    public function update($key){
        $data = $this->selectData('employee', $key);
        if(isset($data[0])){
            $ob = new FormBuilder('employee');
            $ob->generateForm($data);
            
            if (isset($_POST['formdata'])){
                echo $res = $this->updateData('employee',$key);
                if($res==1){
                echo "success";
                }else{
                echo "try again";
                }
                header('refresh:1;url=../show');
            }
        }else{
            header('location:../show');
        }
    }
}
?>