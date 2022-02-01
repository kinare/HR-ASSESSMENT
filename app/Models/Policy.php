<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = ['topic'];

    public function documents(): HasMany
    {
        return $this->hasMany(PolicyDocument::class);
    }

    public function questions()
    {
        return $this->hasMany(PolicyQuestion::class);
    }
}
