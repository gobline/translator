<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Translator;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
interface TranslatorInterface
{
    /**
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    public function setDefaultLanguage($language);

    /**
     * @param string $path
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    public function addTranslationFile($path, $language);

    /**
     * @param array  $translations
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    public function addTranslationArray(array $translations, $language);

    /**
     * @param string       $str
     * @param array|string $params
     * @param string       $language
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function translate($str, $params = null, $language = null);

    /**
     * @param string $language
     *
     * @return string[]
     */
    public function getTranslations($language);

    /**
     * @param string $language
     *
     * @return bool
     */
    public function hasTranslations($language);
}
