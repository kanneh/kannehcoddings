<?php
/**
 * url
 */
class URL
{
	
	public function link($url)
	{
		# code...
		return HTTP_SERVER."index.php?route=".$url;
	}
}
?>