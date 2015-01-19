<?php
	namespace DaybreakStudios\Common\Collection;

	use \InvalidArgumentException;

	use DaybreakStudios\Enum\Enum;

	class EnumMap extends SimpleMap {
		private $class;

		public function __construct($class) {
			if (!$this->isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Enum\Enum.');

			$this->class = $class;
		}

		public function containsKey($key) {
			if (!$this->isEnum($key))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return isset($this->entries[$key->ordinal()]);
		}

		public function get($key, $def = null) {
			if (!$this->isEnum($key))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			if (isset($this->entries[$key->ordinal()]))
				return $this->entries[$key->ordinal()]->getValue();

			return $def;
		}

		public function put($key, $value) {
			if (!$this->isEnum($key))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			$entry = null;

			foreach ($this->entries as $e)
				if ($e->getKey() === $key) {
					$entry = $e;

					break;
				}

			if ($entry === null) {
				$entry = new SimpleEntry($key, $value);

				$this->entries[$key->ordinal()] = $entry;

				return null;
			}

			$orig = $entry->getValue();

			$entry->setValue($value);

			return $orig;
		}

		public function putAll(Map $map) {
			if (!($map instanceof EnumMap))
				throw new InvalidArgumentException('EnumMap#putAll may only be called with another EnumMap as an argument.');

			foreach ($map->entrySet() as $entry)
				$this->put($entry->getKey(), $entry->getValue());
		}

		public function remove($key) {
			if (!$this->isEnum($key))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			if (!isset($this->entries[$key->ordinal()]))
				return null;

			$entry = $this->entries[$key->ordinal()];

			unset($this->entries[$key->ordinal()]);

			return $entry->getValue();
		}

		private function isEnum($val) {
			return is_object($val) && $val instanceof $this->class;
		}

		private function isEnumClass($class) {
			if (!is_string($class) || !class_exists($class) || !is_subclass_of($class, 'DaybreakStudios\Enum\Enum'))
				return false;

			return true;
		}
	}
?>