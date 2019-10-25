Video Downloader
==============================================

[![Join PHP Chat][ico-phpchat]][link-phpchat]
[![Chat on Telegram][ico-telegram]][link-telegram]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
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

### getVideoInfo Method:

Get Video Info By **Video ID**:
``` php
$downloader = new Irazasyed\VideoDownloader\Factory('facebook');
$videoInfo = $downloader->getVideoInfo('10154015752566729');
```

Get Video Info By **URL**:
``` php
$videoUrl = 'https://www.facebook.com/facebook/videos/vl.515712155263726/10154015752566729/?type=1&theater';

$downloader->getVideoInfo($videoUrl);
```

Example Response:
```php
$response = [
  "title" => "Facebook" // Video Title if exists, Page Title otherwise.
  "description" => "Is seeing the world on your mind?" // Video Caption
  "owner" => "Facebook" // Uploader Name
  "created_time" => "1441004460" // Unix Time
  "hd_link" => "<HD MP4 LINK>"
  "sd_link" => "<SD MP4 LINK>"
];
```

#### Supported URL Types (HTTP/HTTPS):
- http://www.facebook.com/video.php?v=VIDEO_ID
- http://www.facebook.com/photo.php?v=VIDEO_ID
- http://www.facebook.com/video/video.php?v=VIDEO_ID
- https://www.facebook.com/USER_NAME/videos/USER_ALBUM/VIDEO_ID/?type=2&theater 
- https://www.facebook.com/USER_NAME/videos/VIDEO_ID/?pnref=story

### Download Method:

```php
$isAsyncRequest = true;
$downloader->download('Remote_File_URL', '/path/to/destination/filename.mp4', $isAsyncRequest);
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

## Disclaimer

This project and its author is neither associated, nor affiliated with Facebook in anyway. Use of this project is at your own risk and subject to the license of this project. This is simply an experimental project. It is highly recommended to go through the [Automated Data Collection Terms](https://www.facebook.com/apps/site_scraping_tos_terms.php) of Facebook & the License section of this project for more information.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-phpchat]: https://img.shields.io/badge/Slack-PHP%20Chat-5c6aaa.svg?style=flat-square&logo=slack&labelColor=4A154B
[ico-telegram]: https://img.shields.io/badge/@PHPChatCo-2CA5E0.svg?style=flat-square&logo=telegram&label=Telegram
[ico-version]: https://img.shields.io/packagist/v/irazasyed/video-downloader.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/irazasyed/video-downloader/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/irazasyed/video-downloader.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/irazasyed/video-downloader.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/irazasyed/video-downloader.svg?style=flat-square

[link-phpchat]: https://phpchat.co/?ref=video-downloader
[link-telegram]: https://t.me/PHPChatCo
[link-packagist]: https://packagist.org/packages/irazasyed/video-downloader
[link-travis]: https://travis-ci.org/irazasyed/video-downloader
[link-scrutinizer]: https://scrutinizer-ci.com/g/irazasyed/video-downloader/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/irazasyed/video-downloader
[link-downloads]: https://packagist.org/packages/irazasyed/video-downloader
[link-author]: https://github.com/irazasyed
[link-contributors]: ../../contributors
