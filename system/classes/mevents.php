<?php
/**
 * events
 *
 */
class Events
{
	protected $registry;
	private $mclass;
	private $method;


	function __construct($registry)
	{
		# code...
		$this->registry=$registry;
	}

	public function triger($file,$method="index")
	{
		# code...
		require_once $file.".php";
		$parts=explode("/", $file);
		$mclass=$parts[count($parts)-1];
		$mclass=new $mclass($this->registry);
		if(method_exists($mclass, $method)){
			return $mclass->$method();
		}else{
			return "Invalid call to user function";
		}
	}

	public function triger_wiget($file,$method='index')
	{
		# code...
		require_once $file.".php";
		$parts=explode("/", $file);
		$mclass=$parts[count($parts)-1];
		$class=new $mclass($this->registry);
		if(method_exists($class, $method)){
          ob_start();
          $class->$method();
			return ob_get_clean();
		}else{
			return "Can not make a call to the function ".$method."in the file ".$file;
		}
		
	}
    public function triger_before($file,$method='index')
	{
		# code...
		require_once $file.".php";
		$parts=explode("/", $file);
		$mclass=$parts[count($parts)-1];
		$mclass=new $mclass($this->registry);
		if(method_exists($mclass, $method)){
			return $mclass->$method();
		}else{
			return "Can not make a call to the function ".$method."in the file ".$file;
		}
		
	}
}

