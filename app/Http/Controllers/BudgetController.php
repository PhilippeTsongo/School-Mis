<?php

namespace App\Http\Controllers;

use App\Models\TypeBudget;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function index()
    {
       $budgets_recettes = Budget::all();
        return view('budget_recette.index', compact('budgets_recettes'));
    }

    public function create()
    {
        $type_budgets = TypeBudget::all();
        $academic_years = AcademicYear::all();
        return view('budget_recette.create', compact('academic_years', 'type_budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'min:0'],
        ]);

        $number = Str::random('2') . '-' . rand('10', '40') . rand('50', '80');
        $amount = htmlspecialchars($request->amount);
        $description = htmlspecialchars($request->description);
        $type_budget = htmlspecialchars($request->type_budget);
        $academic_year = htmlspecialchars($request->academic_year);

        $budget_recette = Budget::firstOrCreate([
            'budgets_recette_number' => $number,
            'name' => $amount,  
            'description' => $description,   
            'type_budget_id' => $type_budget,
            'academic_year_id' => $academic_year,
        ]);

        if($budget_recette){
            session()->flash('message', 'Prévision budgétaire de recettes créée avec succès');
            return redirect(route('budget_recette.index'));
        }
    }
  
    public function show(Budget $budget_recette)
    {
        return view('budget_recette.show', compact('budget_recette'));
    }

    public function edit(Budget $budget_recette)
    {
        $type_budgets = TypeBudget::all();
        $academic_years = AcademicYear::all();
        return view('budget_recette.edit', compact('budget_recette', 'type_budgets', 'academic_years'));
    }
    
    public function update(Request $request, Budget $budget_recette)
    {
        $request->validate([
            'amount' => ['required', 'min:0'],
        ]);

        $amount = htmlspecialchars($request->amount);
        $description = htmlspecialchars($request->description);
        $type_budget = htmlspecialchars($request->type_budget);
        $academic_year = htmlspecialchars($request->academic_year);

        $budget_recette->update([
            'name' => $amount,  
            'description' => $description,   
            'type_budget_id' => $type_budget,
            'academic_year_id' => $academic_year,
        ]);

        if($budget_recette){
            session()->flash('message', 'Prévision budgétaire de recettes modifiée avec succès');
            return redirect(route('budget_recette.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Budget $budget_recette)
    {
        if($budget_recette)
        {
            $budget_recette->delete();

            session()->flash('message', "Prévision budgétaire de recettes supprimée avec succès");
            return redirect()->route('budgets_recette.index');
        }
    }   
}
