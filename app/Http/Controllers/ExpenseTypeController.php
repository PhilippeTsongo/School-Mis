<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
       $type_expenses = ExpenseType::all();
        return view('expense_type.index', compact('type_expenses'));
    }

    public function create()
    {
        return view('expense_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:expense_types'],
        ]);

        $number = Str::random('2') . '-' . rand('100', '900');
        $name = htmlentities($request->name);

        $expense_type = ExpenseType::firstOrCreate([
            'expense_type_number' => $number,
            'name' => $name,  
            'slug_name' => Str::slug($name),    
        ]);

        if($expense_type){
            session()->flash('message', 'Type de dépense créé avec succès');
            return redirect(route('expense_type.index'));
        }
    }
   
    public function show(ExpenseType $expense_type)
    {
        return view('expense_type.show', compact('expense_type'));
    }
    
    public function edit(ExpenseType $expense_type)
    {
        return view('expense_type.edit', compact('expense_type'));
    }
    
    public function update(Request $request, ExpenseType $expense_type)
    {
        if($expense_type){

            $request->validate([
                'name' => ['required', 'string', 'min:6', 'max:255'],
            ]);

            $name = htmlentities($request->name);

            $expense_type->update([
                'name' => $name,  
                'slug_name' => Str::slug($name),    
            ]);

            session()->flash('message', 'Type de dépense modifié avec succès');
            return redirect(route('expense_type.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(ExpenseType $expense_type)
    {
        if($expense_type)
        {
            $expense_type->delete();

            session()->flash('message', "Type de dépense supprimé avec succès");
            return redirect()->route('expense_type.index');

        }  
    }
  
}
