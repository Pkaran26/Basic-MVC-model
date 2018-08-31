<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MVC</title>
</head>
<body>
<?php
$base = str_replace('\\', '/', __DIR__)."/";

$controller_path = "/controller/index.php";
if(isset($_GET['url'])){
    $url = $_GET['url'];

    $url = explode("/", $url);
    if(isset($url[0])){
        require_once ($base.$url[0].$controller_path);
        $ob = new $url[0]();
       // $ob->index();
        if(isset($url[1]) && !empty($url[1])){
            $ob->$url[1]();
        }
    }
}

//print_r($url);
?>
</body>
</html>