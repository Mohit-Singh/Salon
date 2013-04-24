<?php
/**
 *
 * @author root
 * @access
 * @package DB
 *
 */
class DBConnection {

	private static $instance;
	private static $_host = "localhost";
	private static $_user = "root";
	private static $_password = "root";
	private static $_database = "salon";
	private $_tableName = "";
	private $_join = "";
	private $_where = "";
	private $_having="";
	private $_orderBy = "";
	private $_groupBy = "";
	private $_limit = "";
	private $_keys = array();
	private $_values = array();
	private $_insertId;
	private $_errorLog = "";
	private $_query = "";
	private $_result = "";

	private function __construct() {

	}
	public function unsetValues()
	{
	$this->_tableName = "";
	$this->_join = "";
	$this->_where = "";
	$this->_having="";
	$this->_orderBy = "";
	$this->_groupBy = "";
	$this->_limit = "";
	$this->_keys = array();
	$this->_values = array();
	$this->_insertId;
	$this->_errorLog = "";
	$this->_query = "";
	$this->_result = "";		
		
	}
	public static function Connect() {
		if (is_null(DBConnection::$instance)) {

			$db = mysql_connect(self::$_host, self::$_user, self::$_password);
			if ($db) {
				mysql_select_db(self::$_database, $db);
				self::$instance = new DBConnection();
			}
		}
		return self::$instance;
	}

	private function validConnection() {
		if (is_null(DBConnection::$instance)) {
			echo "Could not connected!";
			exit();
		}
	}

	public function Fields($data = array()) {
		$count = count($data);
		if ($count > 0) {

			foreach ($data as $key => $value) {

				if (!empty($value) || $value == 0 ) {
					$this->_keys[] = $key;
					$this->_values[] = $value;
				}
			}
		}
		return $this;
	}

	public function From($value) {
		if (!empty($value)) {
			$this->_tableName = $value;
		}
		return $this;
	}

	public function Join($joinTable, $condition, $type="INNER"){
		if(!empty($this->_tableName) && !empty($joinTable) && !empty($condition) && !empty($type)){

			$this->_join .= strtoupper(" ".$type." JOIN ").$joinTable." ";
			$this->_join .= " ON ".$condition." ";
		}
	}
	public function Where($data = array(), $raw = false, $operator = "AND") {
		$count = count($data);
		if ($count > 0) {

			$index = 0;
			foreach ($data as $key => $value) {
					
					

				if ($index >= 1 || !empty($this->_where)) {
					$ope  = strtoupper($operator);
					if(in_array($ope,array("AND","OR"))){
						$this->_where .= " $ope ";
					}
				}

				if($raw){
					$this->_where .= " ".$value;
					break;
				}

				if (is_string($value)) {
					$value = " '$value' ";
				}


				$op = array("=",">","<",">=","<=");
				$opMatch = false;
				for($i = 0;$i < count($op);$i++){

					if(strpos($key, $op[$i]) > 0){
						$opMatch  = true;
						break;
					}
				}
				if($opMatch){
					$this->_where .= " $key $value";
				} else {
					$this->_where .= " $key =  $value";
				}
				$index++;
			}
		}
		return $this;
	}
	public function Where1($data = array(), $raw = false, $operator = "AND") {
		$count = count($data);
		if ($count > 0) {
	
			$index = 0;
			foreach ($data as $key => $value) {
					
					
	
				if ($index >= 1 || !empty($this->_where)) {
					$ope  = strtoupper($operator);
					if(in_array($ope,array("AND","OR"))){
						$this->_where .= " $ope ";
					}
				}
	
				if($raw){
					$this->_where .= " ".$value;
					break;
				}
	
				if (is_string($value)) {
					$value = " $value ";
				}
	
	
				$op = array("=",">","<",">=","<=");
				$opMatch = false;
				for($i = 0;$i < count($op);$i++){
	
					if(strpos($key, $op[$i]) > 0){
						$opMatch  = true;
						break;
					}
				}
				if($opMatch){
					$this->_where .= " $key $value";
				} else {
					$this->_where .= " $key =  $value";
				}
				$index++;
			}
		}
		return $this;
	}




	public function Having($data = array(), $raw = false, $operator = "AND") {
		$count = count($data);
		if ($count > 0) {

			$index = 0;
			foreach ($data as $key => $value) {
					
					

				if ($index >= 1 || !empty($this->_having)) {
					$ope  = strtoupper($operator);
					if(in_array($ope,array("AND","OR"))){
						$this->_having .= " $ope ";
					}
				}

				if($raw){
					$this->_having .= " ".$value;
					break;
				}

				if (is_string($value)) {
					$value = " '$value' ";
				}


				$op = array("=",">","<",">=","<=");
				$opMatch = false;
				for($i = 0;$i < count($op);$i++){

					if(strpos($key, $op[$i]) > 0){
						$opMatch  = true;
						break;
					}
				}
				if($opMatch){
					$this->_having .= " $key $value";
				} else {
					$this->_having .= " $key =  $value";
				}
				$index++;
			}
		}
		return $this;
	}


	public function Between($key,$val1,$val2 ,$operator = "AND")
	{

		if(!empty($key) && !empty($val1) && !empty($val2))
		{
			 
			if(strlen($this->_where) == 0)
			{
				$this->_where .=  $key." BETWEEN ".$val1." AND ".$val2;
			}
			else
			{
				$ope  = strtoupper($operator);
				if(in_array($ope,array("AND","OR")))
				{
					$this->_where .= " ".$ope ." ". $key." BETWEEN ".$val1." AND ".$val2;
				}
			}
		}

		return $this;
	}


