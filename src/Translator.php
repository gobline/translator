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
class Translator implements TranslatorInterface
{
    private $translations = [];
    private $files = [];
    private $defaultLanguage;

    /**
     * {@inheritdoc}
     */
    public function setDefaultLanguage($language)
    {
        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        $this->defaultLanguage = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function addTranslationFile($path, $language)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('Translation file "'.$path.'" not found');
        }

        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        $this->files[$language][] = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function addTranslationArray(array $translations, $language)
    {
        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        if (!isset($this->translations[$language])) {
            $this->translations[$language] = [];
        }

        $this->translations[$language] = array_merge(
            $this->translations[$language],
            $translations
        );
    }

    /**
     * {@inheritdoc}
     */
    public function translate($str, $params = null, $language = null)
    {
        if (!$language) {
            if (!$this->defaultLanguage) {
                throw new \RuntimeException('Default language not specified');
            }

            $language = $this->defaultLanguage;
        }

        $this->loadTranslations($language);

        if (isset($this->translations[$language][$str])) {
            $str = $this->translations[$language][$str];
        }

        if ($params) {
            if (is_array($params)) {
                foreach ($params as $k => $param) {
                    $str = str_replace('%'.($k+1), $param, $str);
                }
            } else {
                $str = str_replace('%1', $params, $str);
            }
        }

        return $str;
    }

    /**
     * @param string $language
     *
     * @throws \InvalidArgumentException
     */
    private function loadTranslations($language)
    {
        $language = (string) $language;
        if ($language === '') {
            throw new \InvalidArgumentException('$language cannot be empty');
        }

        if (!isset($this->translations[$language])) {
            $this->translations[$language] = [];
        }

        if (isset($this->files[$language])) {
            foreach ($this->files[$language] as $file) {
                if (is_file($file)) {
                    $this->translations[$language] = array_merge(
                        $this->translations[$language],
                        $this->getTranslationArrayFromFile($file)
                    );
                } elseif (is_dir($file)) {
                    $it = new \RecursiveDirectoryIterator($file, \FilesystemIterator::SKIP_DOTS);
                    $it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::SELF_FIRST);

                    foreach ($it as $file) {
                        if (is_file($file->getRealPath())) {
                            $this->translations[$language] = array_merge(
                                $this->translations[$language],
                                $this->getTranslationArrayFromFile($file->getRealPath()));
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $file
     *
     * @return string[]
     */
    private function getTranslationArrayFromFile($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        switch ($extension) {
            default:
                return [];
            case 'php':
                $loader = new Loader\PhpArrayTranslationsLoader($file);
                break;
        }

        return $loader->getTranslationArray();
    }

    /**
     * {@inheritdoc}
     */
    public function hasTranslations($language)
    {
        if (isset($this->translations[$language])) {
            return true;
        }

        if (isset($this->files[$language])) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslations($language)
    {
        if (!$this->hasTranslations($language)) {
            throw new \RuntimeException('No translations found for language "'.$language.'"');
        }

        $this->loadTranslations($language);

        return $this->translations[$language];
    }

    /**
     * @param string $s
     *
     * @return string
     */
    private function trailingSlashIt($s)
    {
        return strlen($s) <= 0 ? '/' : (substr($s, -1) !== '/' ? $s.'/' : $s);
    }
}