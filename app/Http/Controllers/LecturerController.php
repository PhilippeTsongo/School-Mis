<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LecturerController extends Controller
{    
    public function index()
    {
        $lecturers = Lecturer::all();
        return view('lecturer.index', compact('lecturers'));
    }

    public function create()
    {
        $users = User::where('user_role', 'Lecturer');
        return view('lecturers.create', compact('users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'address' => ['required', 'string', 'min:6', 'max:100'],
            'tel' => ['required', 'string', 'min:10', 'max:14', 'unique:lecturers'],
        ]);

        $number = Str::random('3') . '-' . rand('100', '300') .'-'.rand('10-90');
        $address = htmlentities($request->address);
        $tel = htmlentities($request->tel);

        $lecturer = Lecturer::firstOrCreate([
            'lecturer_number' => $number,
            'address' => $address,  
            'tel' => $tel,    
            'user_id' => $request->user,
            'status' => 'ACTIVE'

        ]);

        if($lecturer){
            session()->flash('message', 'Enseignant créé avec succès');
            return redirect(route('lecturers.index'));
        }
    }

    public function show(Lecturer $lecturer)
    {
        $lecturers = Lecturer::all();
        return view('lecturer.show', compact('lecturer', 'lecturers'));
    }
    
    public function edit(Lecturer $lecturer)
    {
        return view('lecturer.edit', compact('lecturer'));
    }

    
    public function update(Request $request, Lecturer $lecturers)
    {
        $request->validate([
            'address' => ['required', 'string', 'min:6', 'max:100'],
            'tel' => ['required', 'string', 'min:10', 'max:14'],
        ]);

        $address = htmlentities($request->address);
        $tel = htmlentities($request->tel);

        $lecturers = Lecturer::firstOrCreate([
            'address' => $address,  
            'tel' => $tel,    
            'user_id' => $request->user      
        ]);

        if($lecturers){
            session()->flash('message', 'Enseignant Modifié avec succès');
            return redirect(route('lecturer.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(Lecturer $lecturer)
    {
        if($lecturer)
        {
            if($lecturer->user)
            {
                $lecturer->user->delete();
            }   

            $lecturer->delete();

            session()->flash('message', "Enseignant supprimé avec succès");
            return redirect()->route('lecturer.index');
        }
    }
   
}
