<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $incrementing = true;
    protected $primaryKey = 'category_id';
    public $timestamps = false;
    protected $fillable = ['name'];

    public function queries()
    {
        return $this->hasMany(Query::class);
    }
}


