<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenedUrl extends Model
{
    /** @use HasFactory<\Database\Factories\ShortenedUrlFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'url', 'short_code', 'expiration_date'];
}
