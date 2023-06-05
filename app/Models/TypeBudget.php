<?php

namespace App\Models;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeBudget extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function budgets ()
    {
        return $this->hasMany(Budget::class);
    }

}
