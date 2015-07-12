<?php
	namespace DaybreakStudios\Common\Collection;

	use \InvalidArgumentException;

	use DaybreakStudios\Common\Collection\Map\EnumEntrySet;
	use DaybreakStudios\Common\Collection\Map\SimpleEntry;
	use DaybreakStudios\Common\Enum\EnumUtil;

	class EnumMap extends AbstractMap {
		protected $entries;
		protected $class;

		public function __construct($class) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException('$class must be the full namespace to an enum');

			$this->entries = new EnumEntrySet($this, $class);
			$this->class = $class;
		}

		public function containsKey($key) {
			$this->typeCheck($key);

			return $this->entries->containsKey($key);
		}

		public function entrySet() {
			return $this->entries;
		}

		public function get($key, $def = null) {
			$this->typeCheck($key);

			if (!$this->entries->containsKey($key))
				return $def;

			return $this->entrySet()->get($key)->getValue();
		}

		public function put($key, $value) {
			$this->typeCheck($key);

			$entry = $this->entries->get($key);

			if ($entry === null) {
				$this->entries->add(new SimpleEntry($key, $value));

				return null;
			}

			return $entry->setValue($value);
		}

		public function toArray() {
			$array = [];

			foreach ($this->entrySet() as $entry)
				$array[$entry->getKey()->ordinal()] = $entry->getValue();

			return $array;
		}

		protected function typeCheck($key) {
			if (!($key instanceof $this->class))
				throw new InvalidArgumentException('$key must be an instance of ' . $this->class);
		}
	}
?>