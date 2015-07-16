<?php
	namespace DaybreakStudios\Common\Collection\Map;

	use \ArrayIterator;

	use DaybreakStudios\Common\Collection\AbstractSet;
	use DaybreakStudios\Common\Collection\Map;

	class KeySet extends AbstractSet {
		private $parent;

		public function __construct(Map $parent) {
			$this->parent = $parent;
		}

		public function contains($key) {
			return $this->parent->containsKey($key);
		}

		public function getIterator() {
			$keys = [];

			foreach ($this->parent->entrySet() as $entry)
				$keys[] = $entry->getKey();

			return new ArrayIterator($keys);
		}

		public function remove($key) {
			return $this->parent->remove($key);
		}

		public function size() {
			return $this->parent->size();
		}

		public function clear() {
			return $this->parent->clear();
		}
	}
?>