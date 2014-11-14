<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Translator\Provider\Pimple\TranslatorServiceProvider;
use Pimple\Container;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class ServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function testServiceProvider()
    {
        $container = new Container();
        $container->register(new TranslatorServiceProvider());
        $this->assertInstanceOf('Mendo\Translator\Translator', $container['translator']);
    }
}
