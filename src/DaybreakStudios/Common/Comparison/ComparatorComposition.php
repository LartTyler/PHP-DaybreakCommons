<?php
	namespace DaybreakStudios\Common\Comparison;

	interface ComparatorComposition {
		public function lt($b);
		public function lessThan($b);
		public function lte($b);
		public function lessThanOrEqualTo($b);
		public function eq($b);
		public function equalTo($b);
		public function gt($b);
		public function greaterThan($b);
		public function gte($b);
		public function greaterThanOrEqualTo($b);
	}
?>