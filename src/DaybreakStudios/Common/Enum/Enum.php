<?php
	namespace DaybreakStudios\Common\Enum;

	use \BadMethodCallException;
	use \Exception;
	use \InvalidArgumentException;
	use \OutOfBoundsException;
	use \ReflectionClass;

	/**
	 * Base class for all enums.
	 */
	abstract class Enum {
		const NS_PATH = 'DaybreakStudios\Common\Enum\Enum';

		private static $stopped = array();
		private static $types = array();

		private $name;
		private $ordinal;

		/**
		 * Registers a new element to an enum.
		 *
		 * @throws BadMethodCallException if the enum has already been loaded
		 *
		 * @param string $name 			the name of the enum being registered
		 * @param mixed  $ctors,... 	zero or more arguments to be passed to the enum's constructor
		 */
		protected static function register($name/* , ... $ctors */) {
			$key = get_called_class();

			if (static::isDone())
				throw new BadMethodCallException(sprintf('Registration has been halted for %s; cannot add %s to the enum list.',
					$key, $name));

			if (!array_key_exists($key, self::$types))
				self::$types[$key] = array();

			$ctors = func_get_args();
			array_shift($ctors);

			$refl = new ReflectionClass($key);
			$ctor = $refl->getConstructor();
			$ctor->setAccessible(true);

			$inst = $refl->newInstanceWithoutConstructor();

			$ctor->invokeArgs($inst, $ctors);
			$ctor->setAccessible(false);

			$inst->setName($name);
			$inst->setOrdinal(sizeof(self::$types[$key]));

			self::$types[$key][$name] = $inst;
		}

		/**
		 * @internal stub constructor in case child enums don't implement a constructor
		 */
		protected function __construct() {}

		/**
		 * Gets the name of an enum element.
		 *
		 * @return string  the enum element's name
		 */
		public final function name() {
			return $this->name;
		}

		/**
		 * Gets the ordinal of an enum element.
		 *
		 * Element ordinals are determined by the order they are registered in. Ordinals are guarenteed
		 * to be the same during a single runtime, but cannot be guarenteed to remain the same in later
		 * sessions.
		 *
		 * @return integer  the ordinal of the enum element
		 */
		public final function ordinal() {
			return $this->ordinal;
		}

		public function __toString() {
			return $this->name();
		}

		/**
		 * Internal use only. Sets the name property of an enum element.
		 *
		 * @internal
		 * @throws BadMethodCallException if the name of the enum element is already set
		 *
		 * @param string $name  the name of the enum element
		 */
		private final function setName($name) {
			if ($this->name !== null)
				throw new BadMethodCallException('Cannot modify enum name once it has been assigned.');

			$this->name = $name;
		}

		/**
		 * Internal use only. Sets the ordinal property of an enum element.
		 *
		 * @internal
		 * @throws BadMethodCallException if the ordinal of the enum element is already set
		 *
		 * @param integer $ordinal  the ordinal of the enum element
		 */
		private final function setOrdinal($ordinal) {
			if ($this->ordinal !== null)
				throw new BadMethodCallException('Cannot modify enum ordinal once it has been assigned.');

			$this->ordinal = $ordinal;
		}

		/**
		 * Gets an array of all registered elements of the enum.
		 *
		 * @return array  an array containing all elements in the enum
		 */
		public static final function values() {
			if (!static::isDone())
				static::autoload();

			$key = get_called_class();

			if (array_key_exists($key, self::$types))
				return self::$types[$key];

			return array();
		}

		/**
		 * Attempts to match a string name to an enum element.
		 *
		 * Strings passed to this method will be converted to a format allowable in an enum name. That is to say,
		 * they will have any spaces or dashes converted to underscores, and all whitespace on either side of the
		 * string will be trimmed.
		 *
		 * @param  string $str the string to match to an enum element name
		 * @return the matched enum element, or null if one could not be found
		 */
		public static function valueOf($str) {
			$key = get_called_class();

			if (!static::isDone())
				static::autoload();

			$str = str_replace(array(' ', '-'), '_', trim($str));

			if (array_key_exists($str, self::$types[$key]))
				return self::$types[$key][$str];

			return null;
		}

		/**
		 * Matches an integer (via an enum element's ordinal property) to an enum element.
		 *
		 *
		 * @throws OutOfBoundsException if $ordinal is could not be matched to an enum element
		 *
		 * @param  integer $ordinal the ordinal number to be retrieved
		 * @return the matched enum element
		 */
		public static function fromOrdinal($ordinal) {
			$key = get_called_class();

			if (!array_key_exists($key, self::$types))
				return null;

			$values = self::$types[$key];

			if ($ordinal >= 0 && $ordinal < sizeof($values))
				return $values[$ordinal];

			throw new OutOfBoundsException(sprintf('%s is not a valid ordinal for %s.', $ordinal, $key));
		}

		/**
		 * @deprecated use the more succinct `done` method instead
		 * See @see done()
		 */
		protected static final function stopRegistration() {
			static::done();
		}

		/**
		 * Internal use only. Prevents any new enum elements from being registered under the current enum.
		 *
		 * @internal
		 */
		protected static final function done() {
			$name = get_called_class();

			if (self::isDone($name))
				return;

			self::$stopped[] = $name;
		}

		/**
		 * Checks if registration has been stopped for a particular enum.
		 *
		 * If no name is specified, it is assumed that the method was called from within the enum itself, and
		 * it's named will be determined via get_called_class().
		 *
		 * @param  string  $name optional; if set, it is the name of the enum to look up
		 * @return boolean       true if Enum::done has been called by the enum, false otherwise
		 */
		public static final function isDone($name = null) {
			if ($name === null)
				$name = get_called_class();

			return in_array($name, self::$stopped);
		}

		/**
		 * @deprecated use of isDone is preferred for naming consistency
		 * See @see isDone()
		 */
		public static final function isRegistrationStopped($name = null) {
			return self::isDone($name);
		}

		/**
		 * Gets the fully-qualified namespace of the enum. This is intended as a utility method for the EnumSet and
		 * EnumMap from the Collections suites, though it may be utilized elsewhere.
		 *
		 * @return string the full namespace of the enum
		 */
		public static final function ns() {
			return get_called_class();
		}

		/**
		 * Initializes the values of an enum.
		 *
		 * This method should ALWAYS be overridden when extending Enum.
		 */
		protected static function init() {
			// stub
		}

		protected static function autoload() {
			static::init();
			static::done();
		}

		/**
		 * Internal use only. Used to retrieve enum elements.
		 *
		 * @internal
		 * @throws InvalidArgumentException if an enum element is retrieved from the base class
		 * @throws InvalidArgumentException if no enum element could be found
		 */
		public static final function __callStatic($method, $args) {
			if (method_exists(self::NS_PATH, $method))
				return self::$method();

			$key = get_called_class();

			if ($key === self::NS_PATH)
				throw new InvalidArgumentException(sprintf('Cannot access %s of Enum parent class.', $method));

			if (!static::isDone())
				static::autoload();

			if (isset(self::$types[$key][$method]))
				return self::$types[$key][$method];

			throw new InvalidArgumentException(sprintf('No property %s found in %s.', $method, $key));
		}
	}
?>