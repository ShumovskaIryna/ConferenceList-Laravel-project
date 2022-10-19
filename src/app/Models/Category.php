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

        /**
     * The users that belong to the reports.
     */

    public function parent()
    {
        return $this->belongsTo(
            Category::class, 'category_id'
        );
    }

    /**
     * The conferences that belong to the reports.
     */

    public function children() {
        return $this->hasMany(
            Category::class, 'category_id', 'id'
        );
    }
    
}
