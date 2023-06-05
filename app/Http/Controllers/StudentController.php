<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentParent;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    public function create()
    {
        $cycles = Cycle::all();
        $classes = Classe::all();
        $parents = StudentParent::all();
        $academic_years = AcademicYear::all();

        return view('student.create', compact('cycles', 'classes', 'parents', 'academic_years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:students'],
            'date_of_birth' => ['required', 'dat'],
            'gender' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'string', 'min:10', 'max:14'],
        ]);

        $number = Str::random('3') . '-' . date('Y') . date('d') . '-' . rand('10', '90');
        $address = htmlentities($request->address);

        $student = Student::firstOrCreate([
            'student_number' => $number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $address, 
            'tel' => $request->tel,
            'user_id' => $request->user,
            'classe' => $request->classe,
            'parent' => $request->parent,
            'cycle' => $request->classe,
            'academic_year' => $request->academic_year,
            'status' => 'ACTIVE'
        ]);

        if($student){
            session()->flash('message', 'Etudiant créé avec succès');
            return redirect(route('student.index'));
        }
    }
   
    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }
    
    public function edit(Student $student)
    {
        $cycles = Cycle::all();
        $classes = Classe::all();
        $parents = StudentParent::all();
        $academic_years = AcademicYear::all();
        return view('Student.edit', compact('student', 'cycles', 'classes', 'parents', 'academic_years'));
    }
    
    public function update(Request $request, Student $student)
    {
        if($student){
            $request->validate([
                'name' => ['required', 'string', 'min:6', 'max:255', 'unique:students'],
                'date_of_birth' => ['required', 'dat'],
                'gender' => ['required', 'string', 'max:1'],
                'address' => ['required', 'string', 'max:255'],
                'tel' => ['required', 'string', 'min:10', 'max:14'],
            ]);

            $address = htmlentities($request->address);

            $student->update([
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $address, 
                'tel' => $request->tel,
                'user_id' => $request->user,
                'classe' => $request->classe,
                'parent' => $request->parent,
                'cycle' => $request->classe,
                'academic_year' => $request->academic_year,
                'status' => 'ACTIVE'
            ]);

            session()->flash('message', 'Etudiant modifié avec succès');
            return redirect(route('student.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Student $student)
    {
        if($student)
        {
            if($student->user)
            {
                $student->user->delete();
            }

            $student->delete();

            session()->flash('message', "Etudiant supprimé avec succès");
            return redirect()->route('student.index');

        }
       
    }
    
}
