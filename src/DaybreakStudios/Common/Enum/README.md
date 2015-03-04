## Introduction to `DaybreakStudios\Common\Enum`

I've seen the question "how can I do Java-esque enums in PHP?" so many times it's starting to make my head hurt. The
popular response is "You can't, use constants."

While class constants make sense for some cases, they also have a huge limitation. Consider the following:

```
class Planets {
	MERCURY = 4880.0;
	VENUS = 12103.6;
	EARTH = 12756.3;
	MARS = 6794.0;
	JUPITER = 142984.0;
	SATURN = 120536.0;
	URANUS = 51118.0;
	NEPTUNE = 49532.0;
	PLUTO = 2274.0;
}
```

Using the class constants method, I could create a class that contains information about all the planets in our solar
system. Notice the problem there though? How does a casual observer know what that information is? Well, you may say,
document the class! Or better yet, rename it to `PlanetDiameters`, or something similar!

That's all fine and dandy, but what happens when I need more information than just their diameter? What if I need a way
to store their diameter and their distance from our sun? And Great Codemonkey forbid I want a way to keep track of all
their moons too!

Queue "blah blah databases blah blah extendability." There are some things that are too simple to store in a
database, but too complicated to store in simple class constants. Thus, my implementation of enums in PHP was born.

To oversimplify things, Java enums are nothing more than a class that has a private constructor, and has a built-in way
to access a finite list of instances of itself that is defined at compile time. Each instance, of course, is an object,
and can have all the various perks associated with an object in an object oriented language.

## Usage

Working with enums is simple. All you need is a class that extends from `DaybreakStudios\Common\Enum\Enum`:

```
use DaybreakStudios\Common\Enum\Enum;

class Planets extends Enum {

}
```

And we're off to a good start. That, literally, is all you need to have an enum. Of course, it has no values, but the
example class above is a perfectly valid enum.

To begin adding values, you need to implement the `init` method, which is a static method with a scope of `protected` or
`public`, and will contain a few lines of code to tell our enum what values it holds:

```
use DaybreakStudios\Common\Enum\Enum;

class Planets extends Enum {
	protected static function init() {
		parent::register('MERCURY');
		parent::register('VENUS');
		parent::register('EARTH');
		parent::register('MARS');
		parent::register('JUPITER');
		parent::register('SATURN');
		parent::register('URANUS');
		parent::register('NEPTUNE');
		parent::register('PLUTO');

		parent::stopRegistration();
	}
}
```

That's it! We now have a basic implementation of our original `Planets` class as an enum. The method call `parent::register`
takes a variable number of arguments, but requires a minimum of one argument. The first argument is always the enums name,
and should be formatted the same was as a PHP function:

**Taken from [PHP.net](http://php.net/manual/en/functions.user-defined.php):**
> Function names follow the same rules as other labels in PHP. A valid function name starts with a letter or
> underscore, followed by any number of letters, numbers, or underscores. As a regular expression, it would be
> expressed thus: `[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*`.

All subsequent arguments will be passed, in order, to the enum's constructor, as demonstrated below.

```
use DaybreakStudios\Common\Enum\Enum;

class Planets extends Enum {
	private $diameter;

	protected function __construct($diameter) {
		$this->diameter = $diameter;
	}

	public function getDiameter() {
		return $this->diameter;
	}

	protected static function init() {
		parent::register('MERCURY', 4880.0);
		parent::register('VENUS', 12103.6);
		parent::register('EARTH', 12756.3);
		parent::register('MARS', 6794.0);
		parent::register('JUPITER', 142984.0);
		parent::register('SATURN', 120536.0);
		parent::register('URANUS', 51118.0);
		parent::register('NEPTUNE', 49532.0);
		parent::register('PLUTO', 2274.0);

		parent::stopRegistration();
	}
}
```

Phew! Lots of changes, but all pretty basic PHP. We added a constructor that will receive all arguments after the initial
name. In this case, that's just the planet's diameter.

Next, we save it to the private variable `$diameter` and add a getter for it. We could later access it elsewhere in the code
by including the enum file and calling it like so:

```
// include our "Planets" class however you want (namespace, include, etc.)

$planet = Planets::EARTH();

printf("Diameter of %s: %.1f", ucwords(strtolower($planet->name())), $planet->getDiameter());

// Output:
// Diameter of Earth: 12756.0
```

Pretty simple, right? Let's break it down.

You can access a value of an enum by using the scope resolution operator (the double colon) on the class name, followed
by the case-sensitive name of the value to get.

We also use the `name` method in the example above. This is a built in method that all enums have that simply returns the
name we defined the enum value with. In this case, calling `name` on our enum would return the string "EARTH". In addition
to `name`, we also have `ordinal` (`Planet::EARTH()->ordinal()`), which returns the index of the enum value, which would
be `2` in our example above, since EARTH is the third enum defined.

You can refer to the documentation in `Enum.php` for more information on how the Enum suite works.

## Advanced Usage

Let's say you have a form on your site somewhere, and you want it to contain a list of all planets in our solar system.
You can get a list of all values in an enum using the built-in `values` static method:

```
<select name="planets">
	<?php
		foreach (Planets::values() as $planet)
			printf('<option name="%s">%s</option>', $planet->name(), ucwords(strtolower($planet->name())));
	?>
</select>
```

Now we run into the problem of handling that value when the form is submitted. When the form data hits whatever handler
script we have set up, all we'll have is a string! You can then use the built-in `valueOf` static method call to convert
the string name of the enum back into it's corresponding instance!

```
// $_POST['planet'] = 'EARTH';

$chosenPlanet = Planets::valueOf($_POST['planet']);

printf('You selected %s as your favorite planet!', ucwords(strtolower($planet->name())));

// Output:
// You selected Earth as your favorite planet!
```

**There is one important caveat.** The built-in `valueOf` method assumes that the string passed over is already cased
correctly. That is to say, no transformations will be done, except to remove spaces, dashes, and any other invalid
characters. This means that you would either need to use `strtoupper` on all strings you plan on passing to `valueOf`,
OR you may simply override the `valueOf` method in your enum class, as so:

```
use DaybreakStudios\Common\Enum\Enum;

class Planets extends Enum {
	// *snip* init(), __construct(...), and getDiameter()

	public static function valueOf($str) {
		return parent::valueOf(strtoupper($str));
	}
}
```

The example above would allow for a case-insensitve `valueOf` implementation.