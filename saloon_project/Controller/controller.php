<?php
ini_set("display_errors", "1");
session_start();
include_once '../Model/salonModel.php';
class SalonController
{
    private $_objSalonModel;
    private $_clientData;
    private $_clientSalonData;
    private $_eventsdata;
    
    public function __construct()
    {
        $this->_objSalonModel=new SalonModel();
    }
    
    public function start()
    {
        if($_REQUEST['action']=="clientReg")
        {
            $this->clientReg();
        }
        if($_REQUEST['action']=="clientLogin")
        {
            $this->clientLogin();
        }
        if($_REQUEST['action']=="saveSalonInfo")
        {
            $this->saveSalonInfo();
        }        
        if($_REQUEST['action']=="saveSalonServices")
        {
            $this->saveSalonServices();
        }   
        if($_REQUEST['action']=="resizeChk")
        {
            $this->resizeChk();
        }   
        if($_REQUEST['action']=="saveSlot")
        {
            $this->saveSlot();
        }  
        if($_REQUEST['action']=="getCalEvents")
        {
            $this->getCalEvents();
        }        
    }
    
    private function getCalEvents()
    {
       $result=$this->_objSalonModel->getAllCalEvents();

       echo (count($result));
    }
    
    private function saveSlot()
    {
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";saveSlot*/
        $this->_objSalonModel->saveClientSlot();
    }
    
    private function resizeChk()
    {
        
        //echo $_POST['end'];
        //echo "<br/>";
        //$str=strtotime($_POST['end']);
        //echo $str;
        echo $_POST['DbEnd'];
        //echo date('Y-M-d H:m:s',$_POST['DbEnd']);
        //echo date('c',$_POST['end']);
       // echo $_POST['start'];
       //echo date('m/d/Y H:i:s',(int)$_POST['start']);
       //echo "<br>";
        //echo date('m/d/Y H:i:s',strtotime(date('m/d/Y H:i:s',(int)$_POST['start'])));
        //$start = date('YmjHis', $_POST['start']);
        //$today=date('c',$_POST['start']);
        //var_dump(
         // echo  date('m/d/Y H:i:s', strtotime(date("m/d/Y",(int)$_POST['start']));
           //echo date('m/d/Y H:i:s', strtotime(date("m/d/Y",(int)$_POST['end']));
          //  );
        //echo $start;
        //echo "mohit";
    }
    private function saveSalonServices()
    {
        $servive=$_POST['svrvices'];
        foreach($servive as $keys=>$values)
        {
            $this->_objSalonModel->SalonServices($values,$_POST['salonId']);
        }
        header("location:../index.php?clientArea");   
    }
    
    private function saveSalonInfo()
    {
        $this->_clientSalonData=$this->_objSalonModel->salonInfoSave();
        $_SESSION['clientSaloonData']=$this->_clientSalonData;
        echo $this->_clientSalonData[0]['id'];
    }
    
    private function clientReg()
    {
        $this->_objSalonModel->clientRegistration();
        header("location:../index.php?regSuccess#requestAccount");
    }
    
    private function clientLogin()
    {
        $this->_clientData=$this->_objSalonModel->clientLoginRequest();
        if($this->_clientData)
        {
            if(md5($_POST['password'])==$this->_clientData[0]['password'])
            {
                $_SESSION['clientData']=$this->_clientData;
                $this->_clientSalonData=$this->_objSalonModel->clientSalonFetch($this->_clientData[0]['id']);
                $_SESSION['clientSaloonData']=$this->_clientSalonData;
                header("location:../index.php?clientArea");
            }
            else
            {
                //login failed
                header("location:../index.php?error#client");
            }
        }
        else
        {
            //user not found
            header("location:../index.php?error#client");
        }
    }
}
$objController= new SalonController();
$objController->start();



?>