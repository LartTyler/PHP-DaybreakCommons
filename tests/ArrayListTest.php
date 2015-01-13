<?php
	use DaybreakStudios\Common\Collection\ArrayList;

	class ArrayListTest extends PHPUnit_Framework_TestCase {
		public function testEmptyConstructor() {
			$list = new ArrayList();

			$this->assertEmpty($list->toArray(), 'An ArrayList with no initilizing array is empty');
		}

		public function testArrayConstructor() {
			$list = new ArrayList(array(
				'Test1',
				'Test2',
			));

			$this->assertCount(2, $list->toArray(), 'An ArrayList with an initilizng array contains the same number of elements.');
		}

		public function testModifications() {
			$list = new ArrayList();

			$list->add('Test1');

			$this->assertEquals($list->get(0), 'Test1', 'Elements can be added');

			$list->add('Test2');
			$list->remove(0);

			$this->assertEquals($list->get(0), 'Test2', 'ArrayList should resize after modifications.');
		}

		public function testRemove() {
			$list = new ArrayList();

			$list->add('Test');
			$list->add('Test');
			$list->add('test');

			$list->remove('Test');

			$this->assertEquals($list->toArray(), array('Test', 'test'), 'Remove should only remove the first occurrance');

			$list->remove('test');

			$this->assertEquals($list->toArray(), array('Test'), 'Removals for strings should be case sensitive.');
		}

		public function testIterate() {
			$list = new ArrayList(array(
				'Test1',
				'Test2',
				'Test3',
				'Test4',
			));

			foreach ($list as $v) {
				$i = $list->indexOf($v);

				$list->remove($i);
			}

			printf('<pre>%s</pre>', print_r($list->toArray(), true));

			$this->assertEmpty($list->toArray(), 'ArrayList should be iterable.');
		}
	}
?>