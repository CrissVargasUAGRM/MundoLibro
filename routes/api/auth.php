<?php

use Illuminate\Support\Facades\Route;

Route::apiResources([
    'author' => 'AuthorController',
    'categories' => 'CategoryController',
    'editorials' => 'EditorialController',
    'books' => 'BookController',
    'formats' => 'FormatController',
]);
