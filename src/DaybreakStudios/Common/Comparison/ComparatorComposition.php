<?php
	namespace DaybreakStudios\Common\Comparison;

	interface ComparatorComposition {
		public function lessThan($b);
		public function equalTo($b);
		public function greaterThan($b);
	}
?>