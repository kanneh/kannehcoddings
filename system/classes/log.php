<?php
	/**
	 * logwriter
	 */
	class Log
	{
		private $handler;
		private $handler1;


		function __construct($logfile,$accessfile)
		{
			$this->handler=fopen($logfile, 'a');
			$this->handler1=fopen($accessfile, 'a');
		}


		public function write($message)
		{
			# code...
			fwrite($this->handler, $message);
		}

		public function writeAccess($message)
		{
			# code...
			fwrite($this->handler1, $message);
		}

		function _distruct()
		{
			fclose($this->handler);
			fclose($this->handler1);
		}
		
	}
?>