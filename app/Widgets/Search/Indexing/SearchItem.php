<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing;

class SearchItem
{
    private $title;
    private $short;
    private $text;
    private $type;
    private $link;
    private $itemId;

    public function __construct(
        string $title,
        string $short,
        string $text,
        string $type,
        string $link,
        $itemId
    ) {
        $this->title = $title;
        $this->short = $short;
        $this->text = $text;
        $this->type = $type;
        $this->link = $link;
        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function short(): string
    {
        return $this->short;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function link(): string
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function itemId()
    {
        return $this->itemId;
    }
}
