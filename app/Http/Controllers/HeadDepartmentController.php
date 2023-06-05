<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HeadDepartment;

class HeadDepartmentController extends Controller
{
    
    public function index()
    {
        $head_partments = HeadDepartment::all();
        return view('head_department.index', compact('head_partments'));
    }

    public function create()
    {
        $users = User::all();
        $head_partments = Department::all();

        return view('head_department.create', compact('users', 'head_partments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gender' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'string', 'min:10', 'max:14'],
        ]);

        $number = Str::random('3') . '-' . date('d') . '-' . rand('100', '350');
        $address = htmlentities($request->address);
        $tel = htmlentities($request->tel);
        $gender = htmlspecialchars($request->gender);

        $parent = HeadDepartment::firstOrCreate([
            'head_department_number' => $number,
            'address' => $address, 
            'gender' => $gender,
            'tel' => $tel,
            'department_id' => $request->department,
            'user_id' => $request->user,
            'status' => 'ACTIVE'
        ]);

        if($parent){
            session()->flash('message', 'Chef de département créé avec succès');
            return redirect(route('head_department.index'));
        }
    }
   
    public function show(HeadDepartment $head_department)
    {
        return view('head_department.show', compact('head_department'));
    }
    
    public function edit(parent $head_department)
    {
        $users = User::all();
        $head_partments = Department::all();
        return view('head_department.edit', compact('users', 'head_partments', 'head_department'));
    }
    
    public function update(Request $request, HeadDepartment $head_department)
    {
        if($head_department){

            $request->validate([
                'gender' => ['required', 'string', 'max:1'],
                'address' => ['required', 'string', 'max:255'],
                'tel' => ['required', 'string', 'min:10', 'max:14'],
            ]);

            $address = htmlentities($request->address);
            $tel = htmlentities($request->tel);
            $gender = htmlspecialchars($request->gender);

            $head_department = HeadDepartment::firstOrCreate([
                'address' => $address, 
                'gender' => $gender,
                'tel' => $tel,
                'department_id' => $request->department,
                'user_id' => $request->user,
            ]);

            session()->flash('message', 'Chef de département modifié avec succès');
            return redirect(route('head_department.index'));
        }
    }

    //EDIT FUNCCTION
    public function destroy(HeadDepartment $head_department)
    {
        if($head_department)
        {
            if($head_department->user)
            {
                $head_department->user->delete();
            }

            $head_department->delete();

            session()->flash('message', "Chef de départemen supprimé avec succès");
            return redirect()->route('head_department.index');

        }
       
    }
   
}
