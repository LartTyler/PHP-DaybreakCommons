<?php
	namespace DaybreakStudios\Common\Collection;

	use \ArrayIterator;

	class SimpleSet implements Set {
		protected $elements = array();

		public function __construct(array $elements = array()) {
			foreach ($elements as $e)
				if (!$this->contains($e))
					$this->elements[] = $e;
		}

		public function add($e) {
			if ($this->contains($e))
				return false;

			$this->elements[] = $e;

			return true;
		}

		public function addAll(Collection $c) {
			$changed = false;

			foreach ($c as $e)
				if ($this->add($e))
					$changed = true;

			return $changed;
		}

		public function clear() {
			$this->elements = array();
		}

		public function contains($e) {
			return in_array($e, $this->elements, true);
		}

		public function containsAll(Collection $c) {
			foreach ($c as $e)
				if (!$this->contains($e))
					return false;

			return true;
		}

		public function isEmpty() {
			return $this->size() === 0;
		}

		public function iterator() {
			return new ArrayIterator($this->elements);
		}

		public function remove($e) {
			$pos = false;

			foreach ($this->elements as $i => $el)
				if ($el === $e) {
					$pos = $i;

					break;
				}

			if ($pos === false)
				return false;

			array_splice($this->elements, $pos, 1);

			return true;
		}

		public function removeAll(Collection $c) {
			if ($c->size() === 0)
				return false;

			$changed = false;

			foreach ($c as $e)
				if ($this->remove($e))
					$changed = true;

			return $changed;
		}

		public function retainAll(Collection $c) {
			$changed = false;

			foreach ($this->elements as $e)
				if (!$c->contains($e)) {
					$this->remove($e);

					$changed = true;
				}

			return $changed;
		}

		public function size() {
			return sizeof($this->elements);
		}

		public function toArray() {
			return $this->elements;
		}

		public function getIterator() {
			return $this->iterator();
		}
	}
?>