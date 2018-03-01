<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function updatedBalance($id){
        $sum = 0;
        $expenses = \App\ExpenseBalance::where('user_id',$id)
            ->get();
        foreach ($expenses as $expense){
            $sum -= $expense->value;
        }
        $earnings = \App\EarningBalance::where('user_id',$id)
            ->get();
        foreach ($earnings as $earning){
            $sum += $earning->value;
        }
        $envelopes = Envelope::where('user_id',$id)->get();
        $sumEnvelopesBalance = 0;
        foreach ($envelopes as $envelope){
            $envelopeEarnings = Earning::where('envelope_id', $envelope->id)->get();
            foreach ($envelopeEarnings as $envelopeEarning){
                $sumEnvelopesBalance += $envelopeEarning->value;
            }
        }
        $sum -= $sumEnvelopesBalance;
        if($sum == 0){
            return '0';
        }
        $sum = $sum/100;
        $sum = number_format($sum, 2, ',', ' ');
        return $sum;
    }
}
