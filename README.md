# image-manager
A simple wrapper class around basic image manipulation functions in PHP

## How to use
To use this library first install it using Composer
 ```
 composer require etin/image-manager:dev-master
 ```
 
 import it where ever it is required and initialize a new image like so:
 
 ```
 <?php
 
 use Etin\ImageManager\Image;
 
 $image = new Image("https://cdn.pixabay.com/photo/2015/04/23/21/59/tree-736877_960_720.jpg");
 ```
