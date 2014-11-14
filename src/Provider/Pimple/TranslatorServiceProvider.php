<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Translator\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Mendo\Translator\Translator;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class TranslatorServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'translator')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $container[$this->reference.'.sources'] = [];
        $container[$this->reference.'.defaultLanguage'] = null;

        $container[$this->reference] = function ($c) {
            $translator = new Translator();

            foreach ($c[$this->reference.'.sources'] as $language => $sources) {
                foreach ($sources as $source) {
                    if (is_array($source)) {
                        $translator->addTranslationsArray($source, $language);
                    } else {
                        $translator->addTranslationsFile($source, $language);
                    }
                }
            }

            if (!empty($container[$this->reference.'.defaultLanguage'])) {
                $translator->setDefaultLanguage($c[$this->reference.'.defaultLanguage']);
            }

            return $translator;
        };
    }
}
