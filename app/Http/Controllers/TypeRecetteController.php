<?php

namespace App\Http\Controllers;

use App\Models\TypeRecette;
use Illuminate\Http\Request;

class TypeRecetteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('isFinancier');
    }

    public function index()
    {
        $type_recettes = TypeRecette::all();
        return view('type_recette.index', compact('type_recettes'));
    }


    public function create()
    {
        return view('type_recette.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:type_recettes'],
        ]);

        $name = htmlspecialchars($request->name);
        $description = htmlspecialchars($request->description);

        $type_recette = TypeRecette::firstOrCreate([
            'name' => $name,   
            'description' => $description         
        ]);

        if($type_recette){
            session()->flash('message', 'Type de Recettes crée avec succès');
            return redirect()->route('type_recette.index');
        }
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(TypeRecette $type_recette)
    {
        return view('type_recette.edit', compact('type_recette'));
    }

    
    public function update(Request $request, TypeRecette $type_recette)
    {
        if($type_recette)
        {
            $request->validate([
                'name' => ['required', 'string', 'max:150'],
            ]);

            $name = htmlspecialchars($request->name);
            $description = htmlspecialchars($request->description);

            $type_recette->update([
                'name' => $name,   
                'description' => $description         
            ]);

            session()->flash('message', 'Type de Recettes modifié avec succès');
            return redirect()->route('type_recette.index');
        } 
    }

    //EDIT FUNCCTION
    public function destroy(TypeRecette $type_recette)
    {
        if($type_recette)
        {
            $type_recette->delete();
            session()->flash('message', "Type de la Recette supprimé avec succès");
            return redirect()->route('type_recette.index');    
        }
    }

}
