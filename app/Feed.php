<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feed';

    public static function shortHistory($envelopeId){

        $entryArray = Feed::where('feed.envelope_id', $envelopeId)
            ->where('feed.created_at', '>', Carbon::now()->subDays(30))
            ->join('envelopes', 'feed.envelope_id', '=', 'envelopes.id')
            ->select('feed.*', 'envelopes.name as envelope')
            ->orderBy('updated_at','desc')
            ->get();
        return $entryArray;
    }

    public static function shortHistoryExpenses($envelopeId){
        $entryArray = Feed::where('envelope_id', $envelopeId)
            ->where('created_at', '>', Carbon::now()->subDays(30))
            ->where('type', 4)
            ->get();
        $sum = 0;
        foreach ($entryArray as $expense){
            $sum += $expense->value;
        }
        return $sum;
    }
}
