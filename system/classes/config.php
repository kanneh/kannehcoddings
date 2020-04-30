<?php
/**
 * configuration Manager
 */
class Config
{
	private $db;

	function __construct($db)
	{
		$this->db=$db;
		$this->init_config();
	}

	public function init_config()
	{
		# code...
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."config(id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,config VARCHAR(25) NOT NULL,configval TEXT NOT NULL)");
	}

	public function get($key)
	{
		# code...
		$query=$this->db->query("SELECT configval FROM ".DB_PREFIX."config WHERE config='$key'");
		return isset($query->row['configval'])?$query->row['configval']:'';
	}

	public function set($key,$value)
	{
		# code...
		$query_sel=$this->get($key);
		$query_sel=$this->get($key);
		if (!$query_sel) {
			# code...
			$query=$this->db->query("INSERT INTO ".DB_PREFIX."config SET config='$key', configval='$value'");
		}else{
			$query=$this->db->query("UPDATE ".DB_PREFIX."config SET configval='$value' WHERE config='$key'");
		}
		
	}

	public function change($key,$value)
	{
		# code...
		$query=$this->db->query("UPDATE ".DB_PREFIX."config SET configval='$value' WHERE config='$key'");
	}
	public function addPermission($key='access',$value)
	{
		# code...
		$idquery=$this->get('permission');
		$permQuery=json_decode($idquery);
		$permission=isset($permQuery->$key)?$permQuery->$key:array();
		if (!in_array($value, $permission)) {
			# code...
			$permission[]=$value;
			$permQuery->$key=$permission;
			$this->set('permission',json_encode($permQuery));
		}
	}
}