# Google reCaptcha v3 for Laravel 5.6+

## Installation

To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "ptuchik/recaptcha-v3": "~1.0"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require ptuchik/recaptcha-v3
    
Publish configuration file to your `config` folder with command:

    php artisan vendor:publish --provider="Ptuchik\Recaptcha\RecaptchaServiceProvider" --tag=config

## Usage

Use as regular validation rule "recaptcha:{ACTION}" like:

```php
    Validator::make($request->all(), [
        'g-recaptcha-response' => 'recaptcha:register'
    ]);
```
