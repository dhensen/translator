<?php

namespace DHensen\Translator\Bing;

use Buzz\Browser;
use Buzz\Listener\BearerAuthListener;
use DHensen\Translator\Translator;

class BingTranslator implements Translator
{
    /**
     * @var Browser
     */
    private $browser;
    private $clientId;
    private $clientSecret;

    const API_ENDPOINT_MASK = 'http://api.microsofttranslator.com/v2/Http.svc/Translate?from=%s&to=%s&text=%s';

    const ACCESS_TOKEN_API_ENDPOINT = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';

    public function __construct(Browser $browser, $clientId, $clientSecret, $accessToken = null)
    {
        $this->browser      = $browser;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;

        // todo retrieve accessToken from cache
        if ($accessToken === null) {
            $accessToken = $this->getAccessToken();
        }

        $this->browser->addListener(new BearerAuthListener($accessToken));
    }

    /**
     * @param string $sourceLanguage
     * @param string $destinationLanguage
     * @param string $text
     * @return string
     */
    public function translate($sourceLanguage, $destinationLanguage, $text)
    {
        $response = $this->browser->get(sprintf(static::API_ENDPOINT_MASK, $sourceLanguage, $destinationLanguage, urlencode($text)));

        $rawXml = $response->getContent();

        $xml = simplexml_load_string($rawXml);

        return (string) $xml;
    }

    private function getAccessToken()
    {
        $response = $this->browser->submit(
            static::ACCESS_TOKEN_API_ENDPOINT,
            array(
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope'         => 'http://api.microsofttranslator.com',
                'grant_type'    => 'client_credentials')
        );

        $data = json_decode($response->getContent());

        return $data->access_token;
    }
}
