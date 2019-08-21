# ImageCrop

Image cropping helper aimed to simplify GD functionality and more!

## Usage

```$xslt
$jpegImagePath = 'image.jpeg';

// create ImageCrop instance and set up it's reader, writer, and other options
$imageCrop = (new ImageCrop())
    ->setReader(JPEGReader::class)
    ->setWriter(JPEGWriter::class);

// load image resource into a reader using filepath
$imageCrop->getReader()->loadFromPath($jpegImagePath);

// perform cropping actions
$imageCrop->cropTop();
$imageCrop->cropBottom();

// skip image that appear to be empty
if (false === $imageCrop->isEmpty()) {
    // save cropped image to the drive
    $imageCrop->getWriter()->write();
    
    // get cropped image path
    $path = $imageCrop->getWriter()->getPath();
    
    // get cropped image contents
    $contents = $imageCrop->getWriter()->getData();
}
```