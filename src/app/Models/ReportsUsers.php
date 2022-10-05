<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportsUsers extends Model
{
    use HasFactory;
    protected $table = "reports_conferences_users";
    public $timestamps = false;
}
