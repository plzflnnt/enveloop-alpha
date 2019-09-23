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

    //recebe o id do usuário logado e retorna uma string com o saldo geral em formato para view
    public static function updatedBalance($id){
        $sum = 0;
        $expenses = \App\Feed::where('user_id',$id)
            ->where('type',3)
            ->where('user_id',$id)
            ->get();
        foreach ($expenses as $expense){
            $sum -= $expense->value;
        }
        $earnings = \App\Feed::where('user_id',$id)
            ->where('type',1)
            ->where('user_id',$id)
            ->get();
        foreach ($earnings as $earning){
//            dd($earning->value);
            $sum += $earning->value;
        }
        $envelopes = Envelope::where('user_id',$id)->get();
        $sumEnvelopesBalance = 0;
        foreach ($envelopes as $envelope){
            $envelopeEarnings = Feed::where('envelope_id', $envelope->id)
                ->where('type',2)
                ->get();
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

    public static function grandBalance($balance,$envelopes){
        $totalSum = Envelope::formatNumber($balance);

        foreach ($envelopes as $envelope) {
            $x = Envelope::formatNumber($envelope->balance);
            $totalSum += $x;
        }
        return Envelope::formatCurrency($totalSum);
    }
}
