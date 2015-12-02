<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Translator\Loader;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class PhpArrayTranslationsLoader extends AbstractTranslationsLoader
{
    /**
     * {@inheritdoc}
     */
    public function getTranslationArray()
    {
        return include $this->translationFile;
    }
}
