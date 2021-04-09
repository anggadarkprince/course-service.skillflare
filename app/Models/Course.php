<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'title', 'has_certificate', 'thumbnail',
        'type', 'status', 'price', 'level', 'description'
    ];

    /**
     * Get teacher who mentoring the course.
     *
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get chapters of the course.
     *
     * @return HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     * Get chapters of the course.
     *
     * @return HasManyThrough
     */
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Chapter::class);
    }

    /**
     * Get course image of the course.
     *
     * @return HasMany
     */
    public function courseImages()
    {
        return $this->hasMany(CourseImage::class);
    }

    /**
     * Get users of the course.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses');
    }

    /**
     * Get reviews of the course.
     *
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
