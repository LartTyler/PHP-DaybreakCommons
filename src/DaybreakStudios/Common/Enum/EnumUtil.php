<?php
	namespace DaybreakStudios\Common\Enum;

	class EnumUtil {
		const ENUM_NAMESPACE = 'DaybreakStudios\Common\Enum\Enum';

		/**
		 * Checks if a value is an enum and is an instance of or child of the provided class.
		 *
		 * @param  object   $val  the object to check
		 * @param  string  $class the full namespace of the enum class to check the object against
		 * @return boolean        true if $val is an object, $class represents and Enum object, and $val is an instance of $class
		 */
		public static function isEnum($val, $class) {
			return is_object($val) && self::isEnumClass($class) && $val instanceof $class;
		}

		/**
		 * Checks if an class is an enum. This will also perform autoloading on that class if $autoload is true.
		 *
		 * @param  string  $class    the string namespace of the class to check
		 * @param  boolean $autoload if true, and $class has not been initialized, the Enum::init method will be called
		 * @return boolean           true if $class is an enum class, false otherwise
		 */
		public static function isEnumClass($class, $autoload = true) {
			if ($autoload && !$class::isDone())
				$class::autoload();

			return is_string($class) && class_exists($class) && is_subclass_of($class, self::ENUM_NAMESPACE);
		}
	}
?>