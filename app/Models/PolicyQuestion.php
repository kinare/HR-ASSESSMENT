<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question'];

    public function options()
    {
        return $this->hasMany(PolicyOption::class);
    }
}
