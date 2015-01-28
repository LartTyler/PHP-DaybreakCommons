<?php
	namespace DaybreakStudios\Common\Comparison;

	interface Comparator {
		public function compare($a, $b);
		public function is($a);
		public function accepts($value);
	}
?>