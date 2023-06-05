<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentParent;

class ParentController extends Controller
{

    public function index()
    {
        $parents = StudentParent::all();
        return view('parent.index', compact('parents'));
    }

    public function create()
    {
        $users = User::all();

        return view('parent.create', compact('users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'string', 'min:10', 'max:14'],
        ]);

        $number = Str::random('3') . '-' . date('d') . '-' . rand('10', '90');
        $address = htmlentities($request->address);

        $parent = StudentParent::firstOrCreate([
            'parent_number' => $number,
            'address' => $address, 
            'tel' => $request->tel,
            'user_id' => $request->user,
            'status' => 'ACTIVE'
        ]);

        if($parent){
            session()->flash('message', 'Parent créé avec succès');
            return redirect(route('parent.index'));
        }
    }
   
    public function show(StudentParent $parent)
    {
        return view('parent.show', compact('parent'));
    }
    
    public function edit(parent $parent)
    {
        $users = User::all();
        return view('parent.edit', compact('users', 'parent'));
    }
    
    public function update(Request $request, StudentParent $parent)
    {
        if($parent){

            $request->validate([
                'address' => ['required', 'string', 'max:255'],
                'tel' => ['required', 'string', 'min:10', 'max:14'],
            ]);

            $address = htmlentities($request->address);

            $parent->update([
                'address' => $address, 
                'tel' => $request->tel,
                'user_id' => $request->user,
            ]);
        
            session()->flash('message', 'Parent modifié avec succès');
            return redirect(route('parent.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(StudentParent $parent)
    {
        if($parent)
        {
            if($parent->user)
            {
                $parent->user->delete();
            }

            $parent->delete();

            session()->flash('message', "Parent supprimé avec succès");
            return redirect()->route('parent.index');

        }  
    }
}
