<?php

namespace App;

use App\Traits\Logs;
use App\USer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes, Logs;

    protected $fillable = ['name', 'avatar', 'fk_created_by', 'fk_updated_by'];

    protected $hidden = ['deleted_at'];

}
