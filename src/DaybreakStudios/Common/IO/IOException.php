<?php
	namespace DaybreakStudios\Common\IO;

	use \Exception;

	class IOException extends Exception {
		public function __construct($msg) {
			parent::__construct($msg);
		}
	}
?>