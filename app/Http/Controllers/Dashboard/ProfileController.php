<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Locales;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $countries = Countries::getNames();
        $languages = Locales::getNames();


        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => $countries,
            'languages' => $languages
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();


        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'birthday'      => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'street_address'=> 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'state'         => 'nullable|string|max:255',
            'postal_code'   => 'nullable|string|max:20',
            'country' => 'required|string|size:2',
            'locale'        => 'nullable|string|max:10'
        ]);

        $user->profile()->updateOrCreate(['user_id' => $user->id], $validated);

        return redirect()->route('dashboard.profile.edit')->with('success', 'Update Profile Successfully');
    }

}
