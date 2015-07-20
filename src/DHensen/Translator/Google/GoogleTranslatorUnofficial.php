<?php

namespace DHensen\Translator\Google;

use Buzz\Browser;
use DHensen\Translator\Translator;

class GoogleTranslatorUnofficial implements Translator
{
    const ENDPOINT_MASK = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=%s&tl=%s&dt=t&q=%s';

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @param string $sourceLanguage
     * @param string $destinationLanguage
     * @param string $text
     * @return string
     */
    public function translate($sourceLanguage, $destinationLanguage, $text)
    {
        $url = sprintf(self::ENDPOINT_MASK, $sourceLanguage, $destinationLanguage, urlencode($text));
        $response = $this->browser->get($url);
        $brokenJson = $response->getContent();

        while (strpos($brokenJson, ',,') !== false) {
            $brokenJson = str_replace(',,', ',', $brokenJson);
        }
        $fixedJson = $brokenJson;

        $data = json_decode($fixedJson);

        return $data[0][0][0];
    }
}
