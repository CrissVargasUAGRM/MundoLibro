<?php

namespace App;

use App\Author;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'synopsis',
        'fk_created_by',
        'fk_updated_by'
    ];

    function authors(){
        return $this->belongsToMany(Author::class, 'author_book', 'fk_book', 'fk_author');
    }

    function categories(){
        return $this->belongsToMany(Category::class, 'book_category', 'fk_book', 'fk_category');
    }

    function createdBy(){
        return $this->belongsTo(User::class, 'fk_created_by');
    }

    function updatedBy(){
        return $this->belongsTo(User::class, 'fk_updated_by');
    }
}
