<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Models\User;
use App\Models\Wallet;

class SettingController extends Controller
{
    public function allUser()
    {
        $user = User::get();

        return view('settings')->with([
            'users'     => $user
        ]);
    }

    public function editUser(Request $request, $id)
    {
        $userEdit   = Auth::user($request->id);

        $userEdit->groupInt = $request->group;
        $userEdit->role     = $request->role;
        $userEdit->save();

        return redirect('/settings')->with([
            'status'    => 'User Updated'
        ]);
    }

    public function getUserAjax($id)
    {
        $user   = User::find($id);

        return response()->json($user);
    }

    public function registerUser(Request $request)
    {

        $this->validate($request,[
            'name'        => 'required|min:2|max:250',
            'email'       => 'required|email',
            'password'    => 'required|min:6|confirmed',
            'group'       => 'required'
          ]);

        $group = 0;
        $group = User::where('groupInt', $request->group)->count();
        
        if($group != 1 ){

            $newUser        = new User();
            $newUser->name      = $request->name;
            $newUser->email     = $request->email;
            $newUser->password  = bcrypt($request->password);
            $newUser->role      = 2;
            $newUser->groupInt  = $request->group;
            $newUser->save();

            $createWallet = new Wallet();
            $createWallet->groupInt   = $request->group;
            $createWallet->save();

            

            return redirect('/login')->with('status', 'Successfully Registered. Please re-login!');
            
        }else{
            return redirect('/register')->with('error', 'Group registered!');
        }
    }

}
