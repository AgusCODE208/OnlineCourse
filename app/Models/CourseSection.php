<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use App\Models\SectionContent;

class CourseSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'course_id',
        'position',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function sectionContent(): HasMany
    {
        return $this->hasMany(SectionContent::class, 'course_id');
    }
}
