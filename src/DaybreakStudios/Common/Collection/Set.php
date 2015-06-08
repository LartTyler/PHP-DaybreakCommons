<?php
	namespace DaybreakStudios\Common\Collection;

	/**
	 * This is the parent interface for any Collection that is a set.
	 *
	 * Sets do not permit duplicate entries, and may place additional restrictions on some methods inherited from the
	 * `Collection` interface.
	 *
	 * @see Collection
	 */
	interface Set extends Collection {}
?>