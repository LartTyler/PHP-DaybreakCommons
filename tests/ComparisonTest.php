<?php
	use \DateTime;
	use \DateTimeZone;

	use DaybreakStudios\Common\DateTime\DateTimeComparator;
	use DaybreakStudios\Common\DateTime\DateComparator;
	use DaybreakStudios\Common\DateTime\TimeComparator;

	class ComparisonTest extends PHPUnit_Framework_TestCase {
		public function testDateTimeComparisonLessThan() {
			$cmp = new DateTimeComparator();

			$a = new DateTime('-1 second');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), -1);
		}

		public function testDateTimeComparisonEqualTo() {
			$cmp = new DateTimeComparator();

			$a = new DateTime();
			$b = clone $a;

			$this->assertEquals($cmp->compare($a, $b), 0);
		}

		public function testDateTimeComparisonGreaterThan() {
			$cmp = new DateTimeComparator();

			$a = new DateTime();
			$b = new DateTime('-1 second');

			$this->assertEquals($cmp->compare($a, $b), 1);
		}

		public function testDateTimeCompositionLessThan() {
			$cmp = new DateTimeComparator();

			$a = new DateTime('-1 second');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->lessThan($b));
		}

		public function testDateTimeCompositionEqualTo() {
			$cmp = new DateTimeComparator();

			$a = new DateTime();
			$b = clone $a;

			$this->assertTrue($cmp->is($a)->equalTo($b));
		}

		public function testDateTimeCompositionGreaterThan() {
			$cmp = new DateTimeComparator();

			$a = new DateTime();
			$b = new DateTime('-1 second');

			$this->assertTrue($cmp->is($a)->greaterThan($b));
		}

		public function testDateComparisonLessThan() {
			$cmp = new DateComparator();

			$a = new DateTime('-1 day');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), -1);
		}

		public function testDateComparisonEqualTo() {
			$cmp = new DateComparator();

			$a = new DateTime('-30 minutes');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), 0);
		}

		public function testDateComparisonGreaterThan() {
			$cmp = new DateComparator();

			$a = new DateTime('+1 day');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), 1);
		}

		public function testDateCompositionLessThan() {
			$cmp = new DateComparator();

			$a = new DateTime('-1 day');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->lessThan($b));
		}

		public function testDateCompositionEqualTo() {
			$cmp = new DateComparator();

			$a = new DateTime('+30 minutes');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->equalTo($b));
		}

		public function testDateCompositionGreaterThan() {
			$cmp = new DateComparator();

			$a = new DateTime('+1 day');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->greaterThan($b));
		}

		public function testTimeComparisonLessThan() {
			$cmp = new TimeComparator();

			$a = new DateTime('-1 second');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), -1);
		}

		public function testTimeComparisonEqualTo() {
			$cmp = new TimeComparator();

			$a = new DateTime();
			$b = clone $a;

			$this->assertEquals($cmp->compare($a, $b), 0);
		}

		public function testTimeComparisonGreaterThan() {
			$cmp = new TimeComparator();

			$a = new DateTime('+1 second');
			$b = new DateTime();

			$this->assertEquals($cmp->compare($a, $b), 1);
		}

		public function testTimeCompositionLessThan() {
			$cmp = new TimeComparator();

			$a = new DateTime('-1 second');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->lessThan($b));
		}

		public function testTimeCompositionEqualTo() {
			$cmp = new TimeComparator();

			$a = new DateTime();
			$b = clone $a;

			$this->assertTrue($cmp->is($a)->equalTo($b));
		}

		public function testTimeCompositionGreaterThan() {
			$cmp = new TimeComparator();

			$a = new DateTime('+1 second');
			$b = new DateTime();

			$this->assertTrue($cmp->is($a)->greaterThan($b));
		}
	}
?>