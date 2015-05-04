[![Build Status](https://travis-ci.org/mindgruve/derby.svg?branch=master)](https://travis-ci.org/mindgruve/derby)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mindgruve/derby/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mindgruve/derby/?branch=master)

# derby

Derby is a media manager for images, pdfs, youtube videos and more and was written in PHP 5.4. We have abstracted file objects of various types which can be used for different operations based on the type of media. For example, cropping or resizing images or creating PDFs from word documents.

Local file adapters are able to upload to a remote file adapter and vice versa. Derby's local and remote *file* adapters accept a [gaufrette](https://github.com/KnpLabs/Gaufrette) adapter to manage file system abstraction, however, Derby also includes other adapters which are not related to a file system. Like the "Embed" adapter.

**Derby is a current work in progress.**

## Install
```php
composer require mindgruve/derby dev-master
```

If you don't know what composer is, [check it out](https://getcomposer.org/).

## Example Usage

*Derby's API is changing a lot. Section to come as we solidify more.*
