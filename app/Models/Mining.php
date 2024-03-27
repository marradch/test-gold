<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mining extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'mine_date_time', 'value', 'unit'];
}
