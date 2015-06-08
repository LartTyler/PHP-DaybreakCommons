<?php
	namespace DaybreakStudios\Common\Enum;

	use \BadMethodCallException;
	use \Exception;
	use \InvalidArgumentException;
	use \ReflectionClass;

	abstract class Enum {
		const NS_PATH = 'DaybreakStudios\Common\Enum\Enum';

		private static $stopped = array();
		private static $types = array();

		private $name;
		private $ordinal;

		/**
		 * Registers a new element to an enum.
		 *
		 * This may ONLY be called from within a subclass of Enum, as it relys on PHP's get_called_class() to determine
		 * which enum to register to.
		 *
		 * Enum::register accepts a variable number of arguments, but should always have at least a single argument which
		 * names the element being added. Any arguments following the first will be passed, in order, to the constructor
		 * of whichever enum is being registered to.
		 *
		 * @param string $name 			the name of the enum being registered
		 * @param mixed  $ctors,... 	zero or more arguments to be passed to the enum's constructor
		 */
		protected static function register($name, ... $ctors) {
			$key = get_called_class();

			if (self::isRegistrationHalted($key))
				throw new Exception(sprintf('Registration has been halted for %s; cannot add %s to the enum list.',
					$key, $name));

			if (!array_key_exists($key, self::$types))
				self::$types[$key] = array();

			$inst = new $key(... $ctors);

			$inst->setName($name);
			$inst->setOrdinal(sizeof(self::$types[$key]));

			self::$types[$key][$name] = $inst;
		}

		/**
		 * @internal
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

		/**
		 * Internal use only. Sets the name property of an enum element.
		 *
		 * @internal
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

			if (!array_key_exists($key, self::$types))
				return null;

			$str = str_replace(array(' ', '-'), '_', trim($str));

			if (array_key_exists($str, self::$types[$key]))
				return self::$types[$key][$str];

			return null;
		}

		/**
		 * Matches an integer (via an enum element's ordinal property) to an enum element.
		 *
		 * If the ordinal is out of range, an InvalidArgumentException will be thrown.
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

			throw new InvalidArgumentException(sprintf('%s is not a valid ordinal for %s.', $ordinal, $key));
		}

		/**
		 * @deprecated use the more succinct `done` method instead
		 * See @see done()
		 */
		protected static final function stopRegistration() {
			self::done(get_called_class());
		}

		/**
		 * Prevents any new enum elements from being registered under a particular enum.
		 *
		 * @param string $name optional; if set, it is the name of the enum to stop registration for (used for
		 *                     forwarding calls from @see stopRegistration())
		 */
		protected static final function done($name = null) {
			if ($name === null)
				$name = get_called_class();

			if (self::isRegistrationStopped($name))
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

			return in_array($name, self::$stopRegistration);
		}

		/**
		 * @deprecated use of isDone is preferred for naming consistency
		 * See @see isDone()
		 */
		public static final function isRegistrationStopped($name = null) {
			return self::isDone($name);
		}

		/**
		 * Initializes the values of an enum.
		 *
		 * This method should ALWAYS be overridden when extending Enum.
		 */
		protected static function init() {
			static::stopRegistration();
		}

		/**
		 * Internal use only. Used to retrieve enum elements.
		 *
		 * @internal
		 */
		public static final function __callStatic($method, $args) {
			if (method_exists(self::NS_PATH, $method))
				return self::$method();

			$key = get_called_class();

			if ($key === self::NS_PATH)
				throw new Exception(sprintf('Cannot access %s of Enum parent class.', $method));

			if (!isset(self::$types[$key])) {
				$key::init();
				$key::done();
			}

			if (isset(self::$types[$key][$method]))
				return self::$types[$key][$method];

			throw new Exception(sprintf('No property %s found in %s.', $method, $key));
		}
	}
?>