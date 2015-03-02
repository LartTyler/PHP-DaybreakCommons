<?php
	use DaybreakStudios\Common\Enum\Enum;

	class EnumTest extends PHPUnit_Framework_TestCase {
		public function testInit() {
			$this->assertEquals(TestEnum::A()->name(), 'A');
		}

		public function testMethod() {
			$this->assertEquals(TestEnum::A()->getAlt(), 'a');
		}

		/**
		 * @expectedException 				Exception
		 * @expectedExceptionMessageRegExp	/^Cannot access [^ ]+ of Enum parent class.$/
		 */
		public function testFailOnRootRef() {
			Enum::DOES_NOT_EXIST();
		}

		public function testInitNoCtor() {
			$this->assertEquals(TestEnumNoConstruct::Z()->name(), 'Z');
		}
	}

	class TestEnum extends Enum {
		private $alt;

		protected function __construct($alt) {
			$this->alt = $alt;
		}

		public function getAlt() {
			return $this->alt;
		}

		protected static function init() {
			parent::register('A', 'a');

			parent::stopRegistration();
		}
	}

	class TestEnumNoConstruct extends Enum {
		protected static function init() {
			parent::register('Z');

			parent::stopRegistration();
		}
	}
?>