<?php
	namespace DaybreakStudios\Common\Utility;

	use \OutOfBoundsException;

	use DaybreakStudios\Common\Collection\SimpleMap;

	class Counter {
		private $strict;
		private $keys;
		private $counts;

		public function __construct($strict = false, array $keys = []) {
			$this->strict = $strict;
			$this->keys = $keys;
			$this->counts = new SimpleMap();
		}

		public function get($key) {
			return $this->counts->get($key);
		}

		public function set($key, $value) {
			$this->counts->put($key, $value);
		}

		public function clear($key = null) {
			if ($key === null)
				$this->counts->clear();
			else
				$this->counts->remove($key);
		}

		public function add($key, $amount) {
			if (!$this->allowed($key))
				throw new OutOfBoundsException(sprintf('"%s" is not an allowed key in strict mode', $key));
			else if (!$this->has($key))
				$this->counts->put($key, 0);

			$this->counts->put($key, $this->counts->get($key) + $amount);

			return $this->counts->get($key);
		}

		public function sub($key, $amount) {
			if (!$this->allowed($key))
				throw new OutOfBoundsException(sprintf('"%s" is not an allowed key in strict mode', $key));
			else if (!$this->has($key))
				$this->counts->put($key, 0);

			$this->counts->put($key, $this->counts->get($key) - $amount);

			return $this->counts->get($key);
		}

		public function has($key) {
			return $this->counts->containsKey($key);
		}

		public function allowed($key) {
			return !$this->strict || in_array($key, $this->keys);
		}

		public function inc($key) {
			$this->add($key, 1);
		}

		public function dec($key) {
			$this->sub($key, 1);
		}
	}
?>