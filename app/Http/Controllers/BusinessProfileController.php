<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{
    public function index()
    {
        $profile = BusinessProfile::first();

        return view(
            'business-profile.index',
            compact('profile')
        );
    }

    public function create()
    {
        return view('business-profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required',
            'pemilik' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {
            $logo = $request
                ->file('logo')
                ->store('business', 'public');
        }

        BusinessProfile::create([
            'nama_usaha' => $request->nama_usaha,
            'pemilik' => $request->pemilik,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'logo' => $logo
        ]);

        return redirect('/business-profile');
    }
}
