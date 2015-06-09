<?php
	namespace DaybreakStudios\Common\Collection;

	use \IteratorAggregate;

	/**
	 * Base interface for most objects in the Collections library.
	 *
	 * Not all methods defined in this interface are required in child classes. Any methods without an implementation
	 * should throw a BadMethodCallException to denote unsupported operations.
	 */
	interface Collection extends IteratorAggregate {
		/**
		 * Ensures that this collection contains the given element (optional operation).
		 *
		 * @throws BadMethodCallException if the `add` operation is not supported
		 * @throws InvalidArgumentException if some property of the element prevented it from being added to this
		 *         collection (such as type).
		 *
		 * @param mixed $e the element to add
		 * @return boolean true if this collection changed as a result of this call, false otherwise
		 */
		public function add($e);

		/**
		 * Ensures that this collection contains all elements present in the given collection (optional operation).
		 *
		 * @throws BadMethodCallException if the `addAll` operation is not supported
		 * @throws InvalidArgumentException if some property of the element prevented it from being added to this
		 *         collection (such as type).
		 *
		 * @param Collection $c the collection containing elements to add
		 * @return boolean true if this collection changed as a result of this call, false otherwise
		 */
		public function addAll(Collection $c);

		/**
		 * Removes all elements from this collection (optional operation). This collection will be empty following this
		 * call.
		 *
		 * @throws BadMethodCallException if the `clear` operation is not supported
		 */
		public function clear();

		/**
		 * Returns true if this collection contains the given element.
		 *
		 * @param  mixed $e the element to test for
		 * @return boolean  true if this collection contains the element
		 */
		public function contains($e);

		/**
		 * Returns true if this collection contains all of the elements in the given collection.
		 *
		 * @param  Collection $c the collection containing the elements to test for
		 * @return boolean       true if this collection contains all elements in the given collection
		 */
		public function containsAll(Collection $c);

		/**
		 * Returns true if this collection contains no elements.
		 *
		 * @return boolean true if this collection contains no elements
		 */
		public function isEmpty();

		/**
		 * Returns an iterator over the elements in this collection. The iterator will always return the elements in
		 * the order they were added to the collection, unless otherwise specified by a specific implementation.
		 *
		 * @return Iterator an iterator that can be used to iterator over the elements in this collection
		 */
		public function getIterator();

		/**
		 * Removes a single instance of an object from this collection, if it is present (optional operation).
		 *
		 * @throws BadMethodCallException if the `remove` operation is not supported
		 *
		 * @param  mixed $e the element to remove from this collection, if present
		 * @return boolean  true if this collection changed as a result of this call
		 */
		public function remove($e);

		/**
		 * Removes all of this collection's elements that are also present in the give collection (optional operation).
		 *
		 * @throws BadMethodCallException if the `removeAll` operation is not supported
		 *
		 * @param  Collection $c the collection containing the elements that should be removed from this colleciton
		 * @return boolean       true if this collection changed as a result of this call
		 */
		public function removeAll(Collection $c);

		/**
		 * Removes all elements from this collection that are not also contained in the give collection (optional
		 * operation).
		 *
		 * @throws BadMethodCallException if the `retainAll` operation is not supported
		 *
		 * @param  Collection $c the collection containing all the elements that should be retained in this collection
		 * @return boolean       true if this collection changed as a result of this call
		 */
		public function retainAll(Collection $c);

		/**
		 * Returns the number of elements contained in this collection.
		 *
		 * @return integer the number of elements in this collection
		 */
		public function size();

		/**
		 * Returns an array containing all of the elements in this collection. If the implementation makes an guarantees
		 * as to what order the elements are returned by it's iterator, this method must return the elements in the same
		 * order.
		 *
		 * @return array an array containing all elements in this collection
		 */
		public function toArray();
	}
?>