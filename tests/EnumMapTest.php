<?php
	use DaybreakStudios\Common\Enum\Enum;
	use DaybreakStudios\Common\Collection\EnumMap;

	class EnumMapTest extends PHPUnit_Framework_TestCase {
		public function testSimpleGetAndPut() {
			$map = new EnumMap('EnumMapTestTestEnum');

			$this->assertEquals($map->get(EnumMapTestTestEnum::A()), null);

			$map->put(EnumMapTestTestEnum::A(), 'test');

			$this->assertEquals($map->get(EnumMapTestTestEnum::A()), 'test');
		}

		/**
		 * @expectedException InvalidArgumentException
		 */
		public function testBadKey() {
			$map = new EnumMap('EnumMapTestTestEnum');

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
