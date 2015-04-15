translator
==========

Provides translation clients for a few known translation services. At this moment supports:
- Bing/Microsoft Azure Translator

## Installation
```
composer require dhensen/translator
```

## Usage

Bing/Azure:
```php
    $browser           = new \Buzz\Browser();
    $azureClientId     = 'your_microsoft_azure_client_id';
    $azureClientSecret = 'your_microsoft_azure_client_secret';
    $translator        = new \DHensen\Translator\Bing\BingTranslator($browser, $azureClientId, $azureClientSecret);
    echo $translator->translate('nl', 'en', 'Ik eet soep'); // prints: I eat soup
```

Google unofficial:
```php
$browser = new \Buzz\Browser();
$translator = new \DHensen\Translator\Google\GoogleTranslatorUnofficial($browser);
echo $translator->translate('nl', 'en', 'Wat ben jij aan het doen?'); // prints: What are you doing?
```
