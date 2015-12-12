Video Downloader - [WIP] Experimental Project.
==============================================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

> Video Downloader Package for Facebook. Automatically generates download links for HD and SD quality & lets you download them.
> Comes with Laravel Support out of the Box!

## Install

Via Composer

``` bash
$ composer require irazasyed/video-downloader
```

## Usage

``` php
$downloader = new Irazasyed\VideoDownloader\Factory('facebook');
$videoInfo = $downloader->getVideoInfo('<FB Video ID>');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email syed+gh@lukonet.com instead of using the issue tracker.

## Credits

- [Syed Irfaq R.][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/irazasyed/video-downloader.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/irazasyed/video-downloader/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/irazasyed/video-downloader.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/irazasyed/video-downloader.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/irazasyed/video-downloader.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/irazasyed/video-downloader
[link-travis]: https://travis-ci.org/irazasyed/video-downloader
[link-scrutinizer]: https://scrutinizer-ci.com/g/irazasyed/video-downloader/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/irazasyed/video-downloader
[link-downloads]: https://packagist.org/packages/irazasyed/video-downloader
[link-author]: https://github.com/irazasyed
[link-contributors]: ../../contributors
