<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $roles = Role::select('id','name')->orderBy('name')->get();       

        return view('users.index', compact('roles'));
    }

    public function listusers()
    {       

        $users = User::with('roles')->orderBy('id')->paginate();       

        return response()->json($users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $url = "";
        if ($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            $name = $file->getClientOriginalName();
            $valor = Storage::putFileAs('public/users', $file, $name);             
            $url = str_replace('public/','storage/',$valor);  
        }
        
        $user = User::create([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => bcrypt($request->password),
            'profile_photo_path'    => $url
        ]);     
               
        $user->roles()->sync($request->role);

        return response()->json(['message' => "Se registro el usuario $user->name con exito!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {              
        $roles = Role::all()->pluck('name','id');
       
        return view('users.edit', compact('user','roles'));       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {        

        $user->roles()->sync($request->roles);

        $user->update([
            'name'  => $request->input('name'),
            'email' => $request->input('email')  
        ]);

        return redirect()->route('users.edit', $user)->with('info', "El Usuario se actualizó satisfactoriamente");       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'El usuario fue eliminada correctamente!']);
    }

    public function show_password(User $user){
        return response()->json($user);
    }

    public function update_password(UpdatePassword $request, User $user){

        $request->validate([
            'user_password' => 'required|min:6',
        ]);

        $user->update([
            'password'  => bcrypt($request->input('user_password'))
        ]);

        return response()->json(['message' => "Indicar al usuario $user->name cerrar la sesión e ingresar con el nuevo password!"]);

    }
}
