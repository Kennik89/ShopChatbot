<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'tag'];

    public function chatbotReports()
    {
        return $this->belongsToMany(ChatbotReport::class, 'taggable')->withTimestamps();
    }

}
