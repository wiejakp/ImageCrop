# wiejakp/ImageCrop

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]


This project adheres to a [Contributor Code of Conduct][conduct]. By
participating in this project and its community, you are expected to uphold this
code.


## Installation

The preferred method of installation is via [Composer][composer]. Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require wiejakp/image-crop
```


## Basic Usage

```php        
$imagePath = 'image.jpeg';
  
$imageCrop = (new ImageCrop())
   ->setReader(JPEGReader::class)
   ->setWriter(JPEGWriter::class);

// load resource into a reader
$imageCrop->getReader()->loadFromPath($imagePath);

// perform cropping actions
$imageCrop->crop();

// skip images that appear to be empty
if (false === $imageCrop->isEmpty()) {

   // save cropped image to the drive
   $imageCrop->getWriter()->write();

   // do stuff with $imageCrop->getData() or $imageCrop->getDataUri()
   $anchor = \sprintf('<a href="%s">anchor</a>', $imageCrop->getDataUri());
   ...
}
```


## Reader And Writers

You can mix nad match what image resource is being loaded and what image resource is being generated out.

##### BMP Reader And Writer 

```php        
$imageCrop = (new ImageCrop())
   ->setReader(BMPReader::class)
   ->setWriter(BMPWriter::class);
```

##### GIF Reader And Writer 

```php        
$imageCrop = (new ImageCrop())
   ->setReader(GIFReader::class)
   ->setWriter(GIFWriter::class);
```

##### JPEG Reader And Writer 

```php        
$imageCrop = (new ImageCrop())
   ->setReader(JPEGReader::class)
   ->setWriter(JPEGWriter::class);
```

##### PNG Reader And Writer 

```php        
$imageCrop = (new ImageCrop())
   ->setReader(PNGReader::class)
   ->setWriter(PNGWriter::class);
```

## Documentation

Check out the [documentation website][documentation] for detailed information
and code examples.


## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details.


## Copyright and License

The wiejakp/ImageCrop library is copyright © [Przemek Wiejak](https://www.wiejak.app)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for
more information.


[conduct]: https://github.com/wiejakp/ImageCrop/blob/master/.github/CODE_OF_CONDUCT.md
[composer]: https://getcomposer.org/
[documentation]: https://wiejakp.github.io/ImageCrop/
[contributing]: https://github.com/wiejakp/ImageCrop/blob/master/.github/CONTRIBUTING.md

[badge-source]: https://img.shields.io/badge/source-wiejakp%2Fimage--crop-brightgreen
[badge-release]: https://img.shields.io/packagist/v/wiejakp/image-crop.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/wiejakp/image-crop.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/wiejakp/image-crop.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/wiejakp/imagecrop?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/github/wiejakp/ImageCrop
[badge-downloads]: https://img.shields.io/packagist/dt/wiejakp/image-crop.svg?style=flat-square&colorB=mediumvioletred

[source]: https://github.com/wiejakp/ImageCrop
[packagist]: https://packagist.org/packages/wiejakp/ImageCrop
[license]: https://github.com/wiejakp/ImageCrop/blob/master/LICENSE
[php]: https://php.net
[build]: https://travis-ci.org/wiejakp/ImageCrop
[coverage]: https://coveralls.io/github/wiejakp/ImageCrop?branch=master
[downloads]: https://packagist.org/packages/wiejakp/image-crop