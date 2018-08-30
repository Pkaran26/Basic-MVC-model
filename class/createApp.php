<?php
class CreateApp{
    private $appname = "";
    private $path = "";
    
    function __construct($appname){
        $this->appname = $appname;
        $this->createAppDict();
    }

    private function createAppDict(){
        if (!file_exists($this->appname)) {
            $this->path = "../".$this->appname;
            mkdir($this->path, true);
            mkdir($this->path."/model");
            mkdir($this->path."/views");
            $this->generateFiles();
           // mkdir('path/to/directory', 0777, true);
           echo $this->appname." app created";
           header("Refresh:1; url=../");
        }else{
            echo "already exist";
            return 0;
        }
    }

    private function generateFiles(){
        $txt = '<?php
        require_once("../../class/models.php");
        class '.$this->appname.'{
            private $Object;
            public function __construct(){
                $this->Object = new Models();
                $this->Object->genMeta($this->MetaData(), get_class());
            }
        
            private function MetaData(){
                $meta = [];
               /*
               //Meta Data Examples
                $meta[0] = $this->Object->primaryKeyField("id", 10);
                $meta[1] = $this->Object->textField("name");
                $meta[2] = $this->Object->textField("Course");
                $meta[3] = $this->Object->dateField("dob", "NOT NULL");
                $meta[4] = $this->Object->charField("grade",2);
                $meta[5] = $this->Object->passwordField(25);
                $meta[6] = $this->Object->foreignKeyField("userid", "users", "id");
                */
                return $meta;
            }
        }
        $ob = new '.$this->appname.'();
        header("Refresh:1; url=../");
        ?>';
        $this->writeFiles($txt, $this->path."/model/model.php");
        $txt = '<?php
        require_once("../class/formBuilder.php");
        
        function getForm(){
            $ob = new FormBuilder("'.$this->appname.'");
            $ob->generateForm();
        }
        ?>';
        $this->writeFiles($txt, $this->path."/views/views.php");
        $txt = '<?php
        require_once("../class/urls.php");
        require_once("views/views.php");
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>'.$this->appname.'</title>
        </head>
        <body>
        <ul>
        <li>
        <a href="../">Home</a>
        </li>
        <li>
        <a href="?page='.$this->appname.'">Poll</a>
        </li>
        </ul>
            <?php
                getForm();
            ?>
        </body>
        </html>';
        $this->writeFiles($txt, $this->path."/index.php");
    }

    private function writeFiles($txt, $path){
        $myfile = fopen($path, "w");
        fwrite($myfile, $txt);
        fclose($myfile);
    }
}

$create = new CreateApp('poll');
?>
