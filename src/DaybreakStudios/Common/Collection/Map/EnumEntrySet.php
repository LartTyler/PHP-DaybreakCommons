<?php
	namespace DaybreakStudios\Common\Collection\Map;

	use DaybreakStudios\Common\Collection\AbstractSet;
	use DaybreakStudios\Common\Collection\Map;
	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Enum\EnumUtil;

	class EnumEntrySet extends EntrySet {
		protected $entries = [];
		protected $class;

		public function __construct(Map $parent, $class) {
			parent::__construct($parent);

			$this->class = $class;
		}

		public function add($e) {
			$this->typeCheck($e);

			if ($this->contains($e))
				return false;

			$this->entries[$e->getKey()->ordinal()] = $e;

			ksort($this->entries);

			return true;
		}

		public function clear() {
			$this->entries = [];
		}

		public function contains($e) {
			$this->typeCheck($e);

			return isset($this->entries[$e->getKey()->ordinal()]);
		}

		public function containsKey(Enum $e) {
			return isset($this->entries[$e->ordinal()]);
		}

		public function get(Enum $e, $def = null) {
			if (!isset($this->entries[$e->ordinal()]))
				return $def;

			return $this->entries[$e->ordinal()];
		}

		public function remove($e) {
			$this->typeCheck($e);

			if (!$this->contains($e))
				return false;

			unset($this->entries[$e->getKey()->ordinal()]);

			return true;
		}

		public function size() {
			return sizeof($this->entries);
		}

		protected function typeCheck($e) {
			parent::typeCheck($e);

			if (!EnumUtil::isEnum($e->getKey(), $this->class))
				throw new InvalidArgumentException('$e must be an instance of ' . $this->class);
		}
	}
?>