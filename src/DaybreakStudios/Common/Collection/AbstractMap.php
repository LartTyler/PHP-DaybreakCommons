<?php
	namespace DaybreakStudios\Common\Collection;

	use \BadMethodCallException;
	use \UnexpectedValueException;

	use DaybreakStudios\Common\Collection\Map\KeySet;
	use DaybreakStudios\Common\Collection\Map\ValueCollection;

	abstract class AbstractMap implements Map {
		protected $keySet = null;
		protected $values = null;

		public function clear() {
			$this->entrySet()->clear();
		}

		public function containsKey($key) {
			foreach ($this->entrySet() as $entry)
				if ($entry->getKey() === $key)
					return true;

			return false;
		}

		public function containsValue($value) {
			foreach ($this->entrySet() as $entry)
				if ($entry->getValue() === $value)
					return true;

			return false;
		}

		public function get($key, $def = null) {
			foreach ($this->entrySet() as $entry)
				if ($entry->getKey() === $key)
					return $entry->getValue();

			return $def;
		}

		public function isEmpty() {
			return $this->size() === 0;
		}

		public function keySet() {
			if ($this->keySet === null)
				$this->keySet = new KeySet($this);

			return $this->keySet;
		}

		public function put($key, $value) {
			throw new BadMethodCallException();
		}

		public function putAll(Map $m) {
			foreach ($m->entrySet() as $entry)
				$this->put($entry->getKey(), $entry->getValue());
		}

		public function remove($key) {
			foreach ($this->entrySet() as $entry)
				if ($entry->getKey() === $key) {
					$this->entrySet()->remove($entry);

					return $entry->getValue();
				}

			return null;
		}

		public function size() {
			return $this->entrySet()->size();
		}

		public function values() {
			if ($this->values === null)
				$this->values = new ValueCollection($this);

			return $this->values;
		}

		public function toArray() {
			$array = [];

			foreach ($this->entrySet() as $entry)
				if (!is_scalar($entry->getKey()))
					throw new UnexpectedValueException('This map contains object keys, and arrays do not support non-scalar key values.');
				else
					$array[$entry->getKey()] = $entry->getValue();

			return $array;
		}
	}
?>