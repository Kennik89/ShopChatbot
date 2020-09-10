<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = array( 'user_input', 'chatbot_output', 'output' );

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'taggable')->withTimestamps();
    }

}
