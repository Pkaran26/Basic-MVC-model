<?php
    if (isset($_GET['page'])){
        if(file_exists($_GET['page'])){
            $page = $_GET['page'];
            header("location:".$page."/");
        }else{
            header("location:http://localhost/Form Builder 2.0/");
        }
    }
?>