<?php

namespace DHensen\Translator\Bing;

use Buzz\Browser;
use Buzz\Message\Response;

class BingTranslatorTest extends \PHPUnit_Framework_TestCase
{
    private $browser;

    /**
     * @var BingTranslator
     */
    private $translator;

    public function setUp()
    {
        $this->browser    = $this->getBrowserMock();
        $clientId         = '';
        $clientSecret     = '';
        $accessToken      = 'someRandomAccessToken';
        $this->translator = new BingTranslator($this->browser, $clientId, $clientSecret, $accessToken);
    }

    private function getBrowserMock()
    {
        return $this->getMockBuilder('Buzz\Browser')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     */
    public function it_translates_a_text()
    {
        $response = new Response();
        $response->setContent('<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">dit is een test</string>');

        $this->browser
            ->expects($this->once())
            ->method('get')
            ->with('http://api.microsofttranslator.com/v2/Http.svc/Translate?from=en&to=nl&text=this+is+a+test')
            ->willReturn($response);

        $translation = $this->translator->translate('en', 'nl', 'this is a test');

        $expectedTranslation = 'dit is een test';

        $this->assertEquals($expectedTranslation, $translation);
    }

    /**
     * @todo
     */
    public function it_retrieves_an_access_token()
    {

    }
}
