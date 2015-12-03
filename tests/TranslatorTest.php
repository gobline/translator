<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Gobline\Translator\Translator;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class TranslatorTest extends PHPUnit_Framework_TestCase
{
    private $translator;

    public function setUp()
    {
        $this->translator = new Translator();

        $this->translator->addTranslationFile(__DIR__.'./resources/fr/test-translator-fr.php', 'fr');
        $this->translator->addTranslationFile(__DIR__.'./resources/nl', 'nl');

        $this->translator->addTranslationArray(['First name' => 'Vorname'], 'de');

        $this->translator->setDefaultLanguage('fr');
    }

    public function testTranslator()
    {
        $this->assertSame('Prénom', $this->translator->translate('First name'));
        $this->assertSame('Voornaam', $this->translator->translate('First name', null, 'nl'));
        $this->assertSame('Vorname', $this->translator->translate('First name', null, 'de'));
        $this->assertSame('First name', $this->translator->translate('First name', null, 'it')); // no italian translations provided

        $this->assertSame('Utilisateur John créé', $this->translator->translate('User %1 created', 'John'));
        $this->assertSame('Utilisateur John Smith créé', $this->translator->translate('User %1 %2 created', ['John', 'Smith']));
    }

    public function testTranslatorAddTranslationFileNonExistent()
    {
        $this->setExpectedException('\InvalidArgumentException', 'not found');
        $this->translator->addTranslationFile('', 'fr');
    }

    public function testTranslatorAddTranslationFileEmptyLanguage()
    {
        $this->setExpectedException('\InvalidArgumentException', 'empty');
        $this->translator->addTranslationFile(__DIR__.'./resources/fr/test-translator-fr.php', '');
    }
}
