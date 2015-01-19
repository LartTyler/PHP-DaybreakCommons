<?php
	namespace DaybreakStudios\Common\Collection;

	class Collections {
		public static function toMap(array $array) {
			$map = new SimpleMap();

			foreach ($array as $k => $v)
				$map->put($k, $v);

			return $map;
		}

		public static function toList(array $array) {
			$list = new ArrayList();

			foreach ($array as $v)
				$list->add($v);

			return $list;
		}
	}
?>