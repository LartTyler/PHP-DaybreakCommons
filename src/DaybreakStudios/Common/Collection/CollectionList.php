<?php
	namespace DaybreakStudios\Common\Collection;

	interface CollectionList extends Collection {
		public function addAt($index, $element);
		public function addAllAt($index, Collection $c);
		public function get($index);
		public function indexOf($element);
		public function lastIndexOf($element);
		public function set($index, $element);
		public function subList($start, $end = null);
	}
?>