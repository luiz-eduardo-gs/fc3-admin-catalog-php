<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function testAttributes(): void
    {
        $category = new Category(
            name: 'new cat',
            description: 'new desc',
            isActive: true,
        );

        $this->assertNotEmpty($category->id);
        $this->assertEquals('new cat', $category->name);
        $this->assertEquals('new desc', $category->description);
        $this->assertEquals(true, $category->isActive);
        $this->assertNotEmpty($category->createdAt());
    }

    public function testActivated(): void
    {
        $category = new Category(
            name: 'new cat',
            isActive: false,
        );

        $this->assertFalse($category->isActive);

        $category->activate();

        $this->assertTrue($category->isActive);
    }

    public function testDeactivated(): void
    {
        $category = new Category(
            name: 'new cat',
        );

        $this->assertTrue($category->isActive);

        $category->deactivate();

        $this->assertFalse($category->isActive);
    }
    
    public function testUpdated(): void
    {
        $uuid = Uuid::random();

        $category = new Category(
            id: $uuid,
            name: 'new cat',
            description: 'new desc',
            isActive: true,
            createdAt: '2023-01-01 12:12:12',
        );

        $category->update(
            name: 'new name',
            description: 'new description',
            isActive: true,
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertEquals('new name', $category->name);
        $this->assertEquals('new description', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testNameException()
    {
        $this->expectException(EntityValidationException::class);

        new Category(
            name: 'ne',
            description: 'new desc',
        );
    }

    public function testDescriptionException()
    {
        $this->expectException(EntityValidationException::class);

        new Category(
            name: 'new cat',
            description: random_bytes(999999),
        );
    }
}