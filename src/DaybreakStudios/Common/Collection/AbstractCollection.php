<?php
	namespace DaybreakStudios\Common\Collection;

	use \BadMethodCallException;

	/**
	 * {@inheritdoc}
	 * @internal
	 */
	abstract class AbstractCollection implements Collection {
		public function add($e) {
			throw new BadMethodCallException();
		}

		public function addAll(Collection $c) {
			$modified = false;

			foreach ($c as $e)
				if ($this->add($e))
					$modified = true;

			return $modified;
		}

		public function clear() {
			foreach ($this as $e)
				$this->remove($e);
		}

		public function contains($e) {
			foreach ($this as $el)
				if ($e === $el)
					return true;

			return false;
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

		public function remove($e) {
			throw new BadMethodCallException();
		}

		public function removeAll(Collection $c) {
			$modified = false;

			foreach ($c as $e)
				if ($this->remove($e))
					$modified = true;

			return $modified;
		}

		public function retainAll(Collection $c) {
			$modified = false;

			foreach ($this as $e)
				if (!$c->contains($e)) {
					$this->remove($e);

					$modified = true;
				}

			return $modified;
		}

		public function toArray() {
			$array = [];

			foreach ($this as $e)
				$array[] = $e;

			return $array;
		}
	}
?>