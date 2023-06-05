<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::all();
        return view('faculty.index', compact('faculties'));
    }

    public function create()
    {
        $cycles = Cycle::all();
        return view('faculty.create', compact('cycles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:faculties'],
        ]);

        $number = Str::random('5') . '-' . rand('10', '90');
        $name = htmlentities($request->name);

        $faculty = Faculty::firstOrCreate([
            'faculty_number' => $number,
            'name' => $name,  
            'slug_name' => Str::slug($name),    
            'cycle_id' => $request->cycle      
        ]);

        if($faculty){
            session()->flash('message', 'Faculté créée avec succès');
            return redirect(route('faculty.index'));
        }
        
    }

   
    public function show(Faculty $faculty)
    {
        $cycles = Cycle::all();

        return view('faculty.show', compact('faculty', 'cycles'));
    }

    
    public function edit(Faculty $faculty)
    {
        $cycles = Faculty::all();
        return view('faculty.edit', compact('faculty', 'cycles'));
    }

    
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        $name = htmlentities($request->name);

        $faculty->update([
            'name' => $name,  
            'slug_name' => Str::slug($name),    
            'cycle_id' => $request->cycle      
        ]);

        if($faculty){
            session()->flash('message', 'Faculté modifiée avec succès');
            return redirect(route('faculty.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        session()->flash('message', "Faculté supprimée avec succès");
        return redirect()->route('faculty.index');
    }
}
