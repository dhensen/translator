<?php

namespace DHensen\Translator\Google;

use Buzz\Message\Response;

class GoogleTranslatorUnofficialTest extends \PHPUnit_Framework_TestCase
{

    private $browser;

    /**
     * @var GoogleTranslatorUnofficial
     */
    private $translator;

    public function setUp()
    {
        $this->browser    = $this->getBrowserMock();
        $this->translator = new GoogleTranslatorUnofficial($this->browser);
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
        $response->setContent('[[["What are you doing?","Wat ben jij aan het doen?",,,0]],,"nl"]');

        $this->browser
            ->expects($this->once())
            ->method('get')
            ->with('https://translate.googleapis.com/translate_a/single?client=gtx&sl=nl&tl=en&dt=t&q='.urlencode('Wat ben jij aan het doen?'))
            ->willReturn($response);

        $translation = $this->translator->translate('nl', 'en', 'Wat ben jij aan het doen?');

        $expectedTranslation = 'What are you doing?';

        $this->assertEquals($expectedTranslation, $translation);
    }

    /**
     * @test
     */
    public function it_should_be_future_proof()
    {
        // google keeps putting more comma's to break peoples implementations

        $response = new Response();
        $response->setContent('[[["What are you doing?","Wat ben jij aan het doen?",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,0]],,"nl"]');

        $this->browser
            ->expects($this->once())
            ->method('get')
            ->with('https://translate.googleapis.com/translate_a/single?client=gtx&sl=nl&tl=en&dt=t&q='.urlencode('Wat ben jij aan het doen?'))
            ->willReturn($response);

        $translation = $this->translator->translate('nl', 'en', 'Wat ben jij aan het doen?');

        $expectedTranslation = 'What are you doing?';

        $this->assertEquals($expectedTranslation, $translation);
    }
}

