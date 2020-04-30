<?php
/**
 * database
 */
class DB
{
	private $conn;
	
	function __construct()
	{
		# code...
		$this->init_db();
	}


	public function query($sql)
	{
		# code...
      
		$query=$this->conn->query($sql);
		if (!$this->conn->errno) {
			# code...
			if ($query instanceof mysqli_result) {
				# code...

				$data=array();

				while ($row=$query->fetch_assoc()) {
					# code...
					$data[]=$row;
				}

				$result=new stdClass();
				$result->num_rows=$query->num_rows;
				$result->row=isset($data[0])?$data[0]:array();
				$result->rows=$data;

				return $result;
				
			}else{
				return true;
			}
		}else{
          trigger_error($this->conn->error,E_USER_ERROR);
          
          return false;
		}
	}
	public function init_db()
	{
		# code...
		if (!defined('DB_DATABASE') || !defined('DB_HOST') || !defined('DB_USER') || !defined('DB_PASSWORD') || !defined('DB_PREFIX')) {
			# code...
			trigger_error("Database Parameters are missing.",E_USER_ERROR);
		}

		$this->conn=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

		if ($this->conn->connect_error) {
			# code...
			trigger_error("Connection Error",E_USER_ERROR);
		}
		$this->conn->query("CREATE DATABASE IF NOT EXISTS sierraleone");
	}

	public function escape($value)
	{
		# code...
		return $this->conn->real_escape_string($value);
	}
        public function lastId(){
            return $this->conn->insert_id;
        }
        public function getconnection(){
            return $this->conn;
        }
}