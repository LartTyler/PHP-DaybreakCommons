<?php
	namespace DaybreakStudios\Common\Enum;

	class EnumUtil {
		const ENUM_NAMESPACE = 'DaybreakStudios\Common\Enum\Enum';

		public static function isEnum($val, $class) {
			return is_object($val) && self::isEnumClass($class) && $val instanceof $class;
		}

		public static function isEnumClass($class, $autoload = true) {
			if ($autoload && !$class::isRegistrationHalted())
				$class::init();

			return is_string($class) && class_exists($class) && is_subclass_of($class, self::ENUM_NAMESPACE);
		}
	}
?>