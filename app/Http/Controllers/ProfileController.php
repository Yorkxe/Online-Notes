<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($user){

        $Profile = Profile::findOrFail($user);

        return view('Profile.show', [
            'profile' => $Profile,
        ]);
    }
    
    public function edit(Request $request, User $user){
        if(Auth()->User() == $user){
            $user = User::find($user);

            return view('Profile.edit', [
                'user' => $user,
            ]);    
        }else{
            return redirect()->route('Profile.show', [
                'user' => Auth()->User()->id,
            ])->withErrors(['error' => 'You have no access to edit others profile']); 
        }
    }
}