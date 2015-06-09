<?php
	namespace DaybreakStudios\Common\Collection;

	use \UnexpectedValueException;

	class SimpleMap implements Map {
		protected $entries;

		public function __construct(Map $map = null) {
			$this->entries = new SimpleSet();

			if ($map !== null)
				$this->putAll($map);
		}

		public function clear() {
			$this->entries = new SimpleSet();
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

		/**
		 * {@inheritdoc}
		 *
		 * @see SimpleEntry
		 */
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
			$keys = new SimpleSet();

			foreach ($this->entries as $entry)
				$keys->add($entry->getKey());

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

				$this->entries->add($entry);

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
			foreach ($this->entries as $entry)
				if ($entry->getKey() === $key) {
					$this->entries->remove($entry);

					return $entry->getValue();
				}

			return null;
		}

		public function size() {
			return $this->entries->size();
		}

		public function values() {
			$values = new ArrayList();

			foreach ($this->entries as $entry)
				$values->add($entry->getValue());

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