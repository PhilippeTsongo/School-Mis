<?php

namespace App\Http\Controllers;

use App\Models\TypeBudget;
use Illuminate\Http\Request;

class BudgetTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('isFinancier');
    }

    public function index()
    {
        $budget_types = TypeBudget::all();
        return view('budget_type.index', compact('budget_types'));
    }


    public function create()
    {
        return view('budget_type.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:type_budgets'],
        ]);

        $name = htmlspecialchars($request->name);
        $description = htmlspecialchars($request->description);

        $budget_type = TypeBudget::firstOrCreate([
            'name' => $name,   
            'description' => $description         
        ]);

        if($budget_type){
            session()->flash('message', 'Type de prévision budgétaire crée avec succès');
            return redirect()->route('budget_type.index');
        }
    }
   
    public function show($id)
    {
        //
    }

    public function edit(TypeBudget $budget_type)
    {
        return view('budget_type.edit', compact('budget_type'));
    }
    
    public function update(Request $request, TypeBudget $budget_type)
    {
        if($budget_type)
        {
            $request->validate([
                'name' => ['required', 'string', 'max:150'],
            ]);

            $name = htmlspecialchars($request->name);
            $description = htmlspecialchars($request->description);

            $budget_type->update([
                'name' => $name,   
                'description' => $description         
            ]);

            session()->flash('message', 'Type de prévision budgétaire modifié avec succès');
            return redirect()->route('budget_type.index');
        } 
    }

    //EDIT FUNCCTION
    public function destroy(TypeBudget $budget_type)
    {
        if($budget_type)
        {
            $budget_type->delete();
            session()->flash('message', "Type de prévision budgétaire supprimé avec succès");
            return redirect()->route('budget_type.index');    
        }
    }
}
