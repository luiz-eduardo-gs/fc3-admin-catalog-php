<?php

namespace Core\UseCase\DTO\Category\UpdateCategory;

class UpdateCategoryInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool   $isActive
    )
    {
    }
}