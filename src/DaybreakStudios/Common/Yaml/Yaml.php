<?php
	namespace DaybreakStudios\Common\Yaml;

	use \RuntimeException;

	use Symfony\Component\Yaml\Yaml as SymfonyYaml;

	/**
	 * An extension to Symfony's Yaml class that adds additional utility methods.
	 */
	class Yaml extends SymfonyYaml {
		private $data = array();

		/**
		 * Creates a new Yaml instance using the given data.
		 *
		 * @param array $data the data to parse
		 */
		private function __construct(array $data) {
			$this->walk($data);
		}

		/**
		 * Recursively walks over an array to flatten it's keys for faster look up.
		 *
		 * @param  array  $array the array to walk over
		 * @param  string $path  optional; the current path we're walking
		 */
		protected function walk(array $array, $path = '') {
			foreach ($array as $k => $v)
				if (!is_array($v) || !(bool)count(array_filter(array_keys($v), 'is_string')))
					$this->data[$path . $k] = $v;
				else
					$this->walk($v, $path . $k . '.');
		}

		/**
		 * Returns the value stored at the given path.
		 *
		 * @param  string $path the path to retrieve
		 * @param  mixed  $def  optional; the default value if no mapping is found
		 * @return mixed        the value, or the given default if no value is found
		 */
		public function get($path, $def = null) {
			if ($this->has($path))
				return $this->data[$path];

			return $def;
		}

		/**
		 * Returns true if the loaded YAML mapping has a value at the given path.
		 *
		 * @param  string  $path the path to test
		 * @return boolean       true if the path exists
		 */
		public function has($path) {
			return isset($this->data[$path]);
		}

		/**
		 * Sets the value at the given path.
		 *
		 * @param string $path  the path to place the value at
		 * @param Yaml   $value this object for method chaining
		 */
		public function set($path, $value) {
			$this->data[$path] = $value;

			return $this;
		}

		/**
		 * Attempts to save the loaded mapping in the given file.
		 *
		 * @param  string $file the path to the file to write to
		 * @return boolean      true if the operation was successful, false if the file could not be written to
		 */
		public function save($file) {
			if (!is_writable(dirname($file)))
				return false;

			$f = fopen($file, 'w+');

			if ($f === false)
				$check = false;
			else
				$check = fwrite($f, $this->stringify());

			fclose($f);

			return $check;
		}

		/**
		 * Returns an array contaning the data held by a Yaml instance.
		 *
		 * @return array a plain array representation of the stored YAML data
		 */
		public function toArray() {
			$array = array();

			foreach ($this->data as $k => $v) {
				$nodes = explode('.', $k);
				$loc = &$array;

				foreach ($nodes as $i => $node)
					if ($i === sizeof($nodes) - 1)
						$loc[$node] = $v;
					else if (!isset($array[$node])) {
						$loc[$node] = array();

						$loc = &$loc[$node];
					}
			}

			return $array;
		}

		/**
		 * Dumps the Yaml object to a YAML string. This is the same as invoking Yaml::dump() with the Yaml object as
		 * the first argument.
		 *
		 * @return string a YAML string representing the data contained in the Yaml object
		 */
		public function stringify() {
			return Yaml::dump($this);
		}

		/**
		 * Parses YAML into a Yaml object.
		 *
		 * @see http://api.symfony.com/2.7/Symfony/Component/Yaml/Yaml.html#method_parse
		 *
		 * @throws ParseException if the YAML is not valid
		 *
		 * @param  string  $input         the YAML to parse
		 * @param  boolean $typeCheck     whether or not to throw exceptions on invalid types
		 * @param  boolean $objectSupport whether or not to enable object support
		 * @return Yaml                   a Yaml instance containing the parsed YAML data
		 */
		public static function parse($input, $typeCheck = false, $objectSupport = false) {
			return new Yaml(parent::parse($input, $typeCheck, $objectSupport, $objectForMap));
		}

		/**
		 * Dumps a PHP array or a Yaml object to a YAML string. For Yaml instances, you can simply call the
		 * `stringify()` instance method.
		 *
		 * @see stringify()
		 * @see http://api.symfony.com/2.7/Symfony/Component/Yaml/Yaml.html#method_dump
		 *
		 * @param  mixed   $array         a PHP array or Yaml instance to dump
		 * @param  integer $inline        the level at which to switch to inline YAML
		 * @param  integer $indent        the amount of spaces to use for indentation
		 * @param  boolean $typeCheck     whether or not to throw exceptions on invalid types
		 * @param  boolean $objectSupport whether or not to enable object support
		 * @return string                 a YAML string representation of the dumped value
		 */
		public static function dump($array, $inline = 2, $indent = 4, $typeCheck = false, $objectSupport = false) {
			if ($array instanceof Yaml)
				$array = $array->toArray();

			return parent::dump($array, $inline, $indent, $typeCheck, $objectSupport);
		}
	}
?>