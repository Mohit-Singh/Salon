<?php
ini_set("display_errors", "1");
session_start();
include_once '../Model/salonModel.php';
class SalonController
{
    private $_objSalonModel;
    private $_clientData;
    private $_visitorData;
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
        if($_REQUEST['action']=="visitorLogin")
        {
        	$this->visitorLogin();
        }        
        if($_REQUEST['action']=="getAllSalon")
        {
        	$this->getAllSalon();
        }        
        if($_REQUEST['action']=="getAllSalonService")
        {
        	$this->getAllSalonService();
        }        
        if($_REQUEST['action']=="visitorAvailableSlot")
        {
        	$this->visitorAvailableSlot();
        }        
    }
    
    private function visitorAvailableSlot()
    {
    	
    	
    	//$aaa=mktime($_POST['slotDate']);
    	$str=strtotime($_POST['slotDate']);
//     	$newdate=date('Y-M-d H:m:s',$str);
//     	$newTime=strtotime($newdate)+mktime(1800);
//     	$end=date('Y-M-d H:m:s',$newTime);
//     	echo $str;
//     	echo "<br>";
//     	echo $newdate;
//     	echo "<br>";
//     	echo $newTime;
//     	echo "<br>";
//     	echo $end;
    	//$end=strtotime('2013-Apr-16 00:34:00');
    	//$end=$str+70;
    	//$//end=date('Y-M-d H:i:s', strtotime('+6',$str));
//     	echo $str."<br>";
//     	echo $end;
//     	echo "<br>";
//     	echo date('Y-M-d H:m:s',$str);
//     	echo "<br>";
//     	//echo date('Y-M-d H:m:s',$end);
	echo $str;
		$end=0;
    	foreach($_POST['reqSlotTime'] as $value)
     	{
     		$end +=$value;
     	}
     	$slot=$this->_objSalonModel->availableSlot($str);
     	
     	$abc=$slot[0]["cal_start_time"];
     	echo "<br>";
     	echo $abc;
     	echo "<br>";
     	echo date('Y-M-d H:i:s',$abc);
     	echo "<br>";
     	$dfg=$abc+1800;
     	echo $dfg."<br>";
     	echo date('Y-M-d H:i:s',$dfg);
     	
     	echo "<pre>";
    	print_r($slot);
    	die;
    }
    
    private function getAllSalonService()
    {
    	$result=$this->_objSalonModel->getAllService();
    	echo json_encode($result);    	
    }
    
    private function getAllSalon()
    {
    	$result=$this->_objSalonModel->getAllSalonDb();
    	echo json_encode($result);
    }
    
    private function visitorLogin()
    {
    	$this->_visitorData=$this->_objSalonModel->visitorLoginRequest();
    	if($this->_visitorData)
    	{
    		if(md5($_POST['password'])==$this->_visitorData[0]['password'])
    		{
;
    			$_SESSION['visitorData']=$this->_visitorData;
    			print_r($_SESSION['visitorData']);
    			//die;
    			header("location:../index.php?visitorArea");
    			
    		}
    		else
    		{
    			//login failed
    			
    			header("location:../index.php?error#visitor");
    		}
    	}
    	else
    	{
    		//user not found
    		header("location:../index.php?error#visitor");
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