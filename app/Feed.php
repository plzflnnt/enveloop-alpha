<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feed';

//    retorna os ultimos 5 transações ou transações dos ultimos 30 dias
    public static function shortHistory($envelopeId){

        $entryArray = Feed::where('feed.envelope_id', $envelopeId)
            ->where('feed.valid_at', '>', Carbon::now()->subDays(30))
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope')
            ->orderBy('valid_at','desc')
            ->limit(3)
            ->get();
        return $entryArray;
    }

    public static function shortHistoryExpenses($envelopeId){
        $entryArray = Feed::where('envelope_id', $envelopeId)
            ->where('valid_at', '>', Carbon::now()->subDays(30))
            ->where('type', 4)
            ->get();
        $sum = 0;
        foreach ($entryArray as $expense){
            $sum += $expense->value;
        }
        return $sum;
    }
}
