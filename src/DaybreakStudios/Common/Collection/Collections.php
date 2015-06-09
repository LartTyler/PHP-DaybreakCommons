<?php
	namespace DaybreakStudios\Common\Collection;

	/**
	 * A collection (har har) of useful operations intended for use with the Collections library, such as converting
	 * PHP arrays to maps or lists.
	 */
	class Collections {
		/**
		 * Converts a PHP array into a Map.
		 *
		 * @see SimpleMap
		 *
		 * @param  array  $array the array to convert
		 * @return Map        	 the map built from the PHP array
		 */
		public static function toMap(array $array) {
			$map = new SimpleMap();

			foreach ($array as $k => $v)
				$map->put($k, $v);

			return $map;
		}

		/**
		 * Converts a PHP array into a List.
		 *
		 * @see ArrayList
		 *
		 * @param  array $array   the array to convert
		 * @return CollectionList the list built from the PHP array
		 */
		public static function toList(array $array) {
			$list = new ArrayList();

			foreach ($array as $v)
				$list->add($v);

			return $list;
		}
	}
?>