<?php
	namespace DaybreakStudios\Common\Enum\TwigCompat;

	use \InvalidArgumentException;
	use \Twig_Extension;

	use DaybreakStudios\Common\Enum\EnumUtil;

	/**
	 * A Twig extension class that can be used to introduce enums into the Twig environment.
	 */
	class EnumExtension extends Twig_Extension {
		private $enums = array();

		/**
		 * Creates a new EnumExtension.
		 *
		 * @throws InvalidArgumentException if one or more enum class names collide with each other
		 *
		 * @param string $prefix     the prefix for all enums loaded this way; by default, enums are named after their class
		 * @param string $paths,...  one or more fully-qualified namespaces of enums to load
		 */
		public function __construct($prefix = '', ... $paths) {
			foreach ($paths as $path)
				if (EnumUtil::isEnumClass($path)) {
					$name = explode('\\', $path);
					$name = $name[sizeof($name) - 1];

					if (isset($this->enums[$prefix . $name]))
						throw new InvalidArgumentException($path . ' conflicts with another enum!');

					$this->enums[$prefix . $name] = new EnumWrapper($path::values());
				}
		}

		public function getGlobals() {
			return $this->enums;
		}

		public function getName() {
			return 'dbstudios.common.twig.extension.enum';
		}
	}
?>