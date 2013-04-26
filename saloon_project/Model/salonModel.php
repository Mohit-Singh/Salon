<?php
/**
 * @author  Mohit K Singh
 * @access Public
 */
require_once 'singleton.php';

abstract class model {

    protected $db = "";

    function __construct() {
        $this->db = DBConnection::Connect();
    }

}

class SalonModel extends model{
    
    public function clientRegistration()
    {
        if($_POST['userType']=="Visitor")
        {
            $this->db->Fields(array("user_name"=>$_POST['user_name'],
                                    "first_name"=>$_POST['first_name'],
                                    "last_name"=>$_POST['last_name'],
                                    "user_type"=>"C",
                                    "status"=>"A",
                                    "password"=>md5("12345"),
                                    "created_on"=>date('Y-m-d')
                                    ));
        }
        else
        {
            $this->db->Fields(array("user_name"=>$_POST['user_name'],
                                    "first_name"=>$_POST['first_name'],
                                    "last_name"=>$_POST['last_name'],
                                    "user_type"=>"O",
                                    "status"=>"A",
                                    "password"=>md5("12345"),
                                    "created_on"=>date('Y-m-d')
                                    ));            
        }
	$this->db->From("users_master");
	$this->db->Insert();        
    }
    
    public function getAllCalEvents()
    {
        $this->db->Fields(array("slot_id as id","slot_title as title","cal_start_time as start","cal_end_time as end","all_day as allDay"));
        $this->db->where(array("saloon_id='".$_REQUEST['salonId']."' AND status='A'"),true);
        $this->db->From("available_slot");
        $this->db->Select();
        $result = $this->db->resultArray();
        return $result;         
    }
    
    public function saveClientSlot()
    {
        $this->db->Fields(array("saloon_id"=>$_POST['salonId'],
                                "start_time"=>strtotime($_POST['DbStart']),
                                "end_time"=>strtotime($_POST['DbEnd']),
                                "cal_start_time"=>$_POST['Calstart'],
                                "cal_end_time"=>$_POST['Calend'],
                                "slot_id"=>$_POST['SlotId'],
                                "all_day"=>$_POST['allDay'],
                                "slot_title"=>$_POST['title']
                                ));            
	$this->db->From("available_slot");
	$this->db->Insert();

        //echo $this->db->lastQuery();
    }
    public function getAllSalonDb()
    {
    	$this->db->Fields(array("id","saloon_name"));
    	$this->db->From("saloon_master");
    	$this->db->Select();
    	$result = $this->db->resultArray();
    	return $result;
    }
    
    public function availableSlot($start)
    {
    	$this->db->where(array("saloon_id='".$_POST['salonId']."' AND cal_start_time > ".$start ),true);
    	$this->db->From("available_slot");
    	$this->db->Select();
    	$result = $this->db->resultArray();
    	return $result;
    }
    
    public function getAllService()
    {
    	$this->db->Fields(array("service","duration"));
    	$this->db->where(array("saloon_id='".$_POST['salonId']."'"),true);
    	$this->db->From("saloon_services");
    	$this->db->Select();
    	$result = $this->db->resultArray();
    	return $result;
    }
    
    public function salonInfoSave()
    {
        $this->db->Fields(array("saloon_name"=>$_POST['salonName'],
                        "address"=>$_POST['salonAddress'],
                        "owner_id"=>$_POST['userId'],
                        ));            
	$this->db->From("saloon_master");
	$this->db->Insert();
        $this->db->unsetValues();
        $this->db->where(array("owner_id='".$_POST['userId']."'"),true);
        $this->db->From("saloon_master");
        $this->db->Select();
        $result = $this->db->resultArray();
        return $result;        
        
    }
    
    public function SalonServices($service,$salonId)
    {
        $this->db->Fields(array("service"=>$service,
                        "saloon_id"=>$salonId,
                        ));            
	$this->db->From("saloon_services");
	$this->db->Insert();        
    }
    
    public function clientLoginRequest()
    {
        
        $this->db->where(array("user_name='".$_POST['username']."' AND status='A' AND user_type='O'"),true);
        $this->db->From("users_master");
        $this->db->Select();
        $result = $this->db->resultArray();
        return $result;
    }
    
    public function visitorLoginRequest()
    {
    
    	$this->db->where(array("user_name='".$_POST['username']."' AND status='A' AND user_type='C'"),true);
    	$this->db->From("users_master");
    	$this->db->Select();
    	$result = $this->db->resultArray();
    	//echo $this->db->lastQuery();
    	//print_r($result);
    	//die;
    	return $result;
    }
    public function clientSalonFetch($userId)
    {
        $this->db->where(array("owner_id='".$userId."'"),true);
        $this->db->From("saloon_master");
        $this->db->Select();
        $result = $this->db->resultArray();
        return $result;
        
    }
    
}


?>