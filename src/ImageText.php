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
     * @var int
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
     * @var string
     */
    private $hexColor;
    /**
     * @var int
     */
    private $fontScale;

    public function __construct(string $text, string $hexColor, string $fontPath, int $fontSize=20, int $fontScale=1, int $fontAngle=0)
    {
        $this->text = $text;
        $this->hexColor = $hexColor;
        $this->fontPath = $fontPath;
        $this->fontSize = $fontSize;
        $this->fontAngle = $fontAngle;
        $this->fontScale = $fontScale;

        $this->calculateDimensions();
    }

    private function calculateDimensions()
    {
        $this->textBox = imagettfbbox($this->fontSize, $this->fontAngle, $this->fontPath, $this->text);

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
    public function getFontSize(): int
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
}