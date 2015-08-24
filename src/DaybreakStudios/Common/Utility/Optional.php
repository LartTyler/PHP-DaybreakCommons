<?php
	namespace DaybreakStudios\Common\Utility;

	use \InvalidArgumentException;

	class Optional {
		protected $value;
		protected $empty;

		protected function __construct($value = null, $empty = false) {
			$this->value = $value;
			$this->empty = $empty;
		}

		/**
		 * Gets the wrapped value, or returns $def if the optional is empty.
		 *
		 * @param  mixed $def the value to return if the optional is empty (default null)
		 * @return mixed      the optional value, or null if the optional is empty
		 */
		public function get($def = null) {
			if ($this->empty)
				return $def;

			return $this->value;
		}

		/**
		 * Returns true if the optional is not empty (assigned a non-null value).
		 *
		 * @return boolean true if a value is present, false otherwise
		 */
		public function isPresent() {
			return !$this->empty;
		}

		/**
		 * Creates a new Optional from a non-null value.
		 *
		 * @throws InvalidArgumentException if $value is null
		 *
		 * @param  mixed $value a non-null value to create an optional with
		 * @return Optional     an Optional whose value is $value
		 */
		public static function of($value) {
			if ($value === null)
				throw new InvalidArgumentException('$value cannot be null; did you mean to use ofNullable?');

			return new Optional($value);
		}

		/**
		 * Creates a new Optional that is empty.
		 *
		 * @return Optional an Optional that is empty
		 */
		public static function ofEmpty() {
			return new Optional(null, true);
		}

		/**
		 * Creates a new Optional that will either wrap a non-null value, or a new empty Optional.
		 *
		 * @param  mixed $value the nullable value to wrap
		 * @return Optional     an empty Optional if $value is empty, or an Optional that wraps $value
		 */
		public static function ofNullable($value) {
			return new Optional($value, $value === null);
		}
	}
?>