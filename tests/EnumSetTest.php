<?php
	use DaybreakStudios\Common\Collection\EnumSet;
	use DaybreakStudios\Common\Enum\Enum;

	class EnumSetTest extends PHPUnit_Framework_TestCase {
		public function testAllOf() {
			$set = EnumSet::allOf('TestEnum');

			$this->assertEquals($set->size(), 4);
			$this->assertTrue($set->contains(TestEnum::A()));
			$this->assertTrue($set->contains(TestEnum::B()));
			$this->assertTrue($set->contains(TestEnum::C()));
			$this->assertTrue($set->contains(TestEnum::D()));
		}

		public function testNoneOf() {
			$set = EnumSet::noneOf('TestEnum');

			$this->assertEquals($set->size(), 0);
			$this->assertFalse($set->contains(TestEnum::A()));
			$this->assertFalse($set->contains(TestEnum::B()));
			$this->assertFalse($set->contains(TestEnum::C()));
			$this->assertFalse($set->contains(TestEnum::D()));
		}

		public function testAdd() {
			$set = EnumSet::noneOf('TestEnum');
			$set->add(TestEnum::C());

			$this->assertEquals($set->size(), 1);
			$this->assertFalse($set->contains(TestEnum::A()));
			$this->assertFalse($set->contains(TestEnum::B()));
			$this->assertTrue($set->contains(TestEnum::C()));
			$this->assertFalse($set->contains(TestEnum::D()));
		}

		public function testRemove() {
			$set = EnumSet::allOf('TestEnum');
			$set->remove(TestEnum::D());

			$this->assertEquals($set->size(), 3);
			$this->assertTrue($set->contains(TestEnum::A()));
			$this->assertTrue($set->contains(TestEnum::B()));
			$this->assertTrue($set->contains(TestEnum::C()));
			$this->assertFalse($set->contains(TestEnum::D()));
		}
	}

	class TestEnum extends Enum {
		public function __construct() {}

		public static function init() {
			parent::register('A');
			parent::register('B');
			parent::register('C');
			parent::register('D');

			parent::stopRegistration();
		}
	}

	TestEnum::init();
?>