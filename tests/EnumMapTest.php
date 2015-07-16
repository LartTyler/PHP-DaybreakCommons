<?php
	use \EnumMapTestTestEnum as TestEnum;

	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Collection\EnumMap;

	class EnumMapTest extends PHPUnit_Framework_TestCase {
		public function testSimpleGetAndPut() {
			$map = new EnumMap(TestEnum::ns());

			$this->assertNull($map->get(TestEnum::A()));

			$map->put(TestEnum::A(), 'test');

			$this->assertEquals($map->get(TestEnum::A()), 'test');
		}

		/**
		 * @expectedException InvalidArgumentException
		 */
		public function testBadKey() {
			$map = new EnumMap(TestEnum::ns());

			$map->put('test', 'value');
		}
	}

	class EnumMapTestTestEnum extends Enum {
		public static function init() {
			parent::register('A');
			parent::register('B');
			parent::register('C');
		}
	}
?>
