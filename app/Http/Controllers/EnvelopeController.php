<?php

namespace App\Http\Controllers;

use App\Envelope;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvelopeController extends Controller
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

    public function createEnvelope(Request $request){
//        try{
            $envelope = new Envelope();
            $envelope->name = $request->name;
            $envelope->style = $request->style;
            $envelope->user_id = Auth::id();
            $envelope->save();
//        }catch (Exception $e){
//            return $e->getMessage();
//        }
        return redirect('/home');
    }
}
