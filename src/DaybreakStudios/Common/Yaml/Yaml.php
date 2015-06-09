<?php
	namespace DaybreakStudios\Common\Yaml;

	use Symfony\Component\Yaml as SymfonyYaml;

	class Yaml extends SymfonyYaml {
		private $data = array();

		private function __construct(array $data) {
			$this->data = $this->walk($data);
		}

		protected function walk(array $array, $path = '') {
			$d = array();

			foreach ($array as $k => $v)
				if (!is_array($v))
					$d[$path . $k] = $v;
				else
					$d = array_merge($this->walk($v, $path . $k . '.'));

			return $d;
		}

		public function get($path, $def = null) {
			if ($this->has($path))
				return $this->data[$path];

			return $def;
		}

		public function has($path) {
			return isset($this->data[$path]);
		}

		public function set($path, $value) {
			$this->data[$path] = $value;

			return $this;
		}

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

		public static function parse($input, $typeCheck = false, $objectSupport = false, $objectForMap = false) {
			return new Yaml(parent::parse($input, $typeCheck, $objectSupport, $objectForMap));
		}

		public static function dump($array, $inline = 2, $indent = 4, $typeCheck = false, $objectSupport = false) {
			if ($array instanceof Yaml)
				$array = $array->toArray();

			return parent::dump($array, $inline, $indent, $typeCheck, $objectSupport);
		}
	}
?>