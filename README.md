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
### Create and write a local file

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
// ==> false
echo $localMedia->exists();

// create the actual file and write some data
$localMedia->write('Lorem Ipsum');

// does it exist?
// ==> true
echo $localMedia->exists();
```

The above example does this:
* Create a media manager.
* Create a local file adapter with a base path of /tmp/derby/.
* Create a local media object for a "key". In the case of local files, the key is a filepath relative to the base path of the adapter (e.g., ```/tmp/derby/foo/bar.txt```.
* Writes data to the file.

While this does showcase some features of Derby, most of the file system handling responsibility was actually deferred to [Gaufrette](https://github.com/KnpLabs/Gaufrette).
  
The following examples give a better idea of Derby's purpose.

### Get a media object for a local file
Let's assume that we have an actual local image at ```/tmp/derby/foo.jpeg```.

```php
use Derby\Manager;
use Derby\Adapter\LocalFileAdapter;

$mediaManager = new Manager();

// Create local adapter for base path of /tmp/derby/
$localAdapter = new LocalFileAdapter('/tmp/derby/');

// create a local file reference for a file at /tmp/derby/foo.jpeg
$localMedia = $mediaManager->getMedia('foo.jpeg', $localAdapter);

// does it exist?
// ==> true (assuming you have an image there)
echo $localMedia->exists();

// ==> Derby\Media\Local\Image
echo get_class($localMedia);
```

Derby will give you a local media object based on the media type of the local file (see [LocalFileInterface](https://github.com/mindgruve/derby/blob/master/src/Media/LocalFileInterface.php)). In the above case, since the file is an image, we received an object for handling images called ```Derby\Media\Local\Image```. The main purpose for Derby is to abstract media objects based on their types and provide functionality for the most important of these types (in our case, images).

Continuing the above example...

```php

  ...
  
// Create a new 100x100 file from the original. 
$newLocalMedia = $localMedia->resize('new-foo.jpeg', 100, 100);
```

Since the original file was an image, we are able to do image specific handling on the file.

### Moving files between adapters
Another useful feature of Derby is the ability to move media between adapters. In this example, we'll assume we use S3 to store static files.

```php

use Derby\Manager;
use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\File\AmazonS3Adapter;
use Aws\S3\S3Client;

// create local adapter
$localAdapter = new LocalFileAdapter('/tmp/derby/');

// get our media object
$localMedia = $mediaManager->getMedia('my-subdir/foo.txt', $localAdapter);

// write some data to the local file
$localMedia->write('Lorem Ipsum');

// s3 client for remote s3 adapter
$s3Client = S3Client::factory(array(
    'key' => 'xxx',
    'secret' => 'xxx'
));

// remote s3 adapter
$remoteAdapter = new AmazonS3Adapter($s3Client, 'your-s3-bucket');

// upload local file to remote adapter
$remoteMedia = $localMedia->upload($remoteAdapter);

// ==> Derby\Media\RemoteFile
echo get_class($remoteMedia);
```

In the above example, we
* Create a local file and write data to it.
* Create a remote adapter.
* Upload the local file to the remote adapter.

When you upload a local file to a remote adapter, it will upload the 'key' (getMedia()'s first argument) relative to the base path of the remote adapter. So in the above case, it would go to ```your-s3-bucket/my-subdir/foo.txt```.

Note that when you upload a local file, it will return a ```Derby\Media\RemoteFile``` object (see [RemoteFIleInterface](https://github.com/mindgruve/derby/blob/master/src/Media/RemoteFileInterface.php)). You are now able to work with either the local or remote file objects separately since they are 2 separate files.

Continuing on the example...

```php

  ... 
  
$newLocalMedia = $remoteMedia->download();

// ==> /<tmp_path>/my-subdir/foo.txt
echo $newLocalMedia->getPath();
```

When downloading remote media without passing params to download(), the file will be put into the tmp_path value which was defined in the config (see the Configuration section).

You can also specify the key and the local file adapter when downloading if you want to specify where the file goes.

```php

  ...
  
// use the local adapter we defined above
$otherNewLocalMedia = $remoteMedia->download('my-subdir/otherdir/bar.txt', $localAdapter);

// ==> /tmp/derby/my-subdir/otherdir/bar.txt
echo $otherNewLocalMedia->getPath();
```

In the above example we used the local file adapter we already had defined. However, we specified a new key for where the file should go. We could have also specified a completely different local adapter.

## Configuration
Derby includes a [default yaml config](https://github.com/mindgruve/derby/blob/master/config/media_config.yml) which gets loaded if you don't specify your own. The media section is the most important as it specifies media types and extensions for local files and the respective classes that represent them.

When an adapter is created, it loads the default config (using [Config](https://github.com/mindgruve/derby/blob/master/src/Config.php)) but you can change this by passing your own.

```php
use Derby\Adapter\LocalFileAdapter;
use Derby\Config;

$adapter = new LocalFileAdapter();
$adapter->setConfig(new Config('/path/to/your/config.yaml'));
```

Most importantly, this allows you to create your own classes for local media files (among other things). Local files must implement [LocalFileInterface](https://github.com/mindgruve/derby/blob/master/src/Media/LocalFileInterface.php). 
