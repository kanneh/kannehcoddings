<?php
	/**
	 * controller class
	 */
	class Controller
	{
		public $data=array();
		protected $registry;
		private $registries;

		function __construct($registry)
		{
			# code...
			$this->registry=$registry;
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

		function __destruct(){

			$this->data=array_merge($this->data,$this->language->getAll());
		}
		
	}
?>