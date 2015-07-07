<?php
	namespace DaybreakStudios\Common\Collection\Map;

	use \InvalidArgumentException;

	use DaybreakStudios\Common\Collection\SimpleSet;
	use DaybreakStudios\Common\Collection\Map;

	class EntrySet extends SimpleSet {
		protected $parent;

		public function __construct(Map $parent) {
			$this->parent = $parent;
		}

		public function add($e) {
			$this->typeCheck($e);

			if ($this->contains($e))
				return false;

			return parent::add($e);
		}

		public function clear() {
			$this->parent->clear();
		}

		public function contains($e) {
			$this->typeCheck($e);

			return $this->parent->get($e->getKey()) === $e->getValue();
		}

		public function remove($e) {
			$this->typeCheck($e);

			return parent::remove($e);
		}

		public function size() {
			return $this->parent->size();
		}

		protected function typeCheck($e) {
			if (!($e instanceof Entry))
				throw new InvalidArgumentException('$e must be an instance of DaybreakStudios\\Common\\Collection\\Map\\Entry');
		}
	}
?>