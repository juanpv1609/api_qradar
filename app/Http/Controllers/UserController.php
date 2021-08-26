<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        $cond=[ 'is_deleted' => 0];
         $usuarios = User::with('company', 'rol')->where($cond)->orderBy('username')->get()->toArray();

        return ($usuarios);

    }
    public function indexAll()
    {
        $cond=['is_deleted' => 0];

        $usuarios = User::with('company', 'rol')->where($cond)->orderBy('username')->get()->toArray();

        return ($usuarios);

    }
    public function actualUser()
    {

        $user = User::with('company', 'rol')->where('id', auth()->user()->id)->First()->toArray();

        //return DataTables::eloquent($users)->make(true);
        return $user;
    }
    public function store(Request $request)
    {
        // $client = Cliente::create($request->all());
        // $clientes = Cliente::all();
        // return view('cliente.index')->with('clientes', $clientes);

        $user = new User([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'rol_id' => $request->input('rol_id'),
            'company_id' => $request->input('company_id'),
            'password' => Crypt::encryptString($request->input('password')),
        ]);
        $user->save();

        return response()->json('user created!');

    }
    public function usuarioUpdatePassword(Request $request)
    {

        $user = User::where('id',$request->user)->first();
        if (Crypt::decryptString( $user->password)==$request->old_password) {
            $user->password = Crypt::encryptString($request->new_password);
            $user->save();
            # code...
            return response()->json('user created!');
        }else{
            return response()->json('password error!');

        }


    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json('user updated!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        //$user->delete();
        $user->is_deleted=1;
        $user->save();
        return response()->json('user deleted!');
    }
}
