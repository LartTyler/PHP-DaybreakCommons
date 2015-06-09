<?php
	namespace DaybreakStudios\Common\Comparison;

	use \InvalidArgumentException;

	/**
	 * Basic implementation of a ComparatorComposition. This class should be sufficient for operating on most
	 * comparators, regardless of their contained type.
	 */
	class SimpleComparatorComposition implements ComparatorComposition {
		private $comparator;
		private $a;

		/**
		 * Constructs a new SimpleComparatorComposition object.
		 *
		 * @throws InvalidArgumentException if the given value is not accepted by the given comparator
		 *
		 * @param Comparator $comparator the comparator to use
		 * @param mixed      $a          the value to compose
		 */
		public function __construct(Comparator $comparator, $a) {
			if (!$comparator->accepts($a))
				throw new InvalidArgumentException('The comparator does not accept the value you are attempting to ' .
					'compose.');

			$this->comparator = $comparator;
			$this->a = $a;
		}

		public function lt($b) {
			return $this->lessThan($b);
		}

		public function lessThan($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === -1;
		}

		public function lte($b) {
			return $this->lessThanOrEqualTo($b);
		}

		public function lessThanOrEqualTo($b) {
			return $this->lessThan($b) || $this->equalTo($b);
		}

		public function eq($b) {
			return $this->equalTo($b);
		}

		public function equalTo($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === 0;
		}

		public function gt($b) {
			return $this->greaterThan($b);
		}

		public function greaterThan($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === 1;
		}

		public function gte($b) {
			return $this->greaterThanOrEqualTo($b);
		}

		public function greaterThanOrEqualTo($b) {
			return $this->greaterThan($b) || $this->equalTo($b);
		}

		protected function accepts($b) {
			return $this->comparator->accepts($b);
		}
	}
?>