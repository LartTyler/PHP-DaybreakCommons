<?php
	use DaybreakStudios\Common\Enum\Enum;

	class EnumTest extends PHPUnit_Framework_TestCase {
		public function testInit() {
			$this->assertEquals(EnumTestTestEnum::A()->name(), 'A');
		}

		public function testMethod() {
			$this->assertEquals(EnumTestTestEnum::A()->getAlt(), 'a');
		}

		/**
		 * @expectedException 				Exception
		 * @expectedExceptionMessageRegExp	/^Cannot access [^ ]+ of Enum parent class.$/
		 */
		public function testFailOnRootRef() {
			Enum::DOES_NOT_EXIST();
		}

		public function testInitNoCtor() {
			$this->assertEquals(EnumTestTestEnumNoConstruct::Z()->name(), 'Z');
		}

		public function testToString() {
			echo "\n\nTestEnum::" . EnumTestTestEnum::A() . "\n\n";
			$this->assertEquals('TestEnum::' . EnumTestTestEnum::A(), 'TestEnum::A');
		}
	}

	class EnumTestTestEnum extends Enum {
		private $alt;

		protected function __construct($alt) {
			$this->alt = $alt;
		}

		public function getAlt() {
			return $this->alt;
		}

		protected static function init() {
			parent::register('A', 'a');
		}
	}

	class EnumTestTestEnumNoConstruct extends Enum {
		protected static function init() {
			parent::register('Z');
		}
	}
?>