<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    
    public function categoryRelation()
    {
        return $this->belongsTo(\App\Models\Post_categories::class, 'category', 'slog');
    }

}
