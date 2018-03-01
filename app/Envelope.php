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
            $sum -= $expense->value;
        }
        $earnings = \App\Earning::where('envelope_id',$id)
            ->get();
        foreach ($earnings as $earning){
            $sum += $earning->value;
        }
        $sum = $sum/100;
        $sum = number_format($sum, 2, ',', ' ');
        return $sum;
    }

    public static function formatCurrency($value){
        $value = $value/100;
        $value = number_format($value, 2, ',', ' ');
        return $value;
    }
}
