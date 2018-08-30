<?php
class Connect{
    private $conn;

    function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=formbuilder","root","");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function ProcessQuery($sql,$value){
        $st = $this->conn->prepare($sql);
        return $st->execute($value);
    }

    function ProcessQuery2($sql,$value){
        $st = $this->conn->prepare($sql);
        $st->execute($value);
        $last_id = $this->conn->lastInsertId();
        if($last_id){
            return $last_id;
        }
        return 0;
    }

    function select_data($sql,$value){
        $st = $this->conn->prepare($sql);
        $st->execute($value);
        if($st->rowCount()){
            return $st->fetchAll();
        }else{
            return 0;
        }
    }

    function checkData($sql, $value){
        $st = $this->conn->prepare($sql);
        $st->execute($value);
        if($st->rowCount()){
            return 1;
        }else{
            return 0;
        }
    }

    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}
?>