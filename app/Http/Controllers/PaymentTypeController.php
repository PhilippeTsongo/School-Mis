<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\PaymentType;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{   
    public function index()
    {
        $payment_types = PaymentType::all();
        return view('payment_type.index', compact('payment_types'));
    }

    public function create()
    {
        $classes = Classe::all();
        $academic_years = AcademicYear::all();
        return view('payment_type.create', compact('classes', 'academic_years'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:payment_types'],
            'total_amount' => ['required'],
        ]);

        $number = Str::random('5') . '-' . rand('10', '90');
        $name = htmlspecialchars($request->name);
        $slug_name = Str::slug($name);
        $total_amount = htmlspecialchars($request->total_amount);

        $payment_type = PaymentType::firstOrCreate([
            'payement_type_number' => $number,
            'name' => $name,  
            'slug_name' => $slug_name,    
            'classe_id' => $request->classe,
            'total_amount' => $total_amount,
            'academic_year_id' => $request->academic_year,
            'date_creation' => $request->date_creation      
        ]);

        if($payment_type){
            session()->flash('message', 'Type de paiement crée avec succès');
            return redirect(route('payment_type.index'));
        }
    }
   
    public function show(PaymentType $payment_type)
    {
        return view('payment_type.show', compact('payment_type'));
    }
    
    public function edit(PaymentType $payment_type)
    {
        return view('payment_type.edit', compact('payment_type'));
    }
    
    public function update(Request $request, PaymentType $payment_type)
    {
        if($payment_type)
        {
            $request->validate([
                'name' => ['required', 'string', 'min:6', 'max:250'],
            ]);

            $name = htmlentities($request->name);
            $slug_name = Str::slug($name);
            $total_amount = htmlspecialchars($request->total_amount);


            $payment_type->update([
                'name' => $name,  
                'slug_name' => $slug_name,    
                'total_amount' => $total_amount,
                'classe_id' => $request->classe,
                'academic_year_id' => $request->academic_year,
            ]);

            session()->flash('message', 'Type de paiement modifié avec succès');
            return redirect(route('payment_type.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(PaymentType $payment_type)
    {
        $payment_type->delete();
        session()->flash('message', "Type de paiement supprimé avec succès");
        return redirect()->route('payment_type.index');
    }
    
}
