<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imageUrl(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }
}
