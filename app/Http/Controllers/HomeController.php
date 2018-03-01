<?php

namespace App\Http\Controllers;

use App\Envelope;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $envelopes = Envelope::where('user_id',Auth::id())->get();
        $envelopesWithBalance = [];
        foreach ($envelopes as $envelope){
            $envelope->balance = Envelope::envelopeBalance($envelope->id);
            $envelopesWithBalance[] = $envelope;
        }
        $user = User::find(Auth::id());
        $balance = User::updatedBalance($user->id);

        return view('home')
            ->withEnvelopes($envelopes)
            ->withUser($user)
            ->withBalance($balance);
    }
}
