<?php
	namespace DaybreakStudios\Common\DateTime;

	use \DateTime;
	use \DateTimeZone;

	use DaybreakStudios\Common\Comparison\Comparator;
	use DaybreakStudios\Common\Comparison\SimpleComparatorComposition;

	abstract class AbstractDateTimeAwareComparator implements Comparator {
		private $utcTimezone = null;

		public function __construct() {
			$this->utcTimezone = new DateTimeZone('UTC');
		}

		public function is($a) {
			if (!$this->accepts($a))
				throw new InvalidArgumentException('$a must be a DateTime object');

			return new SimpleComparatorComposition($this, $a);
		}

		public function accepts($value) {
			return is_object($value) && $value instanceof DateTime;
		}

		protected function copyAndNormalize(/*DateTime... args */) {
			if ($this->utcTimezone === null)
				$this->utcTimezone = new DateTimeZone('UTC');

			$args = func_get_args();

			foreach ($args as $i => $dt)
				if ($dt instanceof DateTime) {
					$dt = clone $dt;

					$dt->setTimezone($this->utcTimezone);

					$args[$i] = $dt;
				} else
					throw new InvalidArgumentException('All arguments must be DateTime objects');

			return $args;
		}
	}
?>