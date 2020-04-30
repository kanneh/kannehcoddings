<?php
	/**
	 * loads 
	 */
	class Loader
	{
		protected $registry;
		
		function __construct($registry)
		{
			# code...
			$this->registry=$registry;
		}

		public function Model($route)
		{
			# code...
			$routeparts=explode("/", $route);
			if (count($routeparts)<2) {
				# code...
				trigger_error("Unable to load model ".$route,E_USER_NOTICE);
			}
			$file=DIR_APPLICATION."model/".$routeparts[0]."/".$routeparts[1];
			if (file_exists($file.".php")) {
				# code...
				require_once $file.".php";
				$mclass="Model".$routeparts[count($routeparts)-1];
				$mclass=new $mclass($this->registry);
                                $this->registry->set("model_".$routeparts[0]."_".$routeparts[1],$mclass);
			}
		}

		public function Controller($route)
		{
			# code...
			$routeparts=explode("/", $route);
			if (count($routeparts)<2) {
				# code...
				$this->registry->get("request")->redirect("permission/invalidroute");
				exit();
			}
			$file=DIR_APPLICATION."controller/".$routeparts[0]."/".$routeparts[1];
			if (file_exists($file.".php")) {
				# code...
				
				if (count($routeparts)>2) {
					# code...
					return $this->registry->get("event")->triger($file,$routeparts[2]);
				}else{
					return $this->registry->get("event")->triger($file);
				}
			}else{
				$this->registry->get("request")->redirect($this->registry->get("url")->link("permission/invalidroute"));
				exit();
			}

		}

		public function wiget($route)
		{
			$file=DIR_APPLICATION."wigets/".$route."/".$route;
			if (file_exists($file.".php")) {
				return $this->registry->get("event")->triger_wiget($file);
			} else {
              return "No such wiget ".str_replace("public/wigets/", "", $route);
            }

		}
        public function ControllerContent($route)
		{
			# code...
			$routeparts=explode("/", $route);
			$file=DIR_APPLICATION."controller/".$routeparts[0]."/".$routeparts[1];
			if (file_exists($file.".php")) {
				# code...
				
				if (count($routeparts)>2) {
					# code...
					return $this->registry->get("event")->triger_before($file,$routeparts[2]);
				}else{
					return $this->registry->get("event")->triger_before($file);
				}
			}

		}
		public function view($route,$data)
		{
			# code...
			$routeparts=explode("/", $route);
			$file=DIR_APPLICATION."view/".$routeparts[0]."/".$routeparts[1];
			if (file_exists($file.".php")) {
				# code...
				ob_start();
				require($file.".php");
				return ob_get_clean();
			}

		}

	}
