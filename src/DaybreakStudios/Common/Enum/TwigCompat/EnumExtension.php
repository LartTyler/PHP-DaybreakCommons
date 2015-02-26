<?php
	namespace DaybreakStudios\Common\Enum\TwigCompat;

	use \InvalidArgumentException;
	use \Twig_Extension;

	class EnumExtension extends Twig_Extension {
		private $enums = array();

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