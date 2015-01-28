<?php
	namespace DaybreakStudios\Common\DateTime;

	class DateComparator extends AbstractDateTimeAwareComparator {
		public function __construct() {
			parent::__construct();
		}

		public function compare($a, $b) {
			if (!$this->accepts($a) || !$this->accepts($b))
				throw new InvalidArgumentException('Both arguments must be DateTime objects');

			list($a, $b) = $this->copyAndNormalize($a, $b);

			$a->setTime(0, 0, 0);
			$b->setTime(0, 0, 0);

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