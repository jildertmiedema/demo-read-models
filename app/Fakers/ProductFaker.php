<?php

namespace App\Fakers;

class ProductFaker extends \Faker\Provider\Base
{
    protected static $productFormats = [
        '{{material}} {{product}}',
        '{{color}} {{material}} {{product}}',
    ];

    protected static $material = [
        'iron',
        'metal',
        'wooden',
        'leather',
        'rock',
        'cotton',
        'plastic',
    ];

    protected static $color = [
        'blue',
        'green',
        'red',
        'brown',
        'yellow',
    ];

    protected static $product = [
        'shoe',
        'train',
        'car',
        'dog',
        'cat',
    ];

    public function material()
    {
        return static::randomElement(static::$material);
    }

    public function color()
    {
        return static::randomElement(static::$color);
    }

    public function product()
    {
        return static::randomElement(static::$product);
    }

    public function productName()
    {
        $format = static::randomElement(static::$productFormats);

        return $this->generator->parse($format);
    }
}
