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

    private function storeFeed(Request $request, $config)
    {
        $feed = new Feed();

        // Normalizar o valor
        $value = str_replace(['.', ',', '$', 'R'], '', $request->value);
        $feed->value = preg_replace("/[^A-Za-z0-9]/", "", $value);

        // Identifica se é saldo ou envelope
        $isBalance = ($request->envelope_id == 'sd');

        $feed->user_id = Auth::id();
        $feed->envelope_id = $isBalance ? 1 : $request->envelope_id;
        $feed->type = $isBalance ? $config['balance_type'] : $config['envelope_type'];
        $feed->name = $request->name;

        // VALID_AT (opcional)
        $feed->valid_at = $request->valid_at
            ? Carbon::parse($request->valid_at)->startOfDay()
            : Carbon::now();

        $feed->save();

        // Mensagem de sucesso
        if ($isBalance) {
            $message = $config['success_balance']($request, $feed);
        } else {
            $envelope = Envelope::find($request->envelope_id);
            $message = $config['success_envelope']($request, $feed, $envelope);
        }

        Session::flash('flash_message', $message);

        return redirect()->back();
    }


    public function createEarning(Request $request)
    {
        return $this->storeFeed($request, [
            'balance_type' => 1,   // tipo para saldo
            'envelope_type' => 2,  // tipo para envelope
            'success_balance' => function ($request, $feed) {
                return 'Você inseriu ' . $request->value . 
                       ' ao seu saldo não alocado. <a href="' . 
                       url('undo-earning/' . encrypt($feed->id)) . 
                       '" class="alert-link">Desfazer</a>';
            },
            'success_envelope' => function ($request, $feed, $envelope) {
                return 'Você inseriu ' . $request->value . ' ao envelope ' . 
                       $envelope->name . '. <a href="' . 
                       url('undo-earning/' . encrypt($feed->id)) . 
                       '" class="alert-link">Desfazer</a>';
            }
        ]);
    }

    public function createExpense(Request $request)
    {
        return $this->storeFeed($request, [
            'balance_type' => 3,   // tipo para saldo
            'envelope_type' => 4,  // tipo para envelope
            'success_balance' => function ($request, $feed) {
                return 'Você inseriu um gasto de ' . $request->value . 
                       ' ao saldo <a href="' . 
                       url('undo-earning/' . encrypt($feed->id)) . 
                       '" class="alert-link">Desfazer</a>';
            },
            'success_envelope' => function ($request, $feed, $envelope) {
                return 'Você inseriu um gasto de ' . $request->value . 
                       ' ao envelope ' . $envelope->name . '. <a href="' . 
                       url('undo-earning/' . encrypt($feed->id)) . 
                       '" class="alert-link">Desfazer</a>';
            }
        ]);
    }


    public function undoEarning($id){
        $id = decrypt($id);
        try{
            $deleted = Feed::where('id',$id)->where('user_id',Auth::id())->first();
            Feed::where('id',$id)->where('user_id',Auth::id())->delete();
        }catch (Exception $e){

        };
        Session::flash('flash_message', 'Você apagou <b>'.$deleted->name.'</b>.');
        return redirect()->back();
    }

    public function transactions(){
        $feed = Feed::where('feed.user_id', Auth::id())
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope')
            ->orderBy('valid_at','desc')
            ->paginate(30);
        return view('transactions')->withFeed($feed);
    }

    public function envelope($id){
        $id = decrypt($id);
        $feed = Feed::where('user_id', Auth::id())
            ->where('envelope_id', $id)
            ->orderBy('valid_at','dsc')
            ->paginate(8);
        return view('envelope')
            ->withFeed($feed)
            ->withBalance(Envelope::envelopeBalance($id))
            ->withEnvelope(Envelope::find($id))

//            ->withReport(Envelope::userMonthsEnvelopeReport($id))
            ->withReport(Envelope::userMonthly(Carbon::now(),13,$id))

            ->withUserBalance(User::updatedBalance(Auth::id()));
    }

    public function report(){
        return view('report')
            ->withReport(Envelope::userMonthsFullReport());
    }
    public function changelog(){
        return view('report-parts.changelog');
    }
}
