<?php
	/**
	 * keeps data
	 */
	class Registry
	{
		
		private $data=array();

		public function get($key)
		{
			# code...
			return(isset($this->data[$key])?$this->data[$key]:null);
		}

		public function set($key,$value)
		{
			# code...
			$this->data[$key]=$value;
		}

		public function has($key)
		{
			# code...
			return isset($this->data[$key]);
		}

		public function all()
		{
			# code...
			return $this->data;
		}
	}
?>