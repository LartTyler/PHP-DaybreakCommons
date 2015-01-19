<?php
	use DaybreakStudios\Common\Collection\SimpleMap;

	class SimpleMapTest extends PHPUnit_Framework_TestCase {
		public function testSimpleGetAndPut() {
			$map = new SimpleMap();

			$this->assertEquals($map->get('unknown'), null);

			$map->put('test', 'value');

			$this->assertEquals($map->get('test'), 'value');
		}

		public function testCanMapObjects() {
			$map = new SimpleMap();

			$key1 = new stdClass();
			$key2 = new stdClass();

			$map->put($key1, 'Test value');

			$this->assertEquals($map->get($key1), 'Test value');
			$this->assertEquals($map->get($key2), null);
		}

		public function testCanOverwriteValues() {
			$map = new SimpleMap();

			$key = new stdClass();

			$map->put($key, 'test');

			$this->assertEquals($map->get($key), 'test');

			$map->put($key, 'test2');

			$this->assertEquals($map->get($key), 'test2');
		}

		public function testPutAll() {
			$map1 = new SimpleMap();

			$map1->put('test', 'value');
			$map1->put('test2', 'value2');

			$map2 = new SimpleMap();
			$map2->putAll($map1);

			$this->assertEquals($map1->keySet(), $map2->keySet());
			$this->assertEquals($map1->values(), $map2->values());
		}

		public function testSize() {
			$map = new SimpleMap();

			$map->put('test', 'value');
			$map->put('test2', 'value2');

			$this->assertEquals($map->size(), 2);

			$map->put('test', 'value3');

			$this->assertEquals($map->size(), 2);
		}

		public function testClear() {
			$map = new SimpleMap();

			$map->put('test', 'value');

			$this->assertEquals($map->size(), 1);

			$map->clear();

			$this->assertEquals($map->size(), 0);
		}

		public function testKeySet() {
			$map = new SimpleMap();

			$keys = array(
				'test',
				new stdClass(),
			);

			$map->put($keys[0], 'value');
			$map->put($keys[1], 'value2');

			$this->assertEquals($map->keySet(), $keys);
		}

		public function testValues() {
			$map = new SimpleMap();

			$values = array(
				'value',
				new stdClass(),
			);

			$map->put('test1', $values[0]);
			$map->put('test2', $values[1]);

			$this->assertEquals($map->values(), $values);
		}

		public function testToArray() {
			$map = new SimpleMap();

			$map->put('test', 'value');
			$map->put('test2', 'value2');

			$this->assertEquals($map->toArray(), array(
				'test' => 'value',
				'test2' => 'value2',
			));
		}

		/**
		 * @expectedException UnexpectedValueException
		 */
		public function testToArrayWithObjectKeys() {
			$map = new SimpleMap();

			$map->put(new stdClass(), 'value');

			$map->toArray();
		}
	}
?>