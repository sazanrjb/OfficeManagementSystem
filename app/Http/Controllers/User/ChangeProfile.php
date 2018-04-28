<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AuthController;
use App\Oms\User\Manager as UserManager;
use App\Oms\User\Models\UserProfile;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangeProfile extends AuthController
{
    public function index(Guard $auth, UserManager $userManager, UserProfile $userProfile)
    {
        $user = $userManager->find($auth->user()->id);
        $query = $userProfile->join('users', 'users.id', '=', 'user_profiles.user_id')
            ->where('user_profiles.user_id', $user->id)
            ->get();
        return view('oms.pages.editprofile')->with('user', $user)->with('profile', $query);
    }

    public function update(Request $request, UserManager $userManager)
    {
        $this->validate($request, [
            'firstName' => 'required|min:3|max:40',
            'lastName' => 'required|min:3|max:40',
            'email' => 'required|min:3|max:40',
            'address' => 'required|min:3|max:40',
            'contact' => 'required|min:3|max:40',
        ]);

        $user = $userManager->find($request->user()->id);
        $userDetails = $request->all();
        $userProfileDetails = $request->only(['address', 'contact', 'gender']);
        $user->fill($userDetails);

        if ($user->save()) {
            $profile = $user->profile ?? new UserProfile();

            if (!empty($userDetails['profile_picture']) && $userDetails['profile_picture']->isValid()) {
                $destination = 'img';
                $ext = $userDetails['profile_picture']->getClientOriginalExtension();
                $filename = rand(1111, 99999) . '.' . $ext;
                $userProfileDetails['profile_picture'] = $destination . '/' . $filename;
                $userDetails['profile_picture']->move($destination, $filename);
            }

            $profile->fill($userProfileDetails);
            $profile->forceFill(['user_id' => $user->id]);
            if ($profile->save()) {
                Session::flash('notice', 'Successfully updated profile.');
                return redirect()->back();
            }
        }
    }
}