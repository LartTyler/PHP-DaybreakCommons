<?php
	namespace DaybreakStudios\Common\Collection;

	use \ArrayIterator;
	use \InvalidArgumentException;

	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Enum\EnumUtil;

	class EnumSet extends SimpleSet {
		protected $class;
		protected $universe = array();

		public function __construct($class, array $elements = array()) {
			$this->class = $class;

			$bit = 1;

			foreach ($class::values() as $v) {
				$this->universe[$v->ordinal()] = $bit;

				$bit *= 2;
			}

			$this->elements = 0;

			foreach ($elements as $e)
				$this->add($e);
		}

		public function add($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			if ($this->contains($e))
				return false;

			$this->elements |= $this->universe[$e->ordinal()];
		}

		public function clear() {
			$this->elements = 0;
		}

		public function contains($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			return ($this->elements & $this->universe[$e->ordinal()]) !== 0;
		}

		public function iterator() {
			return new ArrayIterator($this->toArray());
		}

		public function remove($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			if (!$this->contains($e))
				return false;

			$this->elements &= ~$this->universe[$e->ordinal()];

			return true;
		}

		public function size() {
			$s = 0;

			foreach ($this->universe as $bit)
				if (($this->elements & $bit) !== 0)
					$s++;

			return $s;
		}

		public function toArray() {
			$array = array();

			foreach (call_user_func(array($this->class, 'values')) as $v)
				if ($this->contains($v))
					$array[] = $v;

			return $array;
		}

		public static function allOf($class) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			return new EnumSet($class, $class::values());
		}

		public static function complementOf(EnumSet $set) {
			$values = array();

			foreach (call_user_func(array($set->class, 'values')) as $v)
				if (!$set->contains($v))
					$values[] = $v;

			return new EnumSet($set->class, $values);
		}

		public static function copyOf(EnumSet $set) {
			return new EnumSet($set->class, $set->toArray());
		}

		public static function noneOf($class) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			return new EnumSet($class);
		}

		public static function of($class/*, ... $values */) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			$args = func_get_args();

			array_shift($args);

			return new EnumSet($class, $args);
		}

		public static function range($class, $from, $to) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class . ' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			if (!EnumUtil::isEnum($from) || !EnumUtil::isEnum($to))
				throw new InvalidArgumentException(sprintf('$from and $to must be an instance of %s.', $this->class));

			$values = array();

			foreach ($class::values() as $v)
				if ($v->ordinal() >= $from->ordinal() && $v->ordinal() <= $to->ordinal())
					$values[] = $v;

			return new EnumSet($class, $values);
		}
	}
?>