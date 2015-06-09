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

		/**
		 * Returns the value to which the given key is mapped, or null if there is no mapping for the key in this map.
		 *
		 * @param  mixed $key the key whose value is to be returned
		 * @param  mixed $def optional; the default value to use if no mapping exists
		 * @return mixed      the value of the mapping, or $def if no mapping exists
		 */
		public function get($key, $def = null);

		/**
		 * Returns true if this map contains no mappings.
		 *
		 * @return boolean true if there are no mappings in this map
		 */
		public function isEmpty();

		/**
		 * Returns a Set view of the keys in this map. Unlike `entrySet`, the returned set is NOT backed by this map,
		 * so any changes made will not be reflected in either collection.
		 *
		 * @return Set a Set view of the keys in this map
		 */
		public function keySet();

		/**
		 * Maps the given key to the given value in this map (optional operation). If the key already exists in this
		 * map, it's value will be replaced by the given value.
		 *
		 * @throws BadMethodCallException if the `put` operaiton is not supported
		 * @throws InvalidArgumentException if a property of the key or value prevents it from being stored in this map
		 *         (such as type)
		 *
		 * @param  mixed $key   the key to map the given value to
		 * @param  mixed $value the value to map
		 * @return mixed        the previously mapped value, or null if there wasn't one
		 */
		public function put($key, $value);

		/**
		 * Copies all of the mappings from the given map to this map (optional operation).
		 *
		 * @throws BadMethodCallException if the `putAll` operation is not supported
		 * @throws InvalidArgumentException if a property of a key or value in the given map prevents it from being
		 *         stored in this map (such as type)
		 *
		 * @param  Map    $map the map whose mappings will be copied into this map
		 */
		public function putAll(Map $map);

		/**
		 * Removes a mapping for a key from this map, if it is present (optional operation).
		 *
		 * If the map permits null values, the default return value does not necessarily mean that there was no previous
		 * mapping for the given key.
		 *
		 * @throws BadMethodCallException if the `remove` operation is not supported
		 *
		 * @param  mixed $key the key whose mapping will be removed
		 * @return mixed      the value that was previously mapped, or null if there was not one
		 */
		public function remove($key);

		/**
		 * Returns the number of mappings contained in this map.
		 *
		 * @return integer the number of mappings in this map
		 */
		public function size();

		/**
		 * Returns a Collection view of the values in this map. The returned collection is not backed by this map, and
		 * any changes made to either collection will not be reflected in the other.
		 *
		 * @return Collection a collection view of the values in this map
		 */
		public function values();

		/**
		 * Converts this map into a PHP associative array (optional operation).
		 *
		 * @throws BadMethodCallException if the `toArray` operation is not supported
		 * @throws UnexpectedValueException if any mappings in this map contain a non-scalar key, which is not an
		 *         allowed key in PHP arrays
		 *
		 * @return array an array whose keys are the keys in this map, mapped to their corresponding values
		 */
		public function toArray();
	}
?>