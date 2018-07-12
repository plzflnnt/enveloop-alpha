<?php

namespace App\Http\Controllers;

use App\Earning;
use App\EarningBalance;
use App\Envelope;
use App\Feed;
use App\User;
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

        $feed = Feed::where('feed.user_id', Auth::id())
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope')
            ->orderBy('updated_at','desc')
            ->paginate(20);

        return view('home')
            ->withEnvelopes($envelopes)
            ->withUser($user)
            ->withBalance($balance)
            ->withFeed($feed)
            ->withReportOne(Envelope::envelopesExpense())
            ->withReportMonthByMonth(Envelope::userMothsReport());
    }
}
