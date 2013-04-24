<?php

/**
 * @author  Deepak K. Gupta
 * @access Public
 */
require_once 'singleton.php';

abstract class model {

    protected $db = "";

    function __construct() {
        $this->db = DBConnection::Connect();
    }

}

class MyClass extends model {

    public function FindUsers() {

      $this->db->Fields(array("name","district","countrycode as c"));
	  //$this->db->Where(array("firstname"=>"ambar"));
	  //$this->db->Where(array("(firstname = 'ambar' OR lastname = 'sharma')"),true);
	  //$this->db->Where(array("(email = 'amber.sharma@osscube.com' OR phone = '2121222121')"),true);
	  $this->db->where(array("u.id IN(1,2,3,4,5,6,7,8,9)"),true,"OR");
	  //$this->db->Like("name","mohit","AND");
	  $this->db->Between("population","100000","800000","AND");
	  
	  $this->db->Limit("10","5");
	  $this->db->Having(array('c'=>"IND"));
	  $this->db->From("City");
	  
	  //$this->db->Join("profile as p"," u.id = p.user_id ");
	  //$this->db->Join("details as d","u.id = d.user_id","left");
	//$this->db->OrderBy("name asc");
	  //$this->db->GroupBy("username");
	  $this->db->Select();
	 echo $this->db->lastQuery();
	  $result = $this->db->resultArray();
	  echo "<pre/>";
	  print_r($result);
	  
    }
	public function AddUser(){
	
		$this->db->Fields(array("firstname"=>"deepak","lastname"=>"gupta"));
		$this->db->From("users");
		$this->db->Insert();
		echo $this->db->lastQuery();
	}
	public function UpdateUser(){
	
		$this->db->Fields(array("firstname"=>"deepak1"));
		$this->db->From("users");
		$this->db->Where(array("id"=>42));
		$this->db->Update();
		echo $this->db->lastQuery();
	}
	public function DeleteUser(){
		$this->db->From("users");
		$this->db->Where(array("id"=>42));
		$this->db->Delete();
		echo $this->db->lastQuery();
	}
	public function startTransaction(){
	$this->db->startTransaction();
    }
        public function Commit(){
	$this->db->Commit();
    }
        public function Rollback(){
	$this->db->Rollback();
    }

}

$obj = new MyClass();
$obj->FindUsers();
//$obj->AddUser();
//$obj->UpdateUser();
//$obj->DeleteUser();
?>

