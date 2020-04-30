<?php
	/**
	 * responses
	 */
	class Response
	{
		private $header;
		private $output;

		public function getOutput($value='')
		{
			# code...
			return $this->output;
		}
		public function setOutput($output)
		{
			# code...
			$this->output=$output;
			return $this->output;
		}


		public function Output()
		{
			# code...
			echo $this->getOutput();
		}
	}
?>