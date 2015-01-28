<?php
	namespace DaybreakStudios\Common\Comparison;

	use \InvalidArgumentException;

	class SimpleComparatorComposition implements ComparatorComposition {
		private $comparator;
		private $a;

		public function __construct(Comparator $comparator, $a) {
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