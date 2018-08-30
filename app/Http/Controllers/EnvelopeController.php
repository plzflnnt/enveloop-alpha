<?php

namespace App\Http\Controllers;

use App\Earning;
use App\EarningBalance;
use App\Envelope;
use App\Expense;
use App\ExpenseBalance;
use App\Feed;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnvelopeController extends Controller
{

    /*
     *  Type of envelopes:
     *
     *  1- balance earning
     *  2- earning on envelope
     *  3- balance expense
     *  4- expense on envelope
     *
     */


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
            $envelope->user_id = Auth::id();
            $envelope->save();
        }catch (Exception $e){
            return $e->getMessage();
        }
        return redirect()->back();
    }

    public function createEarning(Request $request){
//        try{
            if($request->envelope_id == 'sd'){
                //in case is a balance earning
                $feed = new Feed();
                $feed->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
                $feed->user_id = Auth::id();
                $feed->envelope_id = 1;
                $feed->type = 1;
                $feed->name = $request->name;
                $feed->valid_at = Carbon::now();
                $feed->save();

                $mensagem = 'Você inseriu '.$request->value.' ao seu saldo não alocado. <a href="'.url('undo-earning/'.encrypt($feed->id)).'" class="alert-link">Desfazer</a>';
                Session::flash('flash_message', $mensagem);
            }else{
                //in case is an envelope earning
                $feed = new Feed();
                $feed->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
                $feed->envelope_id = $request->envelope_id;
                $feed->user_id = Auth::id();
                $feed->type = 2;
                $feed->name = $request->name;
                $feed->valid_at = Carbon::now();
                $feed->save();

                $envelope = Envelope::find($request->envelope_id);
                $mensagem = 'Você inseriu '.$request->value.' ao envelope '.$envelope->name.'. <a href="'.url('undo-earning/'.encrypt($feed->id)).'" class="alert-link">Desfazer</a>';
                Session::flash('flash_message', $mensagem);
            }
//        }catch (Exception $e){
//            return $e->getMessage();
//        }

        return redirect()->back();
    }
    public function createExpense(Request $request){
//        try{
            if($request->envelope_id == 'sd'){
                //in case is a balance expense
                $feed = new Feed();
                $feed->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
                $feed->user_id = Auth::id();
                $feed->envelope_id = 1;
                $feed->type = 3;
                $feed->name = $request->name;
                $feed->valid_at = Carbon::now();
                $feed->save();
            }else{
                //in case is an envelope expense
                $feed = new Feed();
                $feed->value = str_replace(array('.', ',', '$', 'R'), '' , $request->value);
                $feed->envelope_id = $request->envelope_id;
                $feed->user_id = Auth::id();
                $feed->type = 4;
                $feed->name = $request->name;
                $feed->valid_at = Carbon::now();
                $feed->save();
            }
//        }catch (Exception $e){
//            return $e->getMessage();
//        }
        return redirect()->back();
    }

    public function undoEarning($id){

        $id = decrypt($id);
        Session::flash('flash_message', 'Você desfez a última aplicação');
        return redirect()->back();
    }

    public function transactions(){
        $feed = Feed::where('feed.user_id', Auth::id())
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope')
            ->orderBy('updated_at','desc')
            ->paginate(30);
        return view('transactions')->withFeed($feed);
    }

    public function envelope($id){
        $id = decrypt($id);
        $feed = Feed::where('user_id', Auth::id())
            ->where('envelope_id', $id)
            ->orderBy('created_at','dsc')
            ->paginate(8);
        return view('envelope')
            ->withFeed($feed)
            ->withBalance(Envelope::envelopeBalance($id))
            ->withEnvelope(Envelope::find($id))
            ->withReport(Envelope::userMonthsEnvelopeReport($id))
            ->withUserBalance(User::updatedBalance(Auth::id()));
    }
}
