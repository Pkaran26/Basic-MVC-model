<?php
class CreateApp{
    private $appname = "";
    private $path = "";
    
    function __construct($appname){
        $this->appname = $appname;
        $this->path = dirname(__DIR__)."/".$appname;
        $this->createAppDict();
    }

    private function createAppDict(){
        
        if (!file_exists($this->appname)) {
            mkdir($this->path, TRUE);
            mkdir($this->path."/controller");
            mkdir($this->path."/model");

            $this->generateFiles();
            echo $this->appname." app created";
            header("Refresh:1; url=../$this->appname");
            return 0;
        }else{
            echo "already exist";
            header("Refresh:1; url=../$this->appname");
            return 0;
        }
    }

    private function generateFiles(){
        $txt='<?php
dirname(__DIR__);
require_once("class/controller.php");
require_once("class/formBuilder.php");

class '.$this->appname.' extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        echo "this is index";
    }

    public function form(){
        $ob = new FormBuilder("'.$this->appname.'");
        $ob->generateForm();  
        if (isset($_POST["formdata"])){
            echo $res = $this->submitData("'.$this->appname.'");
            if($res==1){
               echo "success";
            }else{
              echo "try again";
            }
        }
    }

    public function show(){
        $data = $this->selectData("'.$this->appname.'");
       // print_r(array_keys($data[0]));
        echo "<table>";
        for($i=0;$i<count($data);$i++){
            echo "<tr>
                <td>".$data[$i][1]."</td>
                <td>".$data[$i][2]."</td>
                <td>".$data[$i][3]."</td>
                <td>".$data[$i][4]."</td>
                <td><a href=\'update/".$data[$i][0]."\'>Update</a></td>
                <td><a href=\'delete/".$data[$i][0]."\'>Delete</a></td>
            </tr>";  
        }
    }

    public function delete($key){
        $res = $this->deleteData("'.$this->appname.'", [$key]);
        if($res==1){
            echo "success";
        }else{
            echo "try again";
        }
        header("refresh:1;url=../show");
    }

    public function update($key){
        $data = $this->selectData("'.$this->appname.'", $key);
        if(isset($data[0])){
            $ob = new FormBuilder("'.$this->appname.'");
            $ob->generateForm($data);
            
            if (isset($_POST["formdata"])){
                echo $res = $this->updateData("'.$this->appname.'",$key);
                if($res==1){
                echo "success";
                }else{
                echo "try again";
                }
                header("refresh:1;url=../show");
            }
        }else{
            header("location:../show");
        }
    }
}
?>';
        $this->writeFiles($txt, $this->path."/controller/index.php");

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
        $this->writeFiles($txt, $this->path."/model/index.php");
    }

    private function writeFiles($txt, $path){
        $myfile = fopen($path, "w");
        fwrite($myfile, $txt);
        fclose($myfile);
    }
}
?>
