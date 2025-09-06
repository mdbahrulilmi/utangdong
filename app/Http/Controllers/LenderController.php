<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\User;
use Illuminate\Http\Request;

class LenderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        return view('lender-create',['user_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'user_id' => 'required|exists:users,id',
            'company' => 'required|string|max:255',
        ]);

        Lender::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'company' => $request->company,
            ]
        );

        $user = User::find($request->user_id);

        $user->role = 'lender';
        $user->save();

        return redirect()->route('dashboard')->with('message', 'User is now registered as a lender!');
    }
}
