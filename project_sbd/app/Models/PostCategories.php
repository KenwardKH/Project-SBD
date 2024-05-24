<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategor extends Model
{
    use HasFactory;

    protected $table = 'post_categories';

    public $timestamps = false;

    protected $fillable = ['post_id', 'category_id'];
}
