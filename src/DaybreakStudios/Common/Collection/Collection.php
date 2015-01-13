<?php
	namespace DaybreakStudios\Common\Collection;

	use \IteratorAggregate;

	interface Collection extends IteratorAggregate {
		public function add($e);
		public function addAll(Collection $c);
		public function clear();
		public function contains($e);
		public function containsAll(Collection $c);
		public function isEmpty();
		public function iterator();
		public function remove($e);
		public function removeAll(Collection $c);
		public function retainAll(Collection $c);
		public function size();
		public function toArray();
	}
?>