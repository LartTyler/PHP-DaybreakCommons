<?php
	namespace DaybreakStudios\Common\DateTime;

	use \DateTimeZone;
	use \InvalidArgumentException;

	class TimeComparator extends AbstractDateTimeAwareComparator {
		public function __construct() {
			parent::__construct();
		}

		public function compare($a, $b) {
			if (!$this->accepts($a) || !$this->accepts($b))
				throw new InvalidArgumentException('Both arguments must be DateTime objects');

			$tz = new DateTimeZone('UTC');

			$a = clone $a;
			$a
				->setDate(2015, 01, 01)
				->setTimezone($tz);

			$b = clone $b;
			$b
				->setDate(2015, 01, 01)
				->setTimezone($tz);

			$diff = $a->getTimestamp() - $b->getTimestamp();

			if ($diff < 0)
				return -1;
			else if ($diff === 0)
				return 0;
			else
				return 1;
		}
	}
?>