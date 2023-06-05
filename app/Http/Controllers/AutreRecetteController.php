<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\TypeRecette;
use App\Models\AutreRecette;
use Illuminate\Http\Request;

class AutreRecetteController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('isFinancier');
    }

    public function index()
    {
        $recettes = AutreRecette::orderBy('id', 'DESC')
                                ->paginate(10);
        return view('recette.index', compact('recettes'));
    }


    public function create()
    {
        $type_recettes = TypeRecette::all();
                      
        return view('recette.create', compact('type_recettes'));
    }
    
    public function store(Request $request)
    {
       
        $request->validate([
            'type' => ['required', 'string', 'max:255'],
            'montant' => ['required'],
            'description' => ['required', 'string', 'min:5', 'max:250'],

        ]);

        $validated = htmlspecialchars($request);

        if($validated)
        {
            if($request->montant > 0)
            {   
           
                $today = date('d-m-Y');
                $month = date('M');
                $year = date('Y');

                $type = htmlspecialchars($request->type);
                $montant = htmlspecialchars($request->montant);
                $description = htmlspecialchars($request->description);

                $number = date('d') .'-'. rand(10, 90). rand(100, 900);

                $autreRecette = AutreRecette::create([
                    'recette_number' => $number,
                    'type_recette_id' => $type,
                    'montant' => $montant,
                    'date_creation' => $today,
                    'mois' => $month,
                    'annee' => $year,
                    'description' => $description,
                    'academic_year_id' =>$request->academic_year
                ]);

                if($autreRecette){
                    session()->flash('message', 'Recette créée avec succès');
                    return redirect(route('recette.index'));
                }           
            }else{
                session()->flash('message', 'Le Montant doit être supérieur à 0');
                return redirect()->route('recette.create');
            }
        }
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit(AutreRecette $autre_recette)
    {
        //dd($autre_recette);
        $type_recettes = TypeRecette::all();
        return view('recette.edit', compact('autre_recette', 'type_recettes'));
    }

    
    //UPDATE FUNCTION
    public function update(Request $request, AutreRecette $autre_recette)
    {
        $validated = htmlspecialchars($request);

        if($validated)
        {
            if($request->montant > 0)
            {   

                $type = htmlspecialchars($request->type);
                $montant = htmlspecialchars($request->montant);
                $description = htmlspecialchars($request->description);

                $autre_recette->update([
                    'type_recette_id' => $type,
                    'montant' => $montant,
                    'description' => $description,
                    'academic_year_id' =>$request->academic_year

                ]);

                if($autre_recette){
                    session()->flash('message', 'Recette modifiée avec succès');
                    return redirect(route('recette.index'));
                }           
            }else{
                session()->flash('message', 'Le Montant doit être supérieur à 0');
                return redirect()->route('recette.edit', $autre_recette);
            }
        }
    }

    //EDIT FUNCCTION
    public function destroy(AutreRecette $autre_recette)
    {
        if($autre_recette)
        {
            $autre_recette->delete();
         
            session()->flash('message', "Recette supprimée avec succès");
            return redirect()->route('recette.index');
        }
    }

}
