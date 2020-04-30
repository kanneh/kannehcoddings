<?php
/**
 * session handler
 */
class Session
{
	private $data=array();
	public function start()
	{
		# code...
		session_start();
		$this->data=array_merge($this->data,$_SESSION);
	}

	public function stop()
	{
		# code...
		session_unset();
		session_destroy();
	}

	public function get($key)
	{
		# code...
		return isset($this->data[$key])?$this->data[$key]:null;
	}

	public function is_set($key)
	{
		# code...
		return isset($this->data[$key]);
	}

	public function set($key,$value)
	{
		# code...
		$this->data[$key]=$value;
		$_SESSION[$key]=$value;
	}

	public function unset($key)
	{
		# code...
		if (isset($this->data[$key])) {
			# code...
			unset($this->data[$key]);
			unset($_SESSION[$key]);
		}
	}
}
?>