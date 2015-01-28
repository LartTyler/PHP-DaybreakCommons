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

		public function lessThan($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === -1;
		}

		public function equalTo($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === 0;
		}

		public function greaterThan($b) {
			if (!$this->accepts($b))
				throw new InvalidArgumentException('The comparator cannot accept that argument for comparison.');

			return $this->comparator->compare($this->a, $b) === 1;
		}

		protected function accepts($b) {
			return $this->comparator->accepts($b);
		}
	}
?>