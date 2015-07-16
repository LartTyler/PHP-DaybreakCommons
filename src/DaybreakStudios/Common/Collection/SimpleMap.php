<?php
	namespace DaybreakStudios\Common\Collection;

	use DaybreakStudios\Common\Collection\Map\EntrySet;
	use DaybreakStudios\Common\Collection\Map\SimpleEntry;

	class SimpleMap extends AbstractMap {
		protected $entries;

		public function __construct() {
			$this->entries = new EntrySet($this);
		}

		public function entrySet() {
			return $this->entries;
		}

		public function put($key, $value) {
			$entry = null;

			foreach ($this->entries as $e)
				if ($e->getKey() === $key) {
					$entry = $e;

					break;
				}

			if ($entry === null) {
				$this->entries->add(new SimpleEntry($key, $value));

				return null;
			}

			return $entry->setValue($value);
		}
	}
?>