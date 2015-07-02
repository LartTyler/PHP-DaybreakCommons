<?php
	namespace DaybreakStudios\Common\Collection;

	use \InvalidArgumentException;

	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Enum\EnumUtil;

	class EnumMap extends SimpleMap {
		private $class;

		public function __construct($class) {
			parent::__construct();

			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			$this->class = $class;
		}

		public function containsKey($key) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return parent::containsKey($key->ordinal());
		}

		public function get($key, $def = null) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return parent::get($key->ordinal(), $def);
		}

		public function put($key, $value) {
			if (!EnumUtil::isEnum($key, $this->class))
				throw new InvalidArgumentException(sprintf('$key must be an instance of %s.', $this->class));

			return parent::put($key->ordinal(), $value);
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