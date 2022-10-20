<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
    ];

    public function parent()
    {
        return $this->belongsTo(
            Category::class, 'category_id'
        );
    }

    public function parents()
    {
        return $this->belongsTo(
            Category::class, 'category_id'
        )->with('parent');
    }

    public function child() {
        return $this->hasMany(
            Category::class, 'category_id'
        );
    }

    public function children() {
        return $this->hasMany(
            Category::class, 'category_id'
        )->with('children');
    }
    
}
