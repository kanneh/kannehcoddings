<?php
	/**
	 * document functions
	 */
	class Document
	{
		private $title;
		private $scripts=array();
		private $styleSheets=array();
		private $extstyleSheets=array();
		private $extscripts=array();

		public function getStyles()
		{
			# code...
			return $this->styleSheets;
		}
		public function getExternalStyles()
		{
			# code...
			return $this->extstyleSheets;
		}

		public function addStyle($href,$rel)
		{
			# code...
			$this->styleSheets[]=array(
				'href' => DIR_STORAGE."stylesheets/".$href,
				'rel' => $rel
			);
		}
		public function addStyleExternal($href,$rel)
		{
			# code...
			$this->styleSheets[]=array(
				'href' => $href,
				'rel' => $rel
			);
		}

		public function getScripts()
		{
			# code...
			return $this->scripts;
		}
		public function getExternalScripts()
		{
			# code...
			return $this->extscripts;
		}

		public function addScript($href)
		{
			# code...
			$this->scripts[]=array(
				'href' => DIR_STORAGE."scripts/".$href
			);
		}
		public function addScriptExternal($href)
		{
			# code...
			$this->extscripts[]=array(
				'href' => $href
			);
		}

		public function setTitle($title)
		{
			# code...
			$this->title=$title;
		}

		public function getTitle()
		{
			# code...
			return $this->title;
		}
	}

?>