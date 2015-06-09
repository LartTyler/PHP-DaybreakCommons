<?php
	namespace DaybreakStudios\Common\Enum\TwigCompat;

	use DaybreakStudios\Common\Enum\Enum;

	/**
	 * A wrapper class that encapsulates enums intended for the Twig environment.
	 *
	 * @see DaybreakStudios\Common\Enum\TwigCompat\EnumExtension
	 */
	class EnumWrapper {
		private $values = array();

		/**
		 * Creates a new EnumWrapper.
		 *
		 * @param array $values the values of the enum to wrap
		 */
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