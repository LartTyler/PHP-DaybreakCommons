<?php
	namespace DaybreakStudios\Common\Collection;

	use \ArrayIterator;
	use \InvalidArgumentException;
	use \OutOfBoundsException;

	class ArrayList implements CollectionList {
		protected $elements;

		public function __construct(array $array = array()) {
			$this->elements = array_values($array);
		}

		public function add($element) {
			$this->elements[] = $element;

			return true;
		}

		public function addAt($index, $element) {
			if (!is_int($index) || $index < 0)
				throw new InvalidArgumentException('$index must be an integer greater than or equal to zero.');

			array_splice($this->elements, $index, 0, array($element));

			return true;
		}

		public function addAll(Collection $c) {
			if ($c->size() === 0)
				return false;

			foreach ($c as $element)
				$this->add($element);

			return true;
		}

		public function addAllAt($index, Collection $c) {
			if ($c->size() === 0)
				return false;

			foreach ($c as $element)
				$this->add($element);

			return true;
		}

		public function clear() {
			$this->elements = array();
		}

		public function contains($element) {
			return in_array($element, $this->elements);
		}

		public function containsAll(Collection $c) {
			foreach ($c as $element)
				if (!$this->contains($element))
					return false;

			return true;
		}

		public function get($index) {
			return $this->elements[$index];
		}

		public function indexOf($element) {
			foreach ($this->elements as $i => $e)
				if ($e === $element)
					return $i;

			return false;
		}

		public function isEmpty() {
			return $this->size() === 0;
		}

		public function getIterator() {
			return new ArrayIterator($this->elements);
		}

		public function lastIndexOf($element) {
			for ($i = sizeof($this->elements) - 1; $i >= 0; $i--)
				if ($this->elements[$i] === $element)
					return $i;

			return false;
		}

		public function remove($e) {
			if (is_int($e)) {
				$el = array_splice($this->elements, $e, 1);

				return $el[0];
			} else {
				$pos = $this->indexOf($e);

				if ($pos === false)
					return false;

				array_splice($this->elements, $pos, 1);
			}

			return true;
		}

		public function removeAll(Collection $c) {
			if ($c->size() === 0)
				return false;

			foreach ($c as $element)
				$this->remove($element);

			return true;
		}

		public function retainAll(Collection $c) {
			$changed = false;

			foreach ($this->elements as $i => $v)
				if ($c->indexOf($v) === false) {
					$this->remove($i);

					$changed = true;
				}

			return $changed;
		}

		public function set($index, $element) {
			if ($index < 0 || $index >= $this->size())
				throw new OutOfBoundsException();

			$old = null;

			if (array_key_exists($index, $this->elements))
				$old = $this->elements[$index];

			$this->elements[$index] = $element;

			return $old;
		}

		public function size() {
			return sizeof($this->elements);
		}

		public function subList($start, $end = null) {
			if (!is_int($start))
				throw new InvalidArgumentException('$start must be an integer.');
			else if ($start < 0 || $start >= $this->size())
				throw new OutOfBoundsException('$start must be between 0 and the size of this ArrayList.');
			else if ($end !== null && !is_int($end))
				throw new InvalidArgumentException('$end must be null or an integer.');
			else if ($end !== null && ($end < 0 || $end >= $this->size()))
				throw new OutOfBoundsException('$end must be between 0 and the size of this ArrayList.');

			if ($end === null)
				$end = $this->size() - 1;

			if ($end < $start) {
				$t = $end;
				$end = $start;
				$start = $t;
			}

			$array = array();

			for ($i = $start; $i <= $end; $i++)
				$array[] = $this->get($i);

			return new ArrayList($array);
		}

		public function toArray() {
			return $this->elements;
		}
	}
?>