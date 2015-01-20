<?php
	use DaybreakStudios\Common\Collection\SimpleSet;

	class SimpleSetTest extends PHPUnit_Framework_TestCase {
		public function testEmptyConstructor() {
			$set = new SimpleSet();

			$this->assertEquals($set->size(), 0);
		}

		public function testNonEmptyConstruct() {
			$set = new SimpleSet(array(
				'Testing',
			));

			$this->assertTrue($set->contains('Testing'));
		}

		public function testNonEmptyConstructWithDuplicates() {
			$set = new SimpleSet(array(
				'Testing',
				'Testing',
				'testing',
			));

			$this->assertEquals($set->size(), 2);
			$this->assertTrue($set->contains('Testing'));
			$this->assertTrue($set->contains('testing'));
		}

		public function testAdd() {
			$set = new SimpleSet();

			$set->add('Testing');

			$this->assertTrue($set->contains('Testing'));
			$this->assertFalse($set->contains('testing'));
		}

		public function testRemove() {
			$set = new SimpleSet();

			$set->add('Testing');

			$this->assertTrue($set->contains('Testing'));

			$set->remove('Testing');

			$this->assertFalse($set->contains('Testing'));
		}
	}
?>