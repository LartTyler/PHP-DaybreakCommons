<?php
	namespace DaybreakStudios\Common\Utility;

	use \OutOfBoundsException;

	use DaybreakStudios\Common\Collection\SimpleMap;

	class Counter {
		private $strict;
		private $keys;
		private $counts;

		/**
		 * @param boolean $strict if strict is true, only keys defined at construction will be allowed
		 * @param array   $keys   if strict is true, the list of keys that are permitted in the counter
		 */
		public function __construct($strict = false, array $keys = []) {
			$this->strict = $strict;
			$this->keys = $keys;
			$this->counts = new SimpleMap();
		}

		/**
		 * Retrieves the current value of the given key.
		 *
		 * @param  mixed $key the key to retrieve
		 * @return mixed      the value of the key, or null if the key does not exist
		 */
		public function get($key) {
			return $this->counts->get($key);
		}

		/**
		 * Sets the value of the given key.
		 *
		 * @param  mixed   $key   the key to set
		 * @param  mixed   $value the value to set the key to
		 * @return Counter an object reference for method chaining
		 */
		public function set($key, $value) {
			$this->counts->put($key, $value);

			return $this;
		}

		/**
		 * Clears the given key, or the entire counter if the key is not given.
		 *
		 * @param  mixed $key the key to clear; pass null to clear the entire counter
		 */
		public function clear($key = null) {
			if ($key === null)
				$this->counts->clear();
			else
				$this->counts->remove($key);
		}

		/**
		 * Adds the given amount to a key. If the key does not exist and the counter is not running in strict mode, it
		 * will be initialized to zero.
		 *
		 * @throws OutOfBoundsException if the counter is in strict mode and the key was not defined at construction
		 *
		 * @param  mixed     $key    the key to add to
		 * @param  int|float $amount the amount to add to the key
		 * @return int|float the new value of the key
		 */
		public function add($key, $amount) {
			if (!$this->allowed($key))
				throw new OutOfBoundsException(sprintf('"%s" is not an allowed key in strict mode', $key));
			else if (!$this->has($key))
				$this->counts->put($key, 0);

			$this->counts->put($key, $this->counts->get($key) + $amount);

			return $this->counts->get($key);
		}

		/**
		 * Subtracts the given amount from a key. If the key does not exist and the counter is not running in strict
		 * mode, it will be initialized to zero.
		 *
		 * @throws OutOfBoundsException if the counter is in strict mode and the key was not defined at construction
		 *
		 * @param  mixed     $key    the key to subtract from
		 * @param  int|float $amount the amount to subtract from the key
		 * @return int|float the new value of the key
		 */
		public function sub($key, $amount) {
			if (!$this->allowed($key))
				throw new OutOfBoundsException(sprintf('"%s" is not an allowed key in strict mode', $key));
			else if (!$this->has($key))
				$this->counts->put($key, 0);

			$this->counts->put($key, $this->counts->get($key) - $amount);

			return $this->counts->get($key);
		}

		/**
		 * Returns true if the key exists.
		 *
		 * @param  mixed  $key the key to check for
		 * @return boolean     true if the key exists, false otherwise
		 */
		public function has($key) {
			return $this->counts->containsKey($key);
		}

		/**
		 * Returns true if the key is allowed by the counter. If the counter is not running in strict mode, this method
		 * will always return true.
		 *
		 * @param  mixed $key the key to check
		 * @return boolean    true if the key is permitted or the counter is not in strict mode
		 */
		public function allowed($key) {
			return !$this->strict || in_array($key, $this->keys);
		}

		/**
		 * Adds one to the given key.
		 *
		 * @throws OutOfBoundsException if the counter is in strict mode and the key was not defined at construction
		 *
		 * @param  mixed $key the key to increment
		 * @return int|float  the new value of the key
		 */
		public function inc($key) {
			return $this->add($key, 1);
		}

		/**
		 * Subtracts one from the given key.
		 * @throws OutOfBoundsException if the counter is in strict mode and the key was not defined at construction
		 *
		 * @param  mixed $key the key to decrement
		 * @return int|float  the new value of the key
		 */
		public function dec($key) {
			$this->sub($key, 1);
		}
	}
?>