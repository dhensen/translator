<?php

namespace DHensen\Translator;

interface Translator
{
    /**
     * @param string $sourceLanguage
     * @param string $destinationLanguage
     * @param string $text
     * @return string
     */
    public function translate($sourceLanguage, $destinationLanguage, $text);
}
