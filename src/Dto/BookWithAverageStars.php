<?php

namespace App\Dto;

use App\Entity\Book;

class BookWithAverageStars
{
    public function __construct(
        public readonly Book $book,
        public readonly ?float $averageStars
    ) {
    }
}
