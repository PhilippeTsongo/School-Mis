<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    
    public function index()
    {
        $departments = Department::all();
        return view('department.index', compact('depa$departments'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        return view('department.create', compact('faculties'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:departments'],
        ]);

        $number = Str::random('4') . '-' . rand('10', '90');
        $name = htmlentities($request->name);
        $slug_name = Str::slug($name);

        $department = Department::firstOrCreate([
            'dept_number' => $number,
            'name' => $name,  
            'slug_name' => $slug_name,    
            'faculty_id' => $request->faculty      
        ]);

        if($department){
            session()->flash('message', 'Departement crée avec succès');
            return redirect(route('department.index'));
        }
    }

   
    public function show(Department $department)
    {
        $faculties = Faculty::all();

        return view('department.show', compact('department', 'faculties'));
    }

    
    public function edit(Department $department)
    {
        $faculties = Department::all();
        return view('department.edit', compact('department', 'faculties'));
    }

    
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        $number = Str::random('4') . '-' . rand('10', '90');
        $name = htmlentities($request->name);
        $slug_name = Str::slug($name);

        $department->update([
            'dept_number' => $number,
            'name' => $name,  
            'slug_name' => $slug_name,
            'faculty_id' => $request->faculty      
        ]);

        if($department){
            session()->flash('message', 'Departement modifié avec succès');
            return redirect(route('department.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Department $department)
    {
        $department->delete();
        session()->flash('message', "Departement supprimé avec succès");
        return redirect()->route('department.index');
    }
    
}
