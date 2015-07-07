<?php
	namespace DaybreakStudios\Common\Collection\Map;

	/**
	 * Stores individual mappings for a map.
	 *
	 * @see Map
	 */
	interface Entry {
		/**
		 * Returns the key assigned to this mapping.
		 *
		 * @return mixed the key assigned to this mapping
		 */
		public function getKey();

		/**
		 * Returns the value assigned to this mapping.
		 *
		 * @return mixed the value assigned to this mapping
		 */
		public function getValue();

		/**
		 * Assigns a new value to this mapping.
		 *
		 * @param mixed $value the new value to assign to this mapping
		 * @return mixed the previous value
		 */
		public function setValue($value);
	}
?>