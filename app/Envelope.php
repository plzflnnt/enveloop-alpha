<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envelope extends Model
{
    public static function envelopeBalance($id){
        $sum = 0;
        $expenses = \App\Expense::where('envelope_id',$id)
            ->get();
        foreach ($expenses as $expense){
            $sum += $expense->value;
        }
        $earnings = \App\Earning::where('envelope_id',$id)
            ->get();
        foreach ($earnings as $earning){
            $sum += $earning->value;
        }
        return $sum;
    }
}
