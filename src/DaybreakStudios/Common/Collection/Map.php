<?php
	namespace DaybreakStudios\Common\Collection;

	/**
	 * An object that maps keys to values. A map cannot contain duplicate keys.
	 */
	interface Map {
		/**
		 * Removes all of the mappings from this map (optional operation).
		 *
		 * @throws BadMethodCallException if the `clear` operation is not supported
		 */
		public function clear();

		/**
		 * Returns true if this map contains a mapping for the given key.
		 *
		 * @param  mixed $key the key to test for
		 * @return boolean    true if this map contains a mapping for the given key
		 */
		public function containsKey($key);

		/**
		 * Returns true if this map contains one or more mappings to the given value.
		 *
		 * @param  mixed $value the value to test for
		 * @return boolean      true if this map contains a mapping to the given value
		 */
		public function containsValue($value);

		/**
		 * Returns a Set view of the mappings in this map. The collection is backed by the map, so any changes to the
		 * Set will also be reflected in this map, and vice-versa.
		 *
		 * @return Set a set containing all the mappings in this map
		 */
		public function entrySet();
		public function get($key, $def = null);
		public function isEmpty();
		public function keySet();
		public function put($key, $value);
		public function putAll(Map $map);
		public function remove($key);
		public function size();
		public function values();
		public function toArray();
	}
?>