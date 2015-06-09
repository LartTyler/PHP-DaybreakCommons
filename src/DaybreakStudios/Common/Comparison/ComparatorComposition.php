<?php
	namespace DaybreakStudios\Common\Comparison;

	/**
	 * A general contract for compositions used by Comparators.
	 *
	 * @see Comparator
	 */
	interface ComparatorComposition {
		/**
		 * Returns true if the composed element is less than the given element.
		 *
		 * @throws InvalidArgumentException if the given element is not accepted by this composition
		 *
		 * @param  mixed $b the element to compare to
		 * @return boolean  true if the composed element is less than the given element
		 */
		public function lessThan($b);

		/**
		 * @see lessThan()
		 */
		public function lt($b);

		/**
		 * Returns true if the composed element is less than or equal to the given element.
		 *
		 * @throws InvalidArgumentException if the given element is not accepted by this composition
		 *
		 * @param  mixed $b the element to compare to
		 * @return boolean  true if the composed element is less than or equal to the given element
		 */
		public function lessThanOrEqualTo($b);

		/**
		 * @see lessThanOrEqualTo()
		 */
		public function lte($b);

		/**
		 * Returns true if the composed element is equal to the given element.
		 *
		 * @throws InvalidArgumentException if the given element is not accepted by this composition
		 *
		 * @param  mixed $b the element to compare to
		 * @return boolean  true if the composed element is equal to the given element
		 */
		public function equalTo($b);

		/**
		 * @see equalTo()
		 */
		public function eq($b);

		/**
		 * Returns true if the composed element is greater than the given element.
		 *
		 * @throws InvalidArgumentException if the given element is not accepted by this composition
		 *
		 * @param  mixed $b the element to compare to
		 * @return boolean  true if the composed element is greater than the given element
		 */
		public function greaterThan($b);

		/**
		 * @see greaterThan()
		 */
		public function gt($b);

		/**
		 * Returns true if the composed element is greater than or equal to the given element.
		 *
		 * @throws InvalidArgumentException if the given element is not accepted by this composition
		 *
		 * @param  mixed $b the element to compare to
		 * @return boolean  true if the composed element is greater than or equal to the given element
		 */
		public function greaterThanOrEqualTo($b);
		public function gte($b);
	}
?>