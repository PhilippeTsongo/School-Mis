<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Classe;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classe.index', compact('classes'));
    }

    public function create()
    {
        $departments = Department::all();
        $cycles = Cycle::all();
        return view('classe.create', compact('departments', 'cycles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:classes'],
        ]);

        $number = Str::random('2') . '-' . rand('30', '90');
        $name = htmlentities($request->name);
        $slug_name = Str::slug($name);

        $classe = Classe::firstOrCreate([
            'class_number' => $number,
            'name' => $name,  
            'slug_name' => $slug_name,   
            'department_id' => $request->department,
            'cycle_id' => $request->cycle      
        ]);

        if($classe){
            session()->flash('message', 'Classe créée avec succès');
            return redirect(route('classe.index'));
        }
    }

   
    public function show(classe $classe)
    {
        return view('classe.show', compact('classe'));
    }

    
    public function edit(classe $classe)
    {
        $departments = Department::all();
        $cycles = Cycle::all();
        return view('classe.edit', compact('classe', 'departments', 'cycles'));
    }

    
    public function update(Request $request, classe $classe)
    {
        if($classe){
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
            ]);

            $name = htmlentities($request->name);
            $slug_name = Str::slug($name);

            $classe = Classe::firstOrCreate([
                'name' => $name,  
                'slug_name' => $slug_name,   
                'department_id' => $request->department,
                'cycle_id' => $request->cycle      
            ]);
        
            session()->flash('message', 'Classe modifiée avec succès');
            return redirect(route('classe.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(classe $classe)
    {
        if($classe)
        {
            $classe->delete();
            session()->flash('message', "Classe supprimée avec succès");
            return redirect()->route('classe.index');
        }
    }
   
}
