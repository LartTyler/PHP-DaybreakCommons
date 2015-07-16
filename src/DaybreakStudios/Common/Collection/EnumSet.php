<?php
	namespace DaybreakStudios\Common\Collection;

	use \ArrayIterator;
	use \InvalidArgumentException;

	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Enum\EnumUtil;

	/**
	 * EnumSets are specialized sets for dealing with Enums. Since all values of an enum are known at runtime, certain
	 * optimizations can be made that allow sets of enums to perform much faster than standard sets.
	 *
	 * @see Enum
	 */
	class EnumSet extends SimpleSet {
		protected $class;
		protected $entries = 0;
		protected $universe = array();

		public function __construct($class, array $elements = array()) {
			$this->class = $class;

			$bit = 1;

			foreach ($class::values() as $v) {
				$this->universe[$v->ordinal()] = $bit;

				$bit *= 2;
			}

			foreach ($elements as $e)
				$this->add($e);
		}

		/**
		 * Ensures that this set contains the given element.
		 *
		 * @throws InvalidArgumentException if some property of the element prevented it from being added to this
		 *         collection (such as type).
		 *
		 * @param Enum $e  the element to add
		 * @return boolean true if this set changed as a result of this call, false otherwise
		 */
		public function add($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			if ($this->contains($e))
				return false;

			$this->entries |= $this->universe[$e->ordinal()];

			return true;
		}

		public function clear() {
			$this->entries = 0;
		}

		/**
		 * Returns true if this set contains the given element.
		 *
		 * @param  Enum $e the element to test for
		 * @return boolean true if this set contains the element
		 */
		public function contains($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			return ($this->entries & $this->universe[$e->ordinal()]) !== 0;
		}

		public function getIterator() {
			return new ArrayIterator($this->toArray());
		}

		/**
		 * Removes a single instance of an object from this set, if it is present.
		 *
		 * @param  Enum $e the element to remove from this set, if present
		 * @return boolean true if this set changed as a result of this call
		 */
		public function remove($e) {
			if (!EnumUtil::isEnum($e, $this->class))
				throw new InvalidArgumentException(sprintf('Element must be an instance of %s.', $this->class));

			if (!$this->contains($e))
				return false;

			$this->entries &= ~$this->universe[$e->ordinal()];

			return true;
		}

		public function size() {
			$s = 0;

			foreach ($this->universe as $bit)
				if (($this->entries & $bit) !== 0)
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

		/**
		 * Creates a new EnumSet that contains all of the values in the given class.
		 *
		 * @param  string $class the fully-qualified namespace of the enum to load
		 * @return EnumSet       an EnumSet containing all elements in the enum
		 */
		public static function allOf($class) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class .
					' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			return new EnumSet($class, $class::values());
		}

		/**
		 * Creates a new EnumSet that is the complement of the given EnumSet. Or in other words, creates an EnumSet
		 * containing all enum values that are not present in the given EnumSet.
		 *
		 * @param  EnumSet $set the EnumSet to generate a complement for
		 * @return EnumSet       	the resulting EnumSet
		 */
		public static function complementOf(EnumSet $set) {
			$values = array();

			foreach (call_user_func(array($set->class, 'values')) as $v)
				if (!$set->contains($v))
					$values[] = $v;

			return new EnumSet($set->class, $values);
		}

		/**
		 * Creates a new EnumSet that contains all of the elements in the given EnumSet.
		 *
		 * @param  EnumSet $set the EnumSet to copy
		 * @return EnumSet      the resulting EnumSet
		 */
		public static function copyOf(EnumSet $set) {
			return new EnumSet($set->class, $set->toArray());
		}

		/**
		 * Creates a new EnumSet that contains all of the elements passed to this method after the first.
		 *
		 * @throws InvalidArgumentException if the given class name is not an enum
		 *
		 * @param  string $class    the fully-qualified namespace of the enum
		 * @param  Enum $values,... zero or more values that the resulting EnumSet should contain
		 * @return EnumSet 			the resulting EnumSet
		 */
		public static function of($class/* , ... $values */) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class .
					' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');

			$values = func_get_args();
			array_shift($values);

			return new EnumSet($class, $values);
		}

		/**
		 * Creates an EnumSet that initially contains all of the elements between two endpoints.
		 *
		 * @throws InvalidArgumentException if either of the range endpoints are not enums, or they are not elements
		 *         from the same enum
		 *
		 * @param  string $class the fully-qualified namespace of the num
		 * @param  Enum   $from  the start point of the range
		 * @param  Enum   $to    the end point of the range
		 * @return EnumSet       the resulting EnumSet
		 */
		public static function range($class, Enum $from, Enum $to) {
			if (!EnumUtil::isEnumClass($class))
				throw new InvalidArgumentException($class .
					' is not loaded or does not extend DaybreakStudios\Common\Enum\Enum.');
			else if (!EnumUtil::isEnum($from, $class) || !EnumUtil::isEnum($to, $class))
				throw new InvalidArgumentException(sprintf('$from and $to must be an instance of %s.', $this->class));

			$values = array();

			foreach ($class::values() as $v)
				if ($v->ordinal() >= $from->ordinal() && $v->ordinal() <= $to->ordinal())
					$values[] = $v;

			return new EnumSet($class, $values);
		}
	}
?>