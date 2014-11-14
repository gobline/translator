<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Translator\Loader;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface TranslationsLoaderInterface
{
    /**
     * @return string[]
     */
    public function getTranslationArray();
}
