<?php
	namespace DaybreakStudios\Common\Collection;

	use \InvalidArgumentException;

	use DaybreakStudios\Common\Collection\EnumSet;
	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Enum\EnumUtil;

	class EnumMap extends SimpleMap {
		protected $entries;
		protected $class;

		public function __construct($class) {
			parent::__construct();

			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			$this->class = $class;
			$this->entries = new EnumSet($class);
		}

		public function containsKey($key) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return isset($this->entries[$key->ordinal()]);
		}

		public function get($key, $def = null) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));
			else if ($this->containsKey($key))
				return $this->entries[$key->ordinal()];

			return $def;
		}

		public function put($key, $value) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			$previous = $this->get($key);

			$this->entries[$key->ordinal()] = $value;

			return $previous;
		}

		public function putAll(Map $map) {
			if (!($map instanceof EnumMap))
				throw new InvalidArgumentException('EnumMap#putAll may only be called with another EnumMap as an argument.');

			foreach ($map->entrySet() as $entry)
				$this->put($entry->getKey(), $entry->getValue());
		}

		public function remove($key) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return parent::remove($key->ordinal());
		}
	}
?>