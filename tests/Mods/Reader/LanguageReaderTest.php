<?php

/**
 * Copyright (C) 2024 Saxon State and University Library Dresden
 *
 * This file is part of the php-mods-reader.
 *
 * @license GNU General Public License version 3 or later.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Slub\Mods\Reader;

use PHPUnit\Framework\Attributes\Test;
use Slub\Mods\Element\Language;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading Language element
 */
class LanguageReaderTest extends ModsReaderTest
{

    #[Test]
    public function getLanguagesForBookDocument()
    {
        $languages = $this->bookReader->getLanguages();
        self::assertNotEmpty($languages);
        self::assertCount(2, $languages);
        self::assertFirstLanguageForBookDocument($languages[0]);
    }

    #[Test]
    public function getLanguageForBookDocument()
    {
        $language = $this->bookReader->getLanguage(0);
        self::assertFirstLanguageForBookDocument($language);
    }

    #[Test]
    public function getFirstLanguageForBookDocument()
    {
        $language = $this->bookReader->getFirstLanguage();
        self::assertFirstLanguageForBookDocument($language);
    }

    #[Test]
    public function getLastLanguageForBookDocument()
    {
        $language = $this->bookReader->getLastLanguage();
        self::assertSecondLanguageForBookDocument($language);
    }

    #[Test]
    public function getLanguagesByQueryForBookDocument()
    {
        $languages = $this->bookReader->getLanguages('[@objectPart="summary"]');
        self::assertNotEmpty($languages);
        self::assertCount(1, $languages);
        self::assertSecondLanguageForBookDocument($languages[0]);
    }

    #[Test]
    public function getLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getLanguage(0, '[@objectPart="summary"]');
        self::assertSecondLanguageForBookDocument($language);
    }

    #[Test]
    public function getFirstLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getFirstLanguage('[@objectPart="summary"]');
        self::assertSecondLanguageForBookDocument($language);
    }

    #[Test]
    public function getLastLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getLastLanguage('[@objectPart="summary"]');
        self::assertSecondLanguageForBookDocument($language);
    }

    #[Test]
    public function getNoLanguagesByQueryForBookDocument()
    {
        $languages = $this->bookReader->getLanguages('[@objectPart="abstract"]');
        self::assertEmpty($languages);
    }

    #[Test]
    public function getNoLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getLanguage(0, '[@objectPart="abstract"]');
        self::assertNull($language);
    }

    #[Test]
    public function getNoFirstLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getFirstLanguage('[@objectPart="abstract"]');
        self::assertNull($language);
    }

    #[Test]
    public function getNoLastLanguageByQueryForBookDocument()
    {
        $language = $this->bookReader->getLastLanguage('[@objectPart="abstract"]');
        self::assertNull($language);
    }

    #[Test]
    public function getLanguagesForSerialDocument()
    {
        $languages = $this->serialReader->getLanguages();
        self::assertNotEmpty($languages);
        self::assertCount(1, $languages);
        self::assertLanguageForSerialDocument($languages[0]);
    }

    #[Test]
    public function getLanguagesByQueryForSerialDocument()
    {
        $languages = $this->serialReader->getLanguages('[./mods:languageTerm[@type="code"]]');
        self::assertNotEmpty($languages);
        self::assertCount(1, $languages);
        self::assertLanguageForSerialDocument($languages[0]);
    }

    #[Test]
    public function getNoLanguagesByQueryForSerialDocument()
    {
        $languages = $this->serialReader->getLanguages('[@objectPart="summary"]');
        self::assertEmpty($languages);
    }

    private static function assertFirstLanguageForBookDocument(Language $language): void
    {
        self::assertEmpty($language->getObjectPart());
        self::assertNotEmpty($language->getValue());

        $languageTerms = $language->getLanguageTerms();
        self::assertNotEmpty($languageTerms);
        self::assertNotEmpty($languageTerms[0]->getValue());
        self::assertEquals('code', $languageTerms[0]->getType());
        self::assertEquals('iso639-2b', $languageTerms[0]->getAuthority());
        self::assertEquals('eng', $languageTerms[0]->getValue());

        $scriptTerms = $language->getScriptTerms();
        self::assertNotEmpty($scriptTerms);
        self::assertEquals('code', $scriptTerms[0]->getType());
        self::assertEquals('iso15924', $scriptTerms[0]->getAuthority());
        self::assertEquals('Latn', $scriptTerms[0]->getValue());
    }

    private static function assertSecondLanguageForBookDocument(Language $language): void
    {
        self::assertNotEmpty($language->getObjectPart());
        self::assertEquals('summary', $language->getObjectPart());
        self::assertNotEmpty($language->getValue());

        $languageTerms = $language->getLanguageTerms();
        self::assertNotEmpty($languageTerms);
        self::assertNotEmpty($languageTerms[0]->getValue());
        self::assertEquals('code', $languageTerms[0]->getType());
        self::assertEquals('iso639-2b', $languageTerms[0]->getAuthority());
        self::assertEquals('spa', $languageTerms[0]->getValue());

        $scriptTerms = $language->getScriptTerms();
        self::assertNotEmpty($scriptTerms);
        self::assertEquals('code', $scriptTerms[0]->getType());
        self::assertEquals('iso15924', $scriptTerms[0]->getAuthority());
        self::assertEquals('Latn', $scriptTerms[0]->getValue());
    }

    private static function assertLanguageForSerialDocument(Language $language): void
    {
        self::assertEmpty($language->getObjectPart());
        self::assertNotEmpty($language->getValue());

        $languageTerms = $language->getLanguageTerms();
        self::assertNotEmpty($languageTerms);
        self::assertNotEmpty($languageTerms[0]->getValue());
        self::assertEquals('code', $languageTerms[0]->getType());
        self::assertEquals('iso639-2b', $languageTerms[0]->getAuthority());
        self::assertEquals('eng', $languageTerms[0]->getValue());

        self::assertEmpty($language->getScriptTerms());
    }
}
