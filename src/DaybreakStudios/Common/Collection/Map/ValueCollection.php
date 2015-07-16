<?php
	namespace DaybreakStudios\Common\Collection\Map;

	use \ArrayIterator;

	use DaybreakStudios\Common\Collection\AbstractCollection;
	use DaybreakStudios\Common\Collection\Map;

	class ValueCollection extends AbstractCollection {
		private $parent;

		public function __construct(Map $parent) {
			$this->parent = $parent;
		}

		public function contains($value) {
			return $this->parent->containsValue($value);
		}

		public function getIterator() {
			$values = [];

			foreach ($this->parent->entrySet() as $entry)
				$values[] = $entry->getValue();

			return new ArrayIterator($values);
		}

		public function remove($value) {
			$modified = false;

			foreach ($this->parent->entrySet() as $entry)
				if ($entry->getValue() === $value) {
					$this->parent->remove($entry->getKey());

					$modified = true;
				}

			return $modified;
		}

		public function size() {
			return $this->parent->size();
		}

		public function clear() {
			return $this->parent->clear();
		}
	}
?>