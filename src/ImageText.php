<?php


namespace Etin\ImageManager;

class ImageText
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $fontPath;
    /**
     * @var float
     */
    private $fontSize;
    /**
     * @var int
     */
    private $fontAngle;
    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;
    /**
     * @var array
     */
    private $rgbColor;
    /**
     * @var float
     */
    private $fontScale;
    /**
     * @var array|false
     */
    private $textBox;

    public function __construct(string $text, string $hexColor="#000", string $fontPath=(__DIR__ . "/OpenSans.ttf"), int $fontSize=20, float $fontScale=1, int $fontAngle=0)
    {
      // print_r($fontPath);die();
        $this->text = $text;
        $this->rgbColor = convertHexToRgb($hexColor);
        $this->fontPath = $fontPath;
        $this->fontSize = $fontSize;
        $this->fontAngle = $fontAngle;
        $this->fontScale = $fontScale;

        $this->calculateDimensions();
    }

    private function calculateDimensions()
    {
        $this->textBox = imagettfbbox($this->fontSize, $this->fontAngle, $this->fontPath, $this->text);//TODO: Check if Array was created, if not, error with font file

        $this->width = $this->textBox[2] - $this->textBox[0];
        $this->height = $this->textBox[7] - $this->textBox[1];
    }

    public function scale(int $imageWidth)
    {
        $this->fontSize = $this->fontSize * (($imageWidth / $this->width) * $this->fontScale);
        $this->calculateDimensions();
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getFontSize(): float
    {
        return $this->fontSize;
    }

    /**
     * @return int
     */
    public function getFontAngle(): int
    {
        return $this->fontAngle;
    }

    /**
     * @return string
     */
    public function getFontPath(): string
    {
        return $this->fontPath;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getColor(string $color): int
    {
        return $this->rgbColor[$color];
    }
}