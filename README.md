# database-mail-templates

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/dojo-sh/database-mail-templates.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/dojo-sh/database-mail-templates.svg?style=flat-square)](https://packagist.org/packages/dojo-sh/database-mail-templates)

Render laravel mail using a blade template stored in the database

## Install

```bash
composer require dojo-sh/database-mail-templates
```

### Migrate
    php artisan migrate

### Publish config
    php artisan vendor:publish --provider="DojoSh\DatabaseMailTemplates\DatabaseMailTemplatesServiceProvider" --tag=config

### Override default template
    php artisan vendor:publish --provider="DojoSh\DatabaseMailTemplates\DatabaseMailTemplatesServiceProvider" --tag=views    

## Usage

### Create a new mailable
    php artisan make:database-mail-template {name} {--notification}
    
Ex. Mailable Class
           
    namespace App\Mail;
    
    use DojoSh\DatabaseMailTemplates\TemplateMailable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    
    class TestMail extends TemplateMailable
    {
        public $templateVariable;
           
        public function __construct($templateVariable)
        {
            $this->templateVariable = $templateVariable;
        }        
    }
    
All public properties will be available in the template

### Mailable templates admin panel

    http://application.link/database-mail-templates
    
### Preview mail

    class ContractApprovedMail extends TemplateMailable
    {
        public $contract;
    
        public function __construct($contract)
        {
            $this->contract = $contract;
        }
    
        // Override this function and return mockup data to preview the mail
        public static function getPreviewInstance()
        {
            return new self(Contract::first());
        }
    }    


## Testing

Run the tests with:

```bash
vendor/bin/phpunit
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security-related issues, please email s.arida@dojo.sh instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
