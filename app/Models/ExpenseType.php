<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseType extends Model
{
    use HasFactory;

    protected $fillable = ['expense_type_number', 'name', 'slug_name'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
