<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('backend.pages.dashboard');
    }
    public function profile(Request $request){
        $user = Auth::user(); // gets the currently logged-in user
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'company_name' => 'nullable|string|max:255',
                'company_phone' => 'nullable|string|max:20',
                'company_address' => 'nullable|string|max:500',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'password' => 'nullable|confirmed|min:6',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->company_name = $request->company_name;
            $user->company_phone = $request->company_phone;
            $user->company_address = $request->company_address;

            if ($request->hasFile('company_logo')) {
                if ($user->company_logo && file_exists(storage_path('app/public/'.$user->company_logo))) {
                    unlink(storage_path('app/public/'.$user->company_logo));
                }

                $file = $request->file('company_logo');
                $filename = time().'_'.$file->getClientOriginalName();
                $path = $file->storeAs('company_logos', $filename, 'public');
                $user->company_logo = $path;
            }

            // Handle password update
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();
        }
        return view('profile.profile', compact('user'));
    }
}
