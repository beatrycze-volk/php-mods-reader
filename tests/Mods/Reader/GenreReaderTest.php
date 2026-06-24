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
use Slub\Mods\Element\Genre;
use Slub\Mods\ModsReaderTest;

/**
 * Tests for reading Genre element
 */
class GenreReaderTest extends ModsReaderTest
{

    #[Test]
    public function getGenresForBookDocument()
    {
        $genres = $this->bookReader->getGenres();
        self::assertNotEmpty($genres);
        self::assertCount(1, $genres);
        self::assertGenreForBookDocument($genres[0]);
    }

    #[Test]
    public function getGenreForBookDocument()
    {
        $genre = $this->bookReader->getGenre(0);
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getFirstGenreForBookDocument()
    {
        $genre = $this->bookReader->getFirstGenre();
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getLastGenreForBookDocument()
    {
        $genre = $this->bookReader->getLastGenre();
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getGenresByQueryForBookDocument()
    {
        $genres = $this->bookReader->getGenres('[@authority="marcgt"]');
        self::assertNotEmpty($genres);
        self::assertCount(1, $genres);
        self::assertGenreForBookDocument($genres[0]);
    }

    #[Test]
    public function getGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getGenre(0, '[@authority="marcgt"]');
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getFirstGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getFirstGenre('[@authority="marcgt"]');
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getLastGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getLastGenre('[@authority="marcgt"]');
        self::assertGenreForBookDocument($genre);
    }

    #[Test]
    public function getNoGenresByQueryForBookDocument()
    {
        $genres = $this->bookReader->getGenres('[@authority="merc"]');
        self::assertEmpty($genres);
    }

    #[Test]
    public function getNoGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getGenre(0, '[@authority="merc"]');
        self::assertNull($genre);
    }

    #[Test]
    public function getNoFirstGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getFirstGenre('[@authority="merc"]');
        self::assertNull($genre);
    }

    #[Test]
    public function getNoLastGenreByQueryForBookDocument()
    {
        $genre = $this->bookReader->getLastGenre('[@authority="merc"]');
        self::assertNull($genre);
    }

    #[Test]
    public function getGenresForSerialDocument()
    {
        $genres = $this->serialReader->getGenres();
        self::assertNotEmpty($genres);
        self::assertCount(2, $genres);
        self::assertFirstGenreForSerialDocument($genres[0]);
    }

    #[Test]
    public function getGenreForSerialDocument()
    {
        $genre = $this->serialReader->getGenre(0);
        self::assertFirstGenreForSerialDocument($genre);
    }

    #[Test]
    public function getFirstGenreForSerialDocument()
    {
        $genre = $this->serialReader->getFirstGenre();
        self::assertFirstGenreForSerialDocument($genre);
    }

    #[Test]
    public function getLastGenreForSerialDocument()
    {
        $genre = $this->serialReader->getLastGenre();
        self::assertSecondGenreForSerialDocument($genre);
    }

    #[Test]
    public function getGenresByQueryForSerialDocument()
    {
        $genres = $this->serialReader->getGenres('[@usage="primary"]');
        self::assertNotEmpty($genres);
        self::assertCount(1, $genres);
        self::assertFirstGenreForSerialDocument($genres[0]);
    }

    #[Test]
    public function getNoGenresByQueryForSerialDocument()
    {
        $genres = $this->serialReader->getGenres('[@type="xyz"]');
        self::assertEmpty($genres);
    }

    private static function assertGenreForBookDocument(Genre $genre)
    {
        self::assertNotEmpty($genre->getValue());
        self::assertEquals('bibliography', $genre->getValue());
        self::assertNotEmpty($genre->getAuthority());
        self::assertEquals('marcgt', $genre->getAuthority());
        self::assertEmpty($genre->getLang());
        self::assertEmpty($genre->getScript());
    }

    private static function assertFirstGenreForSerialDocument(Genre $genre)
    {
        self::assertNotEmpty($genre->getValue());
        self::assertEquals('periodical', $genre->getValue());
        self::assertNotEmpty($genre->getUsage());
        self::assertEquals('primary', $genre->getUsage());
        self::assertEmpty($genre->getDisplayLabel());
        self::assertEmpty($genre->getTransliteration());
    }

    private static function assertSecondGenreForSerialDocument(Genre $genre)
    {
        self::assertNotEmpty($genre->getValue());
        self::assertEquals('series', $genre->getValue());
        self::assertEmpty($genre->getUsage());
        self::assertEmpty($genre->getDisplayLabel());
        self::assertEmpty($genre->getTransliteration());
    }
}
