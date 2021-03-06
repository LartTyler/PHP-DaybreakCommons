<?php
	namespace DaybreakStudios\Common\Collection\Map;

	class SimpleEntry implements Entry {
		private $key;
		private $value;

		public function __construct($key, $value) {
			$this->key = $key;
			$this->value = $value;
		}

		public function getKey() {
			return $this->key;
		}

		public function getValue() {
			return $this->value;
		}

		public function setValue($value) {
			$old = $this->value;

			$this->value = $value;

			return $old;
		}
	}
?>