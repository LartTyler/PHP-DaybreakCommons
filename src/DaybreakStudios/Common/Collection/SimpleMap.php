<?php
	namespace DaybreakStudios\Common\Collection;

	use \UnexpectedValueException;

	class SimpleMap implements Map {
		protected $entries = array();

		public function clear() {
			$this->entries = array();
		}

		public function containsKey($key) {
			foreach ($this->entries as $entry)
				if ($entry->getKey() === $key)
					return true;

			return false;
		}

		public function containsValue($value) {
			foreach ($this->entries as $entry)
				if ($entry->getValue() === $value)
					return true;

			return false;
		}

		public function entrySet() {
			return $this->entries;
		}

		public function get($key, $def = null) {
			foreach ($this->entries as $entry)
				if ($entry->getKey() === $key)
					return $entry->getValue();

			return $def;
		}

		public function isEmpty() {
			return $this->size() === 0;
		}

		public function keySet() {
			$keys = array();

			foreach ($this->entries as $entry)
				$keys[] = $entry->getKey();

			return $keys;
		}

		public function put($key, $value) {
			$entry = null;

			foreach ($this->entries as $e)
				if ($e->getKey() === $key) {
					$entry = $e;

					break;
				}

			if ($entry === null) {
				$entry = new SimpleEntry($key, $value);

				$this->entries[] = $entry;

				return null;
			}

			$orig = $entry->getValue();

			$entry->setValue($value);

			return $orig;
		}

		public function putAll(Map $map) {
			foreach ($map->entrySet() as $entry)
				$this->put($entry->getKey(), $entry->getValue());
		}

		public function remove($key) {
			foreach ($this->entries as $i => $entry)
				if ($entry->getKey() === $key) {
					$this->entries = array_splice($this->entries, $i, 1);

					return $entry->getValue();
				}

			return null;
		}

		public function size() {
			return sizeof($this->entries);
		}

		public function values() {
			$values = array();

			foreach ($this->entries as $entry)
				$values[] = $entry->getValue();

			return $values;
		}

		public function toArray() {
			$array = array();

			foreach ($this->entries as $entry)
				if (!is_scalar($entry->getKey()))
					throw new UnexpectedValueException('This map contains object keys, and arrays do not support non-scalar key values.');
				else
					$array[$entry->getKey()] = $entry->getValue();

			return $array;
		}
	}
?>