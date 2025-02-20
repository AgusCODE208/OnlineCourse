<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\CourseBenefit;
use App\Models\CourseMentor;
use App\Models\CourseSection;
use App\Models\Category;

class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'slug',
        'name',
        'thumbnail',
        'about',
        'is_popular',
        'category_id'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(CourseBenefit::class, 'course_id');
    }

    public function courseSection(): HasMany
    {
        return $this->hasMany(CourseSection::class, 'course_id');
    }

    public function courseMentor(): HasMany
    {
        return $this->hasMany(CourseMentor::class, 'course_id');
    }

    public function courseStudent(): HasMany
    {
        return $this->hasMany(CourseStudent::class, 'course_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getContentCountAttribute()
    {
        return $this->courseSection->sum(function ($section) {
            return $section->sectionContents->count();
        });
    }
}
