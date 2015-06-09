<?php
	namespace DaybreakStudios\Common\Comparison;

	/**
	 * A general contract for comparisons.
	 */
	interface Comparator {
		/**
		 * Compares `$a` to `$b` and determines which is greater.
		 *
		 * @throws InvalidArgumentException if either value is not accepted by this comparator
		 *
		 * @param  mixed $a the element being compared
		 * @param  mixed $b the element to compare against
		 * @return integer  -1 if a < b, 0 if a == b, 1 if a > b
		 */
		public function compare($a, $b);

		/**
		 * Creates a Composition object using `$a`.
		 *
		 * @throws InvalidArgumentException if the given value is not accepted by this comparator
		 *
		 * @param  mixed  				 $a the element to compose
		 * @return ComparatorComposition the resulting ComparatorComposition object
		 */
		public function is($a);

		/**
		 * Returns true if this comparator accepts the given value.
		 *
		 * @param  mixed $value the value to test
		 * @return boolean      true if the value can be compared by this comparator
		 */
		public function accepts($value);
	}
?>