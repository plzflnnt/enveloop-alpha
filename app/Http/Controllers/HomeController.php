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

        return view('home')
            ->withEnvelopes($envelopes)
            ->withUser(User::find(Auth::id()));
    }
}
