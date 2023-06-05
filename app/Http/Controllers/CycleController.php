<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $cycles = Cycle::all();
        return view('cycle.index', compact('cycles'));
    }


    public function create()
    {
        $cycles = Cycle::all();
        return view('cycle.create', compact('cycles'));
    }

    
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:cycles'],
        ]);

        $number = Str::random('4') . '-' . rand('10', '90');
        $name = htmlentities($request->name);
        $slug_name = Str::slug($name);
        
        $cycle = Cycle::firstOrCreate([
            'cycle_number' => $number,
            'name' => $request->name,  
            'slug_name' => $slug_name,          
        ]);

        if($cycle){
            session()->flash('message', 'Cycle crée avec succès');
            return redirect(route('cycle.index'));
        }
    }

   
    public function show(Cycle $cycle)
    {
        return view('cycle.show', compact('cycle'));
    }

    public function edit(Cycle $cycle)
    {
        $cycles = Cycle::all();
        return view('cycle.edit', compact('cycle', 'cycles'));
    }
    
    public function update(Request $request, Cycle $cycle)
    {
        if($cycle)
        {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:100'],
            ]);
    
            $name = htmlentities($request->name);
            $slug_name = Str::slug($name);
            
            $cycle->update([
                'name' => $request->name,  
                'slug_name' => $slug_name,          
            ]);

            session()->flash('message', 'Cycle crée avec succès');
            return redirect(route('cycle.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Cycle $cycle)
    {
        $cycle->delete();
        session()->flash('message', "Cycle supprimé avec succès");
        return redirect()->route('cycle.index');
    }
}
