<?php
	namespace DaybreakStudios\Common\Collection;

	/**
	 * An ordered collection. Implementations of this interface have precise control over where elements in the list are
	 * added and removed. Elements can be accessed by their indexes.
	 *
	 * Lists will typically allow duplicate entries and null elements.
	 */
	interface CollectionList extends Collection {
		/**
		 * Inserts the given element at the given index into this list (optional operation). Shifts the element at that
		 * position (if there is one) and all subsequent elements (if there are any) to the right (adds one to their
		 * index).
		 *
		 * @throws BadMethodCallException if the `addAt` operation is not supported
		 * @throws OutOfBoundsException if the index is out of range (index < 0 || index > size())
		 * @throws InvalidArgumentException if some property of the element prevented it from being added to this list
		 *         (such as type)
		 *
		 * @param integer $index the index that the element should be inserted at
		 * @param mixed $element the element to insert
		 */
		public function addAt($index, $element);

		/**
		 * Inserts all of the elements in the given collection into this list, starting at the given index (optional
		 * operation). Shifts the element at that position (if there is one) and any subsequent elements (if there are
		 * any) to the right (adds one of their index).
		 *
		 * @throws BadMethodCallException if the `addAllAt` operation is not supported
		 * @throws OutOfBoundsException if the index is out of range (index < 0 || index > size())
		 * @throws InvalidArgumentException if some property of an element in the collection prevented it from being
		 *         added  to this list (such as type)
		 *
		 * @param integer    $index the index that the elements should be inserted at
		 * @param Collection $c     the collection containing the elements to insert into this list
		 */
		public function addAllAt($index, Collection $c);

		/**
		 * Returns the element at the specified index in this list.
		 *
		 * @throws OutOfBoundsException if the index is out of range (index < 0 || index >= size())
		 *
		 * @param  integer $index the index of the element to return
		 * @return mixed          the element at the specified position in this list
		 */
		public function get($index);

		/**
		 * Returns the index of the first occurrence of the given element in this list, or -1 if this list does not
		 * contain the element.
		 *
		 * @param  mixed $element the element to search for
		 * @return integer        the index of the first occurrence of the element, or -1 if this list does not contain
		 *                        the element
		 */
		public function indexOf($element);

		/**
		 * Returns the index of the last occurrence of the given element in this list, or -1 if this list does not
		 * contain the element.
		 *
		 * @param  mixed $element the element to search for
		 * @return integer        the index of the last occurrence of the element, or -1 if this list does not contain
		 *                        the element
		 */
		public function lastIndexOf($element);

		/**
		 * Replaces the element at the given position with the given element (optional operation).
		 *
		 * @throws BadMethodCallException if the `set` operation is not supported
		 * @throws OutOfBoundsException if the index is out of range (index < 0 || index >= size())
		 * @throws InvalidArgumentException if some property of the element prevented it from being added  to this list
		 *         (such as type)
		 *
		 * @param integer $index  the index of the element to replace
		 * @param mixed $element  the element that was previously at the given index
		 */
		public function set($index, $element);

		/**
		 * Returns a portion of this list between the the `start` index, inclusive, and the `end` index, exclusive.
		 *
		 * if `end` is larger than `start`, they will be swapped before performing this operation.
		 *
		 * @throws OutOfBoundsException if start or end are out of range
		 *         (start < 0 || end < 0 || start >= size() || end > size())
		 *
		 * @param  integer $start the index to begin the sublist at
		 * @param  integer $end   optional; the index to end the sublist at
		 * @return CollectionList the resulting sublist
		 */
		public function subList($start, $end = null);
	}
?>