# Laravel SQL Log

[![Build Status](https://travis-ci.org/FattyRabbit/SqlLog.svg?branch=master)](https://travis-ci.org/FattyRabbit/SqlLog)
[![Latest Stable Version](https://poser.pugx.org/fatty-rabbit/sql-log/v/stable)](https://packagist.org/packages/fatty-rabbit/sql-log)
[![Total Downloads](https://poser.pugx.org/fatty-rabbit/sql-log/downloads)](https://packagist.org/packages/fatty-rabbit/sql-log)
[![License](https://poser.pugx.org/fatty-rabbit/sql-log/license)](https://packagist.org/packages/fatty-rabbit/sql-log)

## Laravel 5.3

For Laravel versions 5.3+, please continue below.

Install Sql Log:

```bash
composer require fatty-rabbit/sql-log
```

Add the Service Provider:

```php
'providers' => array(
    # other providers omitted
    'FattyRabbit\SqlLog\SqlLogSearviceProvider',
);
```

Publish the package config file to `config/trustedproxy.php`:

```bash
$ php artisan vendor:publish --provider="FattyRabbit\SqlLog\SqlLogSearviceProvider"
```

Then edit the published configuration file `config/sqllog.php` as needed.

```php
<?php

return [
    'base_level' => 'debug',
    'ignore' => [
        'ip' => [
            '127.0.0.1',
        ],
        'uri' => [],
    ],
];
```
