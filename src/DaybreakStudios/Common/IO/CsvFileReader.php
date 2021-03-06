<?php
	namespace DaybreakStudios\Common\IO;

	use \InvalidArgumentException;

	class CsvFileReader extends FileReader {
		protected $fields = [];
		protected $transformers = [];

		/**
		 * Adds a named field to a CSV row.
		 *
		 * @param string   $name        the name of the field
		 * @param callable $transformer optional; a callback that can be used to transform the field value
		 * @param int      $pos         optional; the column number of the field, if not specified it will append the
		 *                              colum name to the list
		 * @return CsvFileReader  		an object reference for method chaining
		 */
		public function addField($name, $transformer = null, $pos = null) {
			if ($pos === null)
				$pos = sizeof($this->fields);

			$this->fields[$pos] = $name;

			if (is_callable($transformer))
				$this->transformers[$pos] = $transformer;
			else if ($transformer !== null)
				throw new InvalidArgumentException('The transformer provided for ' . $name . ' is not callable');

			return $this;
		}

		/**
		 * Adds multiple fields with an optional transformer to a CSV row.
		 *
		 * @param array $fields the fields to add; can either be an array of string names, or an associative array where
		 *                      the array key is the field name, and the value is the transformer to use for that column
		 * @return CsvFileReader an object reference for method chaining
		 */
		public function addFields(array $fields) {
			foreach ($fields as $k => $v)
				if (is_string($k))
					$this->addField($k, $v);
				else
					$this->addField($v);

			return $this;
		}

		public function read() {
			if (!$this->ready())
				throw new IOException(sprintf(self::ERR_READER_CLOSED, 'read'));

			$row = fgetcsv($this->handle);

			if ($row === false || empty($this->fields))
				return $row;
			else if (sizeof($row) < sizeof($this->fields))
				throw new IOException('One or more rows in your CSV have fewer columns than the number of fields');

			$data = [];

			foreach ($this->fields as $pos => $name) {
				$value = $row[$pos];

				if (isset($this->transformers[$pos]))
					$value = call_user_func($this->transformers[$pos], $value);

				$data[$name] = $value;
			}

			return (object)$data;
		}
	}
?>