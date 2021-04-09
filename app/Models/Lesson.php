<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'chapter_id', 'title', 'description', 'source', 'type'
    ];

    /**
     * Get chapter belong to the lesson.
     *
     * @return BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}