<?php
	namespace DaybreakStudios\Common\Enum;

	class EnumUtil {
		public static function isEnum($val, $class) {
			return is_object($val) && $val instanceof $class;
		}

		public static function isEnumClass($class) {
			if (!is_string($class) || !class_exists($class) || !is_subclass_of($class, 'DaybreakStudios\Common\Enum\Enum'))
				return false;

			return true;
		}
	}
?>