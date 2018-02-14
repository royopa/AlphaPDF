AlphaPDF
========

[![Latest Stable Version](https://poser.pugx.org/royopa/alphapdf/v/stable)](https://packagist.org/packages/royopa/alphapdf)
[![Total Downloads](https://poser.pugx.org/royopa/alphapdf/downloads)](https://packagist.org/packages/royopa/alphapdf)
[![License](https://poser.pugx.org/royopa/alphapdf/license)](https://packagist.org/packages/royopa/alphapdf)
[![Build Status](https://travis-ci.org/royopa/alphapdf.svg?branch=master)](https://travis-ci.org/royopa/alphapdf)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/royopa/alphapdf/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/royopa/alphapdf/?branch=master)

AlphaPDF is a PHP class which allows to generate watermarks on PDF files. This class uses the library [FPDI](https://packagist.org/packages/setasign/fpdi)


Install
-------

To install with composer:

```sh
composer require royopa/alphapdf
```

Example
-------

```php
use Royopa\AlphaPDF\AlphaPDF;
use Royopa\AlphaPDF\WaterMark;
use Royopa\AlphaPDF\Fpdi;

```

Tests
-----

From the project directory, tests can be ran using:

```sh    
./vendor/bin/phpunit
```
