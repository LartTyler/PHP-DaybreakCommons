<?php
	namespace DaybreakStudios\Common\Collection\Map;

	use DaybreakStudios\Common\Collection\AbstractSet;
	use DaybreakStudios\Common\Collection\Map;

	class EnumEntrySet extends AbstractSet {
		protected $entries = [];
		protected $parent;
		protected $class;

		public function __construct(Map $parent, $class) {
			$this->parent = $parent;
			$this->class = $class;
		}

		protected function typeCheck($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException('$e must be an instance of ' . $this->class);
		}
	}
?>