# Command parsing library for WildPHP
----------
[![Build Status](https://scrutinizer-ci.com/g/WildPHP/queue/badges/build.png)](https://scrutinizer-ci.com/g/WildPHP/queue/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WildPHP/queue/badges/quality-score.png)](https://scrutinizer-ci.com/g/WildPHP/queue/?branch=master)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/WildPHP/queue/badges/coverage.png)](https://scrutinizer-ci.com/g/WildPHP/queue/code-structure/master/code-coverage)
[![Latest Stable Version](https://poser.pugx.org/wildphp/queue/v/stable)](https://packagist.org/packages/wildphp/queue)
[![Latest Unstable Version](https://poser.pugx.org/wildphp/queue/v/unstable)](https://packagist.org/packages/wildphp/queue)
[![Total Downloads](https://poser.pugx.org/wildphp/queue/downloads)](https://packagist.org/packages/wildphp/queue)


This library aims at making command parsing easy. Not only does it parse strings into commands and parameters, it allows
you to define restrictions to parameters (so-called strategies) and do automatic type/content validation.

## Installation
To install this library, you will need [Composer](https://getcomposer.org/).

    $ composer require wildphp/queue ^0.1
    
## Getting started
This library comes with a set of ready-to-use QueueItems, but you might want to develop your own. More on that later.

The most important classes in the library are the `QueueProcessor` and `BaseQueue`.

More documentation is TBD.

## Contributors

You can see the full list of contributors [in the GitHub repository](https://github.com/WildPHP/queue/graphs/contributors).