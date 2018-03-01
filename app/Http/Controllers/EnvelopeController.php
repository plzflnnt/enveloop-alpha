<?php

namespace App\Http\Controllers;

use App\Earning;
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
        try{
            $envelope = new Envelope();
            $envelope->name = $request->name;
            $envelope->style = $request->style;
            $envelope->user_id = Auth::id();
            $envelope->save();
        }catch (Exception $e){
            return $e->getMessage();
        }
        return redirect('/home');
    }

    public function createEarning(Request $request){
        try{
            $earning = new Earning();
            $earning->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
            $earning->envelope_id = $request->envelope_id;
            $earning->save();
        }catch (Exception $e){
            return $e->getMessage();
        }
        return redirect('/home');
    }
    public function createExpense(Request $request){
        try{
            $expense = new Earning();
            $expense->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
            $expense->envelope_id = $request->envelope_id;
            $expense->save();
        }catch (Exception $e){
            return $e->getMessage();
        }
        return redirect('/home');
    }
}
