<?php
    require_once('formBuilder.php');
    if (isset($_POST['formdata'])){
        $ob = new FormBuilder('employee');
        $fields = $ob->getFields();
        $data = array();
        for($i=0;$i<count($fields);$i++){
            array_push($data, $_POST[$fields[$i]]);
        }
        echo $res = $ob->setFormData($data);
        if($res==1){
            echo "<script>
                alert('Submitted');
                window.location.href = '../index.php';
            </script>";
        }else{
            echo "<script>
            alert('try again!');
            window.location.href = '../index.php';
        </script>";
        }
    }else{
        header("Refresh:1; url=../index.php");
    } 
?>