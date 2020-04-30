<?php
/**
 * system class
 */
class System
{
	private $version="1.0.0";
	private $versionstr="100";
	function __construct()
	{
	}
	public function compareVersion()
	{
		$hnd=curl_init('http://127.0.0.1:88');
		ob_start();
		$res=curl_exec($hnd);
		$ret=ob_clean();
		ob_flush();
		curl_close($hnd);

		//return $res;
	}
	public function getVersion()
	{
		return $this->version;
	}
}