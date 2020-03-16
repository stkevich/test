<?php

declare(strict_types=1);

namespace StKevich\Tests;

use PHPUnit\Framework\TestCase;
use StKevich\Component\Comment;
use StKevich\Component\CommentRepository;
use StKevich\Component\HttpAdapterInterface;

class CommentRepositoryTest extends TestCase
{

    public function testLoad()
    {
        $adapter = $this->createMock(HttpAdapterInterface::class);
        $adapter
            ->method('get')
            ->willReturn(json_encode([['id'=>1, 'name'=>'NoName', 'text'=>'NoText']]));

        $commentRepository = new CommentRepository($adapter);
        $comments = $commentRepository->load();

        $expected = [
            (new Comment('NoName', 'NoText'))->setId(1)
        ];
        $this->assertEquals($expected, $comments);
    }

    public function testSave()
    {
        $p = 0;
        $adapter = $this->createMock(HttpAdapterInterface::class);
        $adapter
            ->method('post')
            ->willReturnCallback(function ($url, $params) use ($p) {$p = $params;});

        $commentRepository = new CommentRepository($adapter);

        $comment = (new Comment('NoName', 'NoText'));
        $commentRepository->persist($comment);

        $expected = json_encode(['name'=>'NoName', 'text'=>'NoText']);
        $this->assertEquals($expected, $p);
    }

    public function testUpdate()
    {
        $p = 0;
        $adapter = $this->createMock(HttpAdapterInterface::class);
        $adapter
            ->method('put')
            ->willReturnCallback(function ($url, $params) use ($p) {$p = $params;});

        $commentRepository = new CommentRepository($adapter);
        $comment = (new Comment('NoName', 'NoText'))->setId(1);
        $commentRepository->persist($comment);

        $expected = json_encode(['name'=>'NoName', 'text'=>'NoText']);
        $this->assertEquals($expected, $p);
    }

}
