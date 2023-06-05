<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class UserController extends Controller
{
    //INDEX FUNCTION
    public function index()
    {
        $users = User::all();
        if(count($users) > 0)
        {
            $data = array(
                'message'=>'Liste des utilisateurs',
                'utilisateurs' => $users,
                'status'=> 200
            );
            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Pas d\'utilisateurs', 'status' => 411]);

        //return view('users.index', compact('users'));
    }

    //CREATE FUNCTION
    public function create()
    {
        $users = User::all();

        $user_types = UserRole::all();

        $data = array(
            'message'=>'Liste des utilisateurs',
            'utilisateurs' => $users,
            'type d\'utilisateurs' => $user_types,
            'status'=> 200
        );
        return response()->json($data, 200);

        //return view('auth.register', compact('users', 'user_types'));
    }

    //STORE FUNCTION
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'min:3', 'max:45'],
            'first_name' => ['string', 'min:3', 'max:45'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
            'user_role' => ['required', 'integer'],
        ]);


        if($request->password == $request->password_confirmation)
        {
            if ($request->hasFile('image') || !$request->hasFile('image') ) 
            {
                // $file = $request->file('image');
                // $file_name = $file->getClientOriginalName();
                // $destination = public_path().'/IMAGES/profile';
                // $file->move($destination, $file_name);
                
                $name = htmlentities($request->name);
                $first_name = htmlentities($request->first_name);
                $last_name = htmlentities($request->last_name);

                $user = User::create([
                    'name' => $name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $request->email,
                    //'image' => '/IMAGES/profile/'.$file_name,
                    'password' => Hash::make($request->password),
                    'user_role' => $request->user_role
                ]);

                if($user){

                    $data = array(
                        'message'=>'Utilisateur crée avec succès',
                        'utilisateurs' => $user,
                        'status'=> 200
                    );
                    return response()->json($data, 200);

                    // session()->flash('message', 'Utilisateur crée avec succès');
                    // return redirect(route('users.index'));
                }
                return response()->json(['message' => 'Erreur lors de l\'enregistrement', 'status' => 500]);

            }else{

                return response()->json(['message' => 'Erreur Vous devez selectionnez une image', 'status' => 411]);

                // session()->flash('message_err', 'Vous devez choisir une image pour cette utilisateur');
                // return redirect()->route('users.create');
            }
        }else{
            return response()->json(['message' => 'les mots de passes doivent être égaux', 'status' => 411]);

            // session()->flash('message_err', 'les mots de passes doivent être égaux');
            // return redirect()->route('users.create');
        }
    }

    //SHOW FUNCTION
    public function show(User $user)
    {
        if(!empty($user))
        {
            $data = array(
                'message' =>'Utilisateur',
                'utilisateur' => $user,
                'status' => 200
            );
            return response()->json($data, 200);
        }else{
            return response()->json(['message' => 'Pas d\'utilisateur', 'status' => 411]);

        }

    }

    //EDIT FUNCTION
    public function edit(User $user)
    {

        $user_types = UserRole::all();

        if(isset($user))
        {
            $data = array(
                'message' =>'Utilisateur',
                'utilisateur' => $user,
                'type d\'ulisisateurs' => $user_types,
                'status' => 200
            );
            return response()->json($data, 200);
        }
        return response()->json(['message' => 'Pas d\'utilisateur', 'status' => 411]);

        //return view('users.edit', compact('users', 'user', 'user_types'));
    }

    //UPDATE FUNCTION
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'first_name' => ['required' ,'string', 'min:3', 'max:45'],
            'email' => ['required', 'string', 'min:8', 'max:45'],
            'user_role' => ['required', 'integer'],
        ]);

        if($request->password == $request->password_confirmation)
        {
            $name = htmlentities($request->name);
            $first_name = htmlentities($request->first_name);
            $last_name = htmlentities($request->last_name);

            $user->update([
                'name' => $name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $request->email,
                'user_role' => $request->user_role,
            ]);

            if($user){

                $data = array(
                    'message' =>'Utilisateur modifié avec succès',
                    'utilisateur' => $user,
                    'status' => 200
                );
                return response()->json($data, 200);
            // session()->flash('message', 'Utilistaeur modifié avec succès');
            // return redirect()->route('users.index');
            }
        }else{

            return response()->json(['message' => 'le mot de passe ne correspond pas au mot de passe de confirmation', 'status' => 411]);
            // session()->flash('message_err', 'le mot de passe ne correspond pas au mot de passe de confirmation');
            // return redirect()->route('users.index');
        }
    }

    //EDIT FUNCCTION
    public function destroy(User $user)
    {

        if($user)
        {
            if($user->head_department)
            {
                $user->head_department->delete();
            }

            if($user->lecturer)
            {
                $user->lecturer->delete();
            }

            if($user->student)
            {
                $user->student->delete();
            }

            if($user->student_parent)
            {
                $user->student_parent->delete();
            }

            $user->delete();

            $data = array(
                'message' =>'Utilisateur supprimé avec succès',
                'status' => 200
            );

            return response()->json($data, 200);

            // session()->flash('message', "Uutilisateur supprimé avec succès");
            // return redirect()->route('users.index');

        }    
        return response()->json(['message' => 'Pas d\'utilisateur', 'status' => 411]);

    }
}
