<?php
	namespace DaybreakStudios\Common\IO;

	class CsvFileReader extends FileReader {
		protected $fields = [];

		public function addField($name, $pos = null) {
			if ($pos === null)
				$pos = sizeof($this->fields);

			$fields[$pos] = $name;

			return $this;
		}

		public function read() {
			if (!$this->ready())
				throw new IOException(sprintf(self::ERR_READER_CLOSED, 'read'));

			$row = fgetcsv($this->handle);

			if ($row === false)
				return false;

			$data = [];

			foreach ($this->fields as $pos => $name)
				$data[$name] = $row[$pos];

			return (object)$data;
		}
	}
?>