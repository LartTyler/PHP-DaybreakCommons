<?php
	namespace DaybreakStudios\Common\Collection;

	use \ArrayIterator;

	class SimpleSet extends AbstractSet {
		protected $entries = [];

		public function add($e) {
			if ($this->contains($e))
				return false;

			$this->entries[] = $e;

			return true;
		}

		public function getIterator() {
			return new ArrayIterator($this->entries);
		}

		public function remove($e) {
			$pos = false;

			foreach ($this as $k => $v)
				if ($e === $v) {
					$pos = $k;

					break;
				}

			if ($pos === false)
				return false;

			array_splice($this->entries, $pos, 1);

			return true;
		}

		public function size() {
			return sizeof($this->entries);
		}
	}
?>