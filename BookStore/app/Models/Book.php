<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'books';

    // Fillable properties to allow mass assignment
    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_image',
        'price',
        
    ];
}
