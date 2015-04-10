Defuse Security String Generator
================================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Spomky-Labs/defuse-generator/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Spomky-Labs/defuse-generator/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/Spomky-Labs/defuse-generator/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Spomky-Labs/defuse-generator/?branch=develop)

[![Build Status](https://travis-ci.org/Spomky-Labs/defuse-generator.svg?branch=develop)](https://travis-ci.org/Spomky-Labs/defuse-generator)
[![HHVM Status](http://hhvm.h4cc.de/badge/spomky-labs/defuse-generator.png)](http://hhvm.h4cc.de/package/spomky-labs/defuse-generator)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2debcff1-b085-4c05-992a-0b0a639d2527/big.png)](https://insight.sensiolabs.com/projects/2debcff1-b085-4c05-992a-0b0a639d2527)

[![Latest Stable Version](https://poser.pugx.org/spomky-labs/defuse-generator/v/stable.png)](https://packagist.org/packages/spomky-labs/defuse-generator)
[![Latest Unstable Version](https://poser.pugx.org/spomky-labs/defuse-generator/v/unstable.png)](https://packagist.org/packages/spomky-labs/defuse-generator)
[![Total Downloads](https://poser.pugx.org/spomky-labs/defuse-generator/downloads.png)](https://packagist.org/packages/spomky-labs/defuse-generator)
[![License](https://poser.pugx.org/spomky-labs/defuse-generator/license.png)](https://packagist.org/packages/spomky-labs/defuse-generator)


This library provides a random string generator based on [source code of Defuse Security](https://defuse.ca/generating-random-passwords.htm).

This generator uses PHP Mcrypt extension to generate random strings.

## The Release Process ##

The release process [is described here](doc/Release.md).

## Prerequisites ##

This library needs at least `PHP 5.3`.
It has been successfully tested using `PHP 5.3` to `PHP 5.6` and `HHVM`

## Installation ##

The preferred way to install this library is to rely on Composer:

```sh
    composer require "spomky-labs/defuse-generator" "~1.0@dev"
```

## How to use ##

Your classes are ready to use? Have a look at [How to use](doc/Use.md) to use your exception manager with an OAuth2 server.

## Contributing

Requests for new features, bug fixed and all other ideas to make this library useful are welcome. [Please follow these best practices](doc/Contributing.md).

## Licence

This library is release under [MIT licence](LICENSE).
