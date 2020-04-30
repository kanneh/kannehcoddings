<?php
	/**
	 * requests
	 */
	class Request
	{
		public $post=array();
		public $get=array();
		public $file=array();
		public $server=array();
                public $cookies=array();
                        function __construct()
		{
			# code...
			$this->file=$_FILES;
			$this->post=$_POST;
			$this->get=$_GET;
			$this->server=$this->clean($_SERVER);
            $this->cookies= $this->clean($_COOKIE);
		}

		private function clean($data)
		{
			# code...
			if (is_array($data)) {
				# code...
				foreach ($data as $key => $value) {
					# code...
					unset($data[$key]);
					$data[$key]=$this->clean($value);
				}
				return $data;
			}else{
				$data=trim($data);
				$data=addslashes($data);
				$data=htmlspecialchars($data);
				return $data;
			}
		}

		public function redirect($route,$status=302)
		{
			# code...
			header("Location:".$route,true,$status);
		}
	}
