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
        if($url[0]=="CreateApp"){
            if(isset($url[1])){
                require_once($base."/class/create.php");
                $create = new $url[0]($url[1]);
                echo $url[1]." app created";
            }
            return FALSE;
        }
        require_once ($base.$url[0].$controller_path);
        $ob = new $url[0]();
        if(isset($url[1]) && !empty($url[1])){
            $level = count($url);
            if($level>2){
               /* $arg = "";
                $method = new ReflectionMethod($url[0], $url[1]);
                $arg_count = $method->getParameters();

                for($i=2;$i<count($arg_count)+2;$i++){
                    $arg .= $url[$i].", ";
                }
                $arg = substr($arg,0,strlen($arg)-2);*/

                $ob->$url[1]($url[2]);
            }else{
                $ob->$url[1]();
            }
        }else{
            $ob->index();
        }
    }
}

//print_r($url);
?>
</body>
</html>