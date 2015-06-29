<?php
	namespace DaybreakStudios\Common\IO;

	interface Reader {
		/**
		 * Closes the stream and frees any resources associated with it.
		 */
		public function close();

		/**
		 * Marks the current location in the stream.
		 *
		 * @throws IOException if the stream does not support the mark operation
		 *
		 * @param  int $lim the number of characters that may be read before the mark is cleared
		 */
		public function mark($lim);

		/**
		 * Returns true if the reader supports marking streams.
		 *
		 * @return boolean true if mark is supported, false otherwise
		 */
		public function isMarkSupported();

		/**
		 * Reads data from the stream. The return value of this function is dependant on the implementation.
		 *
		 * @throws IOException if the stream could not be read from
		 *
		 * @return mixed the data that was read
		 */
		public function read();

		/**
		 * Returns true if the stream is ready to be read from.
		 *
		 * @return boolean true if the stream is ready to be read from
		 */
		public function ready();

		/**
		 * Resets the stream to the last marked position.
		 *
		 * @throws IOException if the stream has not been marked, the mark has been invalidated, or the stream does not
		 *         support the reset operation
		 */
		public function reset();

		/**
		 * Moves the stream forward $len characters.
		 *
		 * @throws InvalidArgumentException if $len is negative
		 * @throws IOException if there is a problem accessing the stream
		 *
		 * @param  int $len the number of characters to move forward
		 */
		public function skip($len);
	}
?>