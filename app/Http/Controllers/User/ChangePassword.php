<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Oms\User\Manager as UserManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ChangePassword extends AuthController
{
    public function __invoke(Request $request, UserManager $userManager)
    {
        $passwordDetails = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword'
        ]);

        $user = $userManager->find($request->user()->id);

        $checkPassword = Auth::attempt(array(
            'username' => $request->user()->username,
            'password' => $passwordDetails['oldPassword']
        ));

        if ($checkPassword) {
            $user->password = Hash::make($passwordDetails['newPassword']);
            if ($user->save()) {
                Session::flash('notice', 'Successfully changed password');
                return redirect()->back()->withInput();
            } else {
                Session::flash('notice', 'Cannot change password');
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('notice', 'Incorrect Password');
            return redirect()->back()->withInput();
        }
    }
}