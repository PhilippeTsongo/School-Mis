<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }
    
    public function index()
    {
        $academic_years = AcademicYear::all();

        if(count($academic_years) > 0)
        {
            $data = array(
                'message'=>'Liste des année académiques',
                'academic years' => $academic_years,
                'status'=> 200
            );
            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Aucune année académique', 'status' => 411]);

        //return view('academic_year.index', compact('academic_years'));
    }


    public function create()
    {
        //return view('academic_year.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'year_range' => ['required', 'string', 'min:9', 'max:10', 'unique:academic_years'],
        ]);

        $number = Str::random('2') . '-' . rand('10', '30');
        $year_range = htmlentities($request->year_range);

        $academic_year = AcademicYear::firstOrCreate([
            'academic_number' => $number, 
            'year_range' => $year_range,  
        ]);

        // if($academic_year){
        //     session()->flash('message', 'Année académique créée avec succès');
        //     return redirect(route('academic_year.index'));
        // }  
        
        if($academic_year){
            
            $data = array(
                'message'=>'Academic year created successfully',
                'academic year' => $academic_year,
                'status'=> 200
            );

            return response()->json($data, 200);
        }
    }
   
    public function show(AcademicYear $academic_year)
    {
        
        if($academic_year){
            
            $data = array(
                'message'=>'Academic year detail',
                'academic year' => $academic_year,
                'status'=> 200
            );

            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Année académique n\'existe pas', 'status' => 411]);

        //return view('academic_year.show', compact('academic_year'));
    }

    public function edit(AcademicYear $academic_year)
    {   
        if($academic_year){
            
            $data = array(
                'message'=>'Academic year edit detail',
                'academic year' => $academic_year,
                'status'=> 200
            );

            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Année académique n\'existe pas', 'status' => 411]);

        //return view('academic_year.edit', compact('academic_year'));
    }
    
    public function update(Request $request, AcademicYear $academic_year)
    {
        $request->validate([
            'year_range' => ['required', 'string', 'min:9', 'max:10'],
        ]);
        $year_range = htmlentities($request->year_range);

        $academic_year = AcademicYear::firstOrCreate([
            'year_range' => $year_range,  
        ]);

        if($academic_year){
            
            $data = array(
                'message'=>'Année académique modifiée avec succès',
                'academic year' => $academic_year,
                'status'=> 200
            );

            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Année académique n\'existe pas'], 411);
        

        // if($academic_year){
        //     session()->flash('message', 'Année académique modifiée avec succès');
        //     return redirect(route('academic_year.index'));
        // }
    }

    //EDIT FUNCCTION
    public function destroy(AcademicYear $academic_year)
    {
        if($academic_year){

            $academic_year->delete();
            
            $data = array(
                'message'=>'Année académique supprimée avec succès',
                'status'=> 200
            );

            return response()->json($data, 200);
            
            // session()->flash('message', "Année académique supprimée avec succès");
            // return redirect()->route('academic_year.index');
        }
        return response()->json(['message' => 'Année académique n\'existe pas', 'status' => 411]);

    }
}
