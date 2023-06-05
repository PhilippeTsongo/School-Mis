<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{   
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        $academic_years = AcademicYear::all();
        $payments_types = PaymentType::all();

        return view('payment.create', compact('students', 'academic_years', 'payments_types'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:payments'],
            'amount' => ['reuired'],
        ]);

        $number = rand('1000', '3000') . date('Y') . '-' . rand('10', '90');
        $month = date('m');
        $amount = htmlspecialchars($request->amount);

        $classe = Payment::firstOrCreate([
            'payment_number' => $number,
            'month' => $month,  
            'amount' => $amount,
            'payment_date' => $request->payment_date, 
            'student_id' => $request->student,
            'academic_year_id' => $request->academic_year,
            'payment_type' => $request->payment_type  
        ]);

        if($classe){
            session()->flash('message', 'Paiement crée avec succès');
            return redirect(route('payment.index'));
        }
    }

   
    public function show(Payment $payment)
    {
        return view('payment.show', compact('classe'));
    }

    
    public function edit(Payment $payment)
    {
        $students = Student::all();
        $academic_years = AcademicYear::all();
        $payments_types = PaymentType::all();
        return view('payment.edit', compact('payments_types', 'students', 'academic_years'));
    }

    
    public function update(Request $request, Payment $payment)
    {
        if($payment){
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255', 'unique:payments'],
                'amount' => ['reuired'],
            ]);
    
            $month = date('m');
            $amount = htmlspecialchars($request->amount);
    
            $classe = Payment::firstOrCreate([
                'month' => $month,  
                'amount' => $amount,
                'payment_date' => $request->payment_date, 
                'student_id' => $request->student,
                'academic_year_id' => $request->academic_year,
                'payment_type' => $request->payment_type  
            ]);
    
            session()->flash('message', 'Paiement modifié avec succès');
            return redirect(route('payment.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Payment $payment)
    {
        if($payment)
        {
            $payment->delete();
            session()->flash('message', "Paiement supprimé avec succès");
            return redirect()->route('payment.index');
        }
    }

}
