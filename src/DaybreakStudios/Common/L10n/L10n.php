<?php
	namespace DaybreakStudios\Common\L10n;

	class L10n {
		private function __construct(Loader $loader) {

		}

		public static function loadYaml(Yaml $loader) {
			return self::load($loader);
		}

		public static function load(Loader $loader) {
			return new L10n($loader);
		}
	}
?>