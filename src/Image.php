<?php


namespace Etin\ImageManager;


class Image
{
    /**
     * The image resource.
     * @var false|resource
     */
    private $resource;

    /**
     * The width of the image.
     * @var false|int
     */
    private $width;

    /**
     * The height of the image.
     * @var false|int
     */
    private $height;

    /**
     * Image constructor.
     * @param string $imagePath
     * @throws \Exception
     */
    public function __construct(string $imagePath)
    {
        $this->initializeImage($imagePath);
    }

    /**
     * Initialize the image by performing 
     * all necessary preprocessing tasks
     * including creating the resource and
     * correcting the orientation
     * @param string $imagePath
     * @throws \Exception
     */
    private function initializeImage(string $imagePath)
    {
        $this->createImageResourceFrom($imagePath);
        $this->correctImageOrientation($imagePath);
        $this->width = imagesx($this->resource);
        $this->height = imagesy($this->resource);
    }

    /**
     * Create the resource from the file path provided.
     * Throw exception if resource cannot be created.
     * @param string $imagePath
     * @throws \Exception
     */
    private function createImageResourceFrom(string $imagePath)
    {
        if (! $this->resource = imagecreatefromstring(file_get_contents($imagePath))) throw new \Exception("Image path is not a valid image");
        $this->correctImageOrientation($imagePath);
    }

    /**
     * Correct the image orientation via EXIF data if necessary
     * @param string $imagePath
     */
    private function correctImageOrientation(string $imagePath)
    {
        $exif = @exif_read_data($imagePath);
        $orientation = $exif['Orientation'];

        switch ($orientation) {
            case 3:
                $this->resource = imagerotate($this->resource, 180, 0);
                break;
            case 6:
                $this->resource = imagerotate($this->resource, -90, 0);
                break;
            case 8:
                $this->resource = imagerotate($this->resource, 90, 0);
                break;
            default:
                break;
        }
    }

    /**
     * Return the width of the image
     * @return false|int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Return the height of the image
     * @return false|int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Add a border to the edges of the image.
     * @param int $top
     * @param int $left
     * @param int $bottom
     * @param int $right
     * @param string $hexColor
     * @return Image
     */
    public function addBorder(int $top, int $left, int $bottom, int $right, string $hexColor)
    {
        $newImageWidth = $this->width + $left + $right;
        $newImageHeight = $this->height + $top + $bottom;
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);

        $rgb = convertHexToRgb($hexColor);

        $borderColor = imagecolorallocate($newImage, $rgb['r'], $rgb['g'], $rgb['b']);
        imagefilledrectangle($newImage, 0, 0, $newImageWidth, $newImageHeight, $borderColor);

        imagecopyresized(
          $newImage,
          $this->resource,
          $left,
          $top,
          0,
          0,
          $this->width,
          $this->height,
          $this->width,
          $this->height
        );

        $this->resource = $newImage;
        return $this;
    }

    /**
     * Write text over the image
     * @param ImageText $text
     * @param string $align
     * @return $this
     */
    public function addText($text, $positionX="center", $positionY="center", bool $shouldScale=false)
    {
        if (! $text instanceof ImageText){
          $text = new ImageText($text);
        }
        if($shouldScale) $text->scale($this->width);

        $positionX = is_string($positionX) ? resolvePosition($positionX, $this->width, $text->getWidth()) : $positionX;
        $positionY = is_string($positionY) ? resolvePosition($positionY, $this->height, $text->getHeight()) : $positionY;
        
        imagettftext(
          $this->resource,
          $text->getFontSize(),
          $text->getFontAngle(),
          $positionX,
          $positionY,//TODO:Add support for dynamic text alignment
          imagecolorallocate($this->resource, $text->getColor('r'), $text->getColor('g'), $text->getColor('b')),
          $text->getFontPath(),
          $text->getText()
        );
        return $this;
    }

    public function renderJpeg(string $fileName=null, int $quality=null)
    {
        if(! $fileName) header('Content-type: image/jpeg');
        imagejpeg($this->resource, $fileName, $quality);
    }

    public function renderPng(string $fileName=null, int $quality=null)
    {
        if(! $fileName) header('Content-type: image/png');
        imagepng($this->resource, $fileName, $quality);
    }
    
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        imagedestroy($this->resource);
    }
}