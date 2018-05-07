<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Envelope extends Model
{
    public static function envelopeBalance($id){
        $sum = 0;
        $expenses = \App\Feed::where('envelope_id',$id)
            ->where('type',4)
            ->get();
        foreach ($expenses as $expense){
            $sum -= $expense->value;
        }
        $earnings = \App\Feed::where('envelope_id',$id)
            ->where('type',2)
            ->get();
        foreach ($earnings as $earning){
            $sum += $earning->value;
        }
        $sum = $sum/100;
        $sum = number_format($sum, 2, ',', ' ');
        return $sum;
    }

    public static function envelopeEarnings($id){
        $sum = 0;
//        $expenses = \App\Feed::where('envelope_id',$id)
//            ->where('type',4)
//            ->get();
//        foreach ($expenses as $expense){
//            $sum -= $expense->value;
//        }
        $earnings = \App\Feed::where('envelope_id',$id)
            ->where('type',2)
            ->get();
        foreach ($earnings as $earning){
            $sum += $earning->value;
        }
        return $sum;
    }

    public static function envelopesExpense(){

        $envelopes = Envelope::where('user_id',Auth::id())
            ->get();
        $arrayOfEnvelopes = [];
        foreach ($envelopes as $envelope){
            $expenses = Feed::whereIn('type',[3,4])
            ->where('envelope_id', $envelope->id)
            ->get();
            $sum = 0;
            foreach ($expenses as $expense){
                $sum += $expense->value;
            }
            $envelope->expenses = $sum;
            $envelope->balance = Envelope::envelopeEarnings($envelope->id);
            $arrayOfEnvelopes[] = $envelope;
        }
        return $arrayOfEnvelopes;
    }

    public static function formatCurrency($value){
        $value = $value/100;
        $value = number_format($value, 2, ',', ' ');
        return $value;
    }
}
