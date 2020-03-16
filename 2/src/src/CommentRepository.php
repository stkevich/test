<?php


namespace StKevich\Component;


class CommentRepository
{
    const BASE_URL = 'http://example.com/';

    /** @var HttpAdapterInterface */
    protected HttpAdapterInterface $adapter;

    public function __construct(HttpAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Comment[]|null
     * @throws CommentException
     */
    public function load(): ?array
    {
        $json = $this->adapter->get(self::BASE_URL . 'comments');

        if (empty($json)) {
            return null;
        }
        $array = json_decode($json);
        $res = [];
        foreach ($array as $item) {
            if (!isset($item['id']) || !isset($item['name']) || !isset($item['text'])) {
                throw new CommentException('Unexpected server response');
            }
            $comment = new Comment($item['name'], $item['text']);
            $comment->setId((int)$item['name']);
            $res[] = $comment;
        }
        return $res;
    }

    /**
     * @param Comment $comment
     */
    public function persist(Comment $comment): void
    {
        if (empty($comment->getId())) {
            $this->save($comment);
        }
        else {
            $this->update($comment);
        }
    }

    /**
     * @param Comment $comment
     */
    protected function save(Comment $comment): void
    {
        $array = [
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ];
        $this->adapter->post(self::BASE_URL . 'comment', $array);
    }

    /**
     * @param Comment $comment
     */
    protected function update(Comment $comment): void
    {
        $array = [
            'name' => $comment->getName(),
            'text' => $comment->getText(),
        ];

        $this->adapter->put(self::BASE_URL . 'comment' . $comment->getId(), $array);
    }

}
