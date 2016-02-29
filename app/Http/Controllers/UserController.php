<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UserController extends Controller {

  /**
   * Responde con la lista de usuarios
   * entra con GET en .../api/user 
   * @return json array { users: [{...}, {...}, ...] } 
   */
  public function index(Request $request) {
    return response()->json([ "users" => User::all()]);
  }

  /**
   * Responde con un usuario
   * entra con GET en .../api/user/{$id}
   * @param  int  $id
   * @return json array { user: { ... } } 
   */
  public function show($id) {
    return response()->json(["user" => User::find($id)]);
  }

  /**
   * Guardar un nuevo usuario, y si existe su id entonces actualizarlo.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //User::create($request->all());
    if ($User = User::find($request->input('id'))) {
      $User->update($request->all());
      $status = "usuario actualizado";
    } else {
      User::create($request->all());
      $status = "usuario creado";
    }
    return response()->json([ "users" => User::all(), "status" => $status]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    //$user = User::find($id);
    //$user->update($request->all());
    return ['controller' => 'update'];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    User::destroy($id);
    return response()->json([ "users" => User::all(), "status" => "deleted user $id"]);
  }

}
