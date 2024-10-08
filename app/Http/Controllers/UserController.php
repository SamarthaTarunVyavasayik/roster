<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Models\Role;
use App\Models\UserRole;



class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
     public function index(User $model)
    {
        #return view('users.index', ['users' => $model->paginate(15),'activePage'=>'Users']);		## This page is as it is.
	$roles = Role::all();

        return view('usermanagement', ['users'=>$model->all(), 'roles'=>$roles,
					 'activePage'=>'user-management', 'titlePage' => 'Users']);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		if(!auth()->user()->hasRole('admin')){
			return abort(403);
		}
        return view('users.form');
    }

    public function store(Request $request, User $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());
        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
		if(!auth()->user()->hasRole('admin')){
			return abort(403);
		}
	$roles = Role::all();
        //return view('users.edit', compact('user'));
        return view('users.edit', ['user'=>$user, 'roles'=>$roles]);
    }

    public function update(Request $request, User  $user)
    {
        $hasPassword = $request->get('password');
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password']
        ));
	if(!empty($request->user_role)){
		$user_details = User::where('email',$request->email)->first();
		$user_id = $user_details->id;
		$role_ids = $request->user_role;
		// first remove all roles
		UserRole::where('user_id', $user_id)->delete();	
		// then add
		foreach($role_ids as $r_i){
		if(empty($r_i)) continue;
		$user_role = new UserRole();
		$user_role->user_id = $user_id;
		$user_role->role_id = $r_i;
		$user_role->save();
		}
	}
        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
	$user = \App\Models\User::findOrFail($request->user_id);
	if(!empty($request->delete_captcha) &&
                $request->delete_captcha == $request->hidden_captcha){
        	$user->delete();
		Session::flash('alert-success', 'User successfully deleted.');
        	return redirect('/admin/usermanagement');
        }
	else{
		Session::flash('alert-danger', 'Please fill Captcha');
        	return redirect('/admin/usermanagement');
        }
    }
}
