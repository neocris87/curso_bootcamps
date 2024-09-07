<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')->latest()->get();
        // $chirps = Chirp::latest()->get();

        return view('chirps.index' , compact('chirps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:5|max:255',
        ]);

        $request->user()->chirps()->create($validated);
        session()->flash('success', 'Chirp agregado con exito');
        return redirect()->route('chirps.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {

        // if (Auth::id() != $chirp->user_id) {
        //    abort(403);
        // }

        $this->authorize('update', $chirp);


        return view('chirps.edit' , compact('chirp'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {

        // if (Auth::id() != $chirp->user_id) {
        //     abort(403);
        //  }

        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|min:5|max:255',
        ]);

        $chirp->update($validated);

        session()->flash('success', 'Actualziado con exito');

        return redirect()->route('chirps.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {

        $this->authorize('delete', $chirp);

        $chirp->delete();

        session()->flash('success', 'Eliminado con exito');

        return redirect()->route('chirps.index');
    }
}
