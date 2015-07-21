<?php
	namespace DaybreakStudios\Common\IO;

	use \InvalidArgumentException;

	class FileReader implements Reader {
		const ERR_READER_CLOSED = 'Cannot %s; reader has been closed';

		protected $handle;
		protected $markPos = null;
		protected $markLim = null;
		protected $closed = false;

		protected $hasRead = false;

		public function __construct($file) {
			if (is_string($file))
				$file = fopen($file, 'r');
			else if (!is_resource($file) || get_resource_type($file) !== 'stream')
				throw new InvalidArgumentException('$file must be a stream resource');

			$this->handle = $file;
		}

		/**
		 * Returns true if the end of the stream has been reached.
		 *
		 * @return boolean true if the end of the stream has been reached
		 */
		public function eof() {
			if (!$this->hasRead) {
				$this->mark();

				fgetc($this->handle);

				$this->reset();
			}

			return feof($this->handle);
		}

		public function close() {
			fclose($this->handle);

			$this->closed = true;
		}

		public function mark($lim = null) {
			if (!$this->ready())
				throw new IOException(sprintf(self::ERR_READER_CLOSED, 'mark'));

			$this->markPos = ftell($this->handle);
			$this->markLim = $lim;
		}

		public function isMarkSupported() {
			return true;
		}

		public function read() {
			$this->hasRead = true;

			if (!$this->ready())
				throw new IOException(sprintf(self::ERR_READER_CLOSED, 'read'));

			return fgetc($this->handle);
		}

		public function ready() {
			return !$this->closed;
		}

		public function reset() {
			if ($this->markPos === null)
				throw new IOException('No mark to reset to');
			else if (ftell($this->handle) > $this->markPos + $this->markLim)
				throw new IOException('Stream has passed the mark limit');

			fseek($this->handle, $this->markPos);
		}

		public function skip($len) {
			if ($len < 0)
				throw new InvalidArgumentException('$len cannot be negative');

			fseek($this->handle, ftell($this->handle) + $len);
		}
	}
?>