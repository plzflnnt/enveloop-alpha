<?php

namespace App\Http\Controllers;

use App\Earning;
use App\EarningBalance;
use App\Envelope;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $envelopesIdArray = [];
        foreach ($envelopes as $envelope){
            $envelope->balance = Envelope::envelopeBalance($envelope->id);
            $envelopesWithBalance[] = $envelope;
            $envelopesIdArray[] = $envelope->id;
        }
        $user = User::find(Auth::id());
        $balance = User::updatedBalance($user->id);

        $earnings = DB::table('earnings')
            ->whereIn('envelope_id',$envelopesIdArray)
            ->join('envelopes', 'earnings.envelope_id', '=', 'envelopes.id')
            ->select('earnings.*', 'envelopes.name as envelope')
            ->get();
        $balanceEarnings = DB::table('earning_balance')
            ->where('user_id', $user->id)
            ->get();

        $expenses = DB::table('expenses')
            ->whereIn('envelope_id',$envelopesIdArray)
            ->join('envelopes', 'expenses.envelope_id', '=', 'envelopes.id')
            ->select('expenses.*', 'envelopes.name as envelope')
            ->get();
        $balanceExpenses = DB::table('expense_balance')
            ->where('user_id', $user->id)
            ->get();
        return view('home')
            ->withEnvelopes($envelopes)
            ->withUser($user)
            ->withBalance($balance)
            ->withEarnings($earnings)
            ->withBalanceEarnings($balanceEarnings)
            ->withExpenses($expenses)
            ->withBalanceExpenses($balanceExpenses);
    }
}
