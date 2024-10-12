<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    use HasFactory;

    protected $table = "todos";
    protected $fillable = ["task", "is_done", "category_id"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
