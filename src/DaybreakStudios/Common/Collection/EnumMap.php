<?php
	namespace DaybreakStudios\Common\Collection;

	class EnumMap extends AbstractMap {
		protected $entries;

		public function __construct() {
			$this->entries = new EnumEntrySet();
		}
	}
?>