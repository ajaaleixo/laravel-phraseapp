<?php

namespace Ajaaleixo\PhraseApp\Utils;

class LocaleFileWriter
{
    public static function write($content, $locale, $file)
    {
        return file_put_contents(self::makeFilePath($locale, $file), $content);
    }

    public static function makeFilePath($locale, $file)
    {
        return resource_path(sprintf('lang/%s/%s', self::parseLocale($locale), self::makeFileName($file)));
    }

    public static function makeFileName($file)
    {
        return sprintf('%s.php', $file);
    }

    public static function parseLocale($locale)
    {
        return explode('-', $locale)[0];
    }
}