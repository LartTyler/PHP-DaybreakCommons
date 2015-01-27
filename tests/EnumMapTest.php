<?php
	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Collection\EnumMap;

	class EnumMapTest extends PHPUnit_Framework_TestCase {
		public function testSimpleGetAndPut() {
			$map = new EnumMap('TestEnum');

			$this->assertEquals($map->get(TestEnum::A()), null);

			$map->put(TestEnum::A(), 'test');

			$this->assertEquals($map->get(TestEnum::A()), 'test');
		}

		/**
		 * @expectedException InvalidArgumentException
		 */
		public function testBadKey() {
			$map = new EnumMap('TestEnum');

			$map->put('test', 'value');
		}
	}

	class TestEnum extends Enum {
		public function __construct() {}

		public static function init() {
			parent::register('A');
			parent::register('B');
			parent::register('C');

			parent::stopRegistration();
		}
	}

	TestEnum::init();
?>
