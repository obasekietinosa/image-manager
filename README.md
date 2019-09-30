# image-manager
A simple wrapper class around basic image manipulation functions in PHP

## How to use
To use this library first install it using Composer
 ```
 composer require etin/image-manager
 ```
 
 import it where ever it is required and initialize a new image like so:
 
 ```
 <?php
 
 use Etin\ImageManager\Image;
 
 $image = new Image("https://cdn.pixabay.com/photo/2015/04/23/21/59/tree-736877_960_720.jpg");
 ```
The Image constructor takes any path to an image file. An exception is thrown if the path provided cannot be resolved to an image.

With the image iniialized, we now have access to the image manipulation methods exposed by the library.

## Available methods
### getWidth()
Returns the width of the image in pixels.

### getHeight()
Returns the height of the image in pixels.

### addBorder(int $top, int $left, int $bottom, int $right, string $hexColor)
Adds a border to the image. This method is fluent and returns the **Image** instance.
It accepts the dimensions for the border in pixels and the color in hexadecimal string (example "#000")

### addText(ImageText $text, string $align="center")
Adds a text to the image.The text to be added must be an instance of the **ImageText** class which exposes methods for managing text on an image. The second argument determines the alignment of the text.

### renderJpeg(string $fileName=null, int $quality=null)
Renders the image as a JPEG. To render as a file, that is, with the proper ```X-Content-Type``` header set, pass a filename as the first argument. Otherwise the image is rendered as a stream in most clients.

### renderPng(string $fileName=null, int $quality=null)
Renders the image as a PNG. To render as a file, that is, with the proper ```X-Content-Type``` header set, pass a filename as the first argument. Otherwise the image is rendered as a stream in most clients.

## ImageText
The ImageText class is used to add text to an image via the **Image::addText()** method.

The constructor accepts the following arguments:

- $text - The text to be printed on the image
- $fontPath - The path to the font to use in TTF format
- $hexColor - The color of the text to be printed in hexademical string (e.g "#fd1234")
- $fontSize - The font size to be used. May be overwritten if the ImageText::scale() method is called. Defaults to 20pt.
- $fontScale - The factor by which to scale the text to the image. Defaults to 1. 
- $fontAngle - The angle to rotate the text in degrees. Defaults to 0.

```
<?php

use Etin\ImageManager\Image;
use Etin\ImageManager\ImageText;

$text = new ImageText("This is a MoonCat", "#fff", "path/to/font.ttf", 20, 0.35);

$image = new Image("https://cdn.pixabay.com/photo/2015/04/23/21/59/tree-736877_960_720.jpg");

$image->addText($text)
```
