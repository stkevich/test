<?php


namespace StKevich\Component;


class Comment
{
    /** @var int|null */
    protected ?int $id = null;

    /** @var string */
    protected string $name;

    /** @var string */
    protected string $text;

    /**
     * Comment constructor.
     * @param int $postId
     * @param string $name
     * @param string $text
     */
    public function __construct(string $name, string $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
