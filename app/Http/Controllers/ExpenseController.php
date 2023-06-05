<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $today = date('d-m-Y');
        $dailys = Expense::where('expense_date', $today )
                        ->orderBy('id', 'DESC')     
                        ->get(); 

        $month = date('M');
        $year = date('Y');

        $months = Expense::where('mois', $month)
                        ->where('annee', $year)
                        ->orderBy('id', 'DESC')    
                        ->get();

        $years = Expense::where('annee', $year )
                        ->orderBy('id', 'DESC')    
                        ->paginate(10); 

        $expenses = Expense::all();
        return view('expense.index', compact('expenses', 'dailys', 'months', 'years', 'today', 'month', 'year'));
    }

   
    public function create()
    {
        $type_expenses = ExpenseType::all();
        return view('expense.create', compact('type_expenses'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'amount' => ['required', 'integer'],
        ]);

        $today = date('d-m-Y');
        $month = date('M');
        $year = date('Y');

        $number = date('Y') .'-'. date('d') . rand(100, 999);
        $expense_type = htmlspecialchars($request->expense_type);
        $amount = htmlspecialchars($request->amount);
        $description = htmlspecialchars($request->description);
        
        if($request->amount > 0)
        {     
            $expense = Expense::create([
                'expense_number' => $number,
                'expense_type' => $expense_type,
                'montant' => $request->montant,
                'description' => $description,
                'amount' => $amount,
                'expense_date' => $today,
                'mois' => $month,
                'annee' => $year
            ]);
                    
            session()->flash('message', 'Dépense créée avec succès');
            return redirect()->route('expense.index');

        }else{
            session()->flash('message_err', 'Le montant doit être supérieur à 0');
            return redirect()->route('expense.create');
        }
    }

    
    public function show(Expense $expense)
    {
        return view('expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $type_expenses = ExpenseType::all();

        return view('expense.edit', compact('expense', 'type_expenses'));
    }

    
    public function update(Request $request, Expense $expense)
    {
        if($expense)
        {
            $request->validate([
                'amount' => ['required', 'integer'],
            ]);

            $today = date('d-m-Y');
            $month = date('M');
            $year = date('Y');

            $expense_type = htmlspecialchars($request->expense_type);
            $amount = htmlspecialchars($request->amount);
            $description = htmlspecialchars($request->description);
            
            if($request->amount > 0)
            {     
                $expense->update([
                    'expense_type' => $expense_type,
                    'montant' => $amount,
                    'description' => $description,
                    'amount' => $amount,
                    'expense_date' => $today,
                    'mois' => $month,
                    'annee' => $year
                ]);
                        
                session()->flash('message', 'Dépense modifiée avec succès');
                return redirect()->route('expense.index');

            }else{
                session()->flash('message_err', 'Le montant doit être supérieur à 0');
                return redirect()->route('expense.create');
            }  
        }
    }

    
    public function destroy(Expense $expense)
    {
        if($expense)
        {
            $expense->delete();
            session()->flash('message', 'La Expense a été supprimée avec succès');
            return redirect()->route('expense.index');
        }
    }
}
