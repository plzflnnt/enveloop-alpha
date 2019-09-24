<?php

namespace App\Http\Controllers;

use App\Earning;
use App\EarningBalance;
use App\Envelope;
use App\Feed;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $envelopeNegative = false;
        $envelopes = Envelope::where('user_id',Auth::id())->get();
        $envelopesWithBalance = [];
        $envelopesIdArray = [];
        foreach ($envelopes as $envelope){
            $envelope->balance = Envelope::envelopeBalance($envelope->id);
            $envelopesWithBalance[] = $envelope;
            $envelopesIdArray[] = $envelope->id;
            if($envelope->balance < 0){
                $envelopeNegative = true;
            }
        }
        $user = User::find(Auth::id());
        $balance = User::updatedBalance($user->id);
        $grandBalance = User::grandBalance($balance,$envelopes);

        $feed = Feed::where('feed.user_id', Auth::id())
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope', 'envelopes.id as envelope_id')
            ->orderBy('updated_at','desc')
            ->limit(5)
            ->get();

        return view('home')
            ->withEnvelopes($envelopes)
            ->withUser($user)
            ->withBalance($balance)
            ->withFeed($feed)
            ->withGrandBalance($grandBalance)
            ->withEnvelopeNegative($envelopeNegative)
//            ->withReportOne(Envelope::envelopesExpense())

//            ->withReport(Envelope::userMonthsReport());
            ->withReport(Envelope::userMonthly(Carbon::now(),13,-1));

    }
}
