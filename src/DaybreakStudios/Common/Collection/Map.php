<?php
	namespace DaybreakStudios\Common\Collection;

	interface Map {
		public function clear();
		public function containsKey($key);
		public function containsValue($value);
		public function entrySet();
		public function get($key, $def = null);
		public function isEmpty();
		public function keySet();
		public function put($key, $value);
		public function putAll(Map $map);
		public function remove($key);
		public function size();
		public function values();
	}
?>