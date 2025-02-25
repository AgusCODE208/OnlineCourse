<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\CourseRepositoryInterface;
use Illuminate\Support\Collection;

class CourseRepository implements CourseRepositoryInterface
{
    public function searchByKeyword(string $keyword): Collection
    {
        return Course::where('name', 'like', "%{$keyword}%")
            ->orWhere('about', 'like', "%{$keyword}%")
            ->get();
    }

    public function getAllWithCategory(): Collection
    {
        return Course::with('category')->latest()->get();
    }
}
