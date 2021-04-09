<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'avatar', 'email', 'profession'
    ];

    /**
     * Get courses of the teacher.
     *
     * @return HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
