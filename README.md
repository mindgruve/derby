# derby

Derby is a media manager for images, pdfs, youtube videos and more and was written in PHP 5.4. We have abstracted file objects of various types which can be used for different operations based on the type of media. For example, cropping or resizing images or creating PDFs from word documents.

Local file adapters are able to upload to a remote file adapter and vice versa. Derby's local and remote *file* adapters accept a [gaufrette](https://github.com/KnpLabs/Gaufrette) adapter to manage file system abstraction, however, Derby also includes other adapters which are not related to a file system. Like the "Embed" adapter.

Derby is a current work in progress.

## Install
```php
composer require mindgruve/derby dev-master
```

If you don't know what composer is, [check it out](https://getcomposer.org/).

## Example Usage
### Write data to a new local file

```php
use Derby\Manager;
use Derby\Adapter\LocalFileAdapter;

$mediaManager = new Manager();

// Create local adapter which takes the base path.
// This works with a base path since that's how Gaufrette works.
$localAdapter = new LocalFileAdapter('/tmp/derby/');

// create a local file reference for a file at /tmp/derby/foo/bar.txt
$localMedia = $mediaManager->getMedia('foo/bar.txt', $localAdapter);

// does it exist?
// ==> false (if the file wasn't there yet)
echo $localMedia->exists();

// create the actual file (not just its object)
// and write some data
$localMedia->write('Lorem Ipsum');

// does it exist?
// ==> true
echo $localMedia->exists();
```

Derby's local and remote file adapters extend [AbstractGaufretteAdapter](https://github.com/mindgruve/derby/blob/master/src/Adapter/AbstractGaufretteAdapter.php) which expects a gaufrette adapter. All of the above operations used the gaufrette adapter for their actual file handling.

The following is a better example of Derby's purpose.

### Get media object for a local file that exists
Assume that an actual image exists at /tmp/derby/sample.jpeg

```php
use Derby\Manager;
use Derby\Adapter\LocalFileAdapter;

$mediaManager = new Manager();

// Create local adapter which takes the base path.
// This works with a base path since that's how Gaufrette works.
$localAdapter = new LocalFileAdapter('/tmp/derby/');

// Let's assume there's an image that exists at /tmp/derby/sample.jpeg
$localMedia = $mediaManager->getMedia('sample.jpeg', $localAdapter);

// does it exist?
// ==> true
echo $localMedia->exists();

// What type of local media object is this?
// ==> Derby\Media\Local\Image
echo get_class($localMedia);

```

You can see above that you will get a local file object based on the type of media. In this case, since the file is an image, we get an image object and can do further manipulations on it.

```php
// resize the image and save it to 'key' where key is relative to the base path of the adapter (/tmp/derby/).
$localMedia->resize('key', 100, 100);
```

### Move files between adapters
php```

use Derby\Manager;
use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\File\AmazonS3Adapter;

// create local adapter
$localAdapter = new LocalFileAdapter('/tmp/derby/');

// create a local file reference
$localMedia = $mediaManager->getMedia('new.txt', $localAdapter);

// write data to file
$localMedia->write('Lorem Ipsum');

// create remote s3 adapter
$s3Client = S3Client::factory(array(
  'key' => 'XXXXXXXXXXXXX',
  'secret' => 'XXXXXXXXXXXXX'
));

$remoteAdapter = new AmazonS3Adapter($s3Client, 'bucket-location');

// Upload the local file to the remote adapter
$remoteMedia = $localMedia->upload($remoteAdapter);

// ==> Derby\Media\RemoteFile
echo get_class($remoteMedia);

// and download it
$otherLocal = new LocalFileAdapter('/other/place');

$media = $media->download($localAdapter);
```
