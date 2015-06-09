<?php
	namespace DaybreakStudios\Common\Collection;

	/**
	 * Stores individual mappings for a map.
	 *
	 * @see Map
	 */
	class SimpleEntry {
		private $key;
		private $value;

		/**
		 * Creates a new SimpleEntry object using the given key and value.
		 *
		 * @param mixed $key   the key to assign to this mapping
		 * @param mixed $value the value to assign to this mapping
		 */
		public function __construct($key, $value) {
			$this->key = $key;
			$this->value = $value;
		}

		/**
		 * Returns the key assigned to this mapping.
		 *
		 * @return mixed the key assigned to this mapping
		 */
		public function getKey() {
			return $this->key;
		}

		/**
		 * Returns the value assigned to this mapping.
		 *
		 * @return mixed the value assigned to this mapping
		 */
		public function getValue() {
			return $this->value;
		}

		/**
		 * Assigns a new value to this mapping.
		 *
		 * @param mixed $value the new value to assign to this mapping
		 */
		public function setValue($value) {
			$this->value = $value;
		}
	}
?>