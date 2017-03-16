<?php

namespace Tests\Unit\Utils;

use Ajaaleixo\PhraseApp\Utils\LocaleFileWriter;
use Tests\TestCase;

class LocaleFileWriterTest extends TestCase
{
    public function testParseCompleteLocale()
    {
        $result = LocaleFileWriter::parseLocale('en-US');

        $this->assertEquals('en', $result);
    }

    public function testParseSimpleLocale()
    {
        $result = LocaleFileWriter::parseLocale('en');

        $this->assertEquals('en', $result);
    }

    public function testMakeFileName()
    {
        $result = LocaleFileWriter::makeFileName('validation');

        $this->assertEquals('validation.php', $result);
    }

    public function testMakeFilePath()
    {
        $result = LocaleFileWriter::makeFilePath('en', 'validation');

        $this->assertStringEndsWith('resources/lang/en/validation.php', $result);
    }
}
