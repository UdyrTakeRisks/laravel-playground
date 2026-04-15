<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */
#[Fillable(['name'])]
class Tenant extends Model
{
    use HasFactory;

    /**
     * relationships
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
