Amon
====

Amon is a package to integrate FuelPHP into Amon Exception and Logging system. 
It is complete transparent and should work in any Fuel install.

Thanks to James Mallison for helping write and test the code.

And thanks to Martin Rusev for developing Amon http://amon.cx/

If you have any comments/queries, either send me a message on github or email me at maca134@googlemail.com

Installation
------------

1. Clone (`git clone git://github.com/maca134/fuelphp-amon`) / [download](https://github.com/maca134/fuelphp-amon/zipball/master)
2. Copy to fuel/packages/
3. If you are using the free version of Amon, that's it!
4. Copy fuel/packages/amon/config/amon.php to fuel/app/config/
5. Add your Amonplus host, port, protocol and application key.
6. Add 'amon' to the 'always_load/packages' array in app/config/config.php

Introduction
------------

Amon will transmit logs and exception to your Amon instance. It is completely transparent, so you don't have to replace any code. 

Basic usage
-----------

Use the FuelPHP log class as you normally would. http://docs.fuelphp.com/classes/log.html

Thanks
------

 - [James Mallison](http://www.j7mbo.co.uk)
 - [Martin Rusev](http://amon.cx/)