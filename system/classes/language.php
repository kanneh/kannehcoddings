<?php
/**
 * LanguageClass
 */
class Language
{
	private $data=array();
	

	public function get($key)
	{
		# code...
		return isset($this->data[$key])?$this->data[$key]:$key;
	}

	public function getAll()
	{
		# code...
		return $this->data;
	}

	public function load($file)
	{
		# code...
		$file=DIR_APPLICATION."language/".$file.".php";
		if (file_exists($file)) {
			# code...
			require_once $file;
			$this->data=array_merge($this->data,$_);
		}
	}
}
