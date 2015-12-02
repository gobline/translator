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
abstract class AbstractTranslationsLoader implements TranslationsLoaderInterface
{
    protected $translationFile;

    /**
     * @param string $translationFile
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($translationFile)
    {
        if (!is_file($translationFile)) {
            throw new \InvalidArgumentException('Translation file "'.$translationFile.'" not found');
        }

        $this->translationFile = $translationFile;
    }
}