	public function Limit($val1="-1",$val2="0")
	{    
		if($val1 != "-1")
		{		    
			if($val2 != "0")
			{
				$this->_limit =" LIMIT ".$val1." , ".$val2;
			}
			else
			{
				$this->_limit =" LIMIT ".$val1;
			}
				
		}
		return $this;
	}


	public function Like($key,$val, $operator = "AND"){

		if(!empty($key) && !empty($val)){
			if(strlen($this->_where) == 0){
				$this->_where .=  $key." LIKE \"%".$val."%\"";
			} else {
				$ope  = strtoupper($operator);
				if(in_array($ope,array("AND","OR"))){
					$this->_where .= " ".$ope ." ". $key." LIKE \"%".$val."%\"";
				}
			}
		}
		return $this;
	}

	public function OrderBy($string = ""){
		if(!empty($string)){
			$this->_orderBy = " ORDER BY " .$string;
		}
		return $this;
	}
	public function GroupBy($string = ""){
		if(!empty($string)){
			$this->_groupBy = " GROUP BY ".$string;
		}
		return $this;
	}

	public function Select() {
		$bool = false;
		$this->_query = "";

		$fields = " * ";

		if (count($this->_values) > 0) {
			$fields = implode(', ', $this->_values);
		}


		$table = $this->_tableName;

		if (!empty($table)) {
			$this->_query .= "SELECT ";
			$this->_query .= $fields;
				
			$this->_query .= " FROM " . $this->_tableName. $this->_join;
			$where = $this->_where;

			if (!empty($where)) {
				$this->_query .= " WHERE " . $where;
			}
			 
			$having = $this->_having;

			if (!empty($having)) {
				$this->_query .= " HAVING " . $having;
			}
			 
			if (!empty($this->_groupBy)) {
				$this->_query .= $this->_groupBy;
			}
			if (!empty($this->_orderBy)) {
				$this->_query .= $this->_orderBy;
			}
			if (!empty($this->_limit)) {
				$this->_query .= $this->_limit;
			}
			$this->_result = mysql_query($this->_query);
			$bool = true;
		}
		$this->_where = "";
		$this->_join = "";
		$this->_orderBy = "";
		$this->_keys = array();
		$this->_values = array();
		$this->_limit = "";
		return $bool;
	}

	public function Insert() {
		$bool = false;

		$this->_query = "";
		 

		$countKey = count($this->_keys);
		$countValue = count($this->_values);
		$data = array();

		if (($countKey > 0 && $countValue > 0) && $countKey == $countValue) {
			$this->_query .= "INSERT INTO  ";
			$fields = " ";
			$valuesData = "";

			for ($i = 0; $i < $countKey; $i++) {

				$val = $this->_values [$i];
				if (is_string($val)) {
					$val = "\"$val\"";
				}
				$valuesData [] = $val;
			}

			$fields = implode(", ", $this->_keys);
			$values = implode(", ", $valuesData);

			$table = $this->_tableName;

			if (!empty($table)) {
				$this->_query .= "$table ($fields) values($values)";

				$sql = mysql_query($this->_query);

				$this->_insertId = mysql_insert_id();
				if ($this->_insertId > 0) {
					$bool = true;
				}
			}
		}
		$this->_keys = array();
		$this->_values = array();
		return $bool;
	}

	public function Update() {
		$bool = false;

		$this->_query = "";
		 

		$countKey = count($this->_keys);
		$countValue = count($this->_keys);
		$data = array();

		if (($countKey > 0 && $countValue > 0) && $countKey == $countValue) {
			$this->_query .= "UPDATE ";
			$fields = "";

			for ($i = 0; $i < $countKey; $i++) {
				$val = $this->_values [$i];
				if (is_string($val)) {
					$val = "\"$val\"";
				}
				$data [] = "`" . $this->_keys[$i] . "` = " . $val;
			}

			if (count($data) > 0) {
				$fields .= " SET " . implode(", ", $data);
			}

			$table = $this->_tableName;

			if (!empty($table) && strlen($fields) > 0) {
				$this->_query .= $this->_tableName . $fields;
				$where = $this->_where;
				if (!empty($where)) {
					$this->_query .= " WHERE " . $where;
				}

				$sql = mysql_query($this->_query);
				$bool = true;
			}
		}
		$this->_where = "";
		$this->_keys = array();
		$this->_values = array();
		return $bool;
	}

	public function Delete() {
		$bool = false;

		$this->_query = "";


		$table = $this->_tableName;
		$where = $this->_where;

		if (!empty($table) && strlen($where) > 0) {
			$this->_query .= "DELETE FROM ";
			$this->_query .= $this->_tableName;

			if (!empty($where)) {
				$this->_query .= " WHERE " . $where;
			}

			$sql = mysql_query($this->_query);
			$bool = true;
		}

		return $bool;
	}

	public function lastQuery() {
		return $this->_query;
	}

	public function affectedRows() {
		return mysql_affected_rows();
	}

	public function lastInsertId() {
		return $this->_insertId;
	}

	private function _keys($data = array()) {
		$this->_keys = $data;
	}

	private function _value($data = array()) {
		$this->_values = $data;
	}

	public function startTransaction(){
		$sql = mysql_query("START TRANSACTION");
	}
	public function Commit(){
		$sql = mysql_query("COMMIT");
	}
	public function Rollback(){
		$sql = mysql_query("ROLLBACK");
	}

	public function resultArray() {
		$records = array();
		if (!empty($this->_result)) {
			// 			$records = mysql_fetch_assoc ( $this->_result );
			while ($row = mysql_fetch_assoc($this->_result)) {
				$records[] = $row;
			}
		}
		return $records;
	}

}
