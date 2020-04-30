<?php
/**
 * model
 */
class Model
{
	private $db;
	private $registry;
	function __construct($registry)
	{
		# code...
		$this->registry=$registry;
		$this->db=$this->registry->get("db");
	}

	public function __get($key)
	{
		# code...
		return $this->registry->get($key);
	}

	public function __set($key,$value)
	{
		# code...
		$this->registry->set($key,$value);
	}
}
?>