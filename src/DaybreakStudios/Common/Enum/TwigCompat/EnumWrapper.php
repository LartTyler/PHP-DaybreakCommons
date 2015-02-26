<?php
	namespace DaybreakStudios\Common\Enum\TwigCompat;

	use DaybreakStudios\Common\Enum\Enum;

	class EnumWrapper {
		private $values = array();

		public function __construct(array $values) {
			foreach ($values as $v)
				if ($v instanceof Enum)
					$this->values[$v->name()] = $v;
		}

		public function __get($name) {
			return $this->values[$name];
		}

		public function __isset($name) {
			return isset($this->values[$name]);
		}

		public function values() {
			return $this->values;
		}
	}
?>