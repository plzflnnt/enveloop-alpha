<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Envelope extends Model
{
    //recebe o id do envelope e retorna o saldo do envelope em uma string para view
    public static function envelopeBalance($id)
    {
        $sum = 0;
        $expenses = \App\Feed::where('envelope_id', $id)
            ->where('type', 4)
            ->get();
        foreach ($expenses as $expense) {
            $sum -= $expense->value;
        }
        $earnings = \App\Feed::where('envelope_id', $id)
            ->where('type', 2)
            ->get();
        foreach ($earnings as $earning) {
            $sum += $earning->value;
        }
        $sum = $sum / 100;
        $sum = number_format($sum, 2, ',', ' ');
        return $sum;
    }

    //FUNÇÃO COMPLEMENTAR DE envelopeEarnings() - recebe o id do envelope e retorna soma em int dos ganhos do envelope
    public static function envelopeEarnings($id)
    {
        $sum = 0;
//        $expenses = \App\Feed::where('envelope_id',$id)
//            ->where('type',4)
//            ->get();
//        foreach ($expenses as $expense){
//            $sum -= $expense->value;
//        }
        $earnings = \App\Feed::where('envelope_id', $id)
            ->where('type', 2)
            ->get();
        foreach ($earnings as $earning) {
            $sum += $earning->value;
        }
        return $sum;
    }

    /*
     * Rerotna um array de envelopes do usuário logado com:
     *   -todos os dados do envelope
     *   -saldo do envelope até o momento  e.g. $x->balance
     *   -investimento até o momento e.g. $x->expenses
     */
    public static function envelopesExpense()
    {

        $envelopes = Envelope::where('user_id', Auth::id())
            ->get();
        $arrayOfEnvelopes = [];
        foreach ($envelopes as $envelope) {
            $expenses = Feed::whereIn('type', [3, 4])
                ->where('envelope_id', $envelope->id)
                ->get();
            $sum = 0;
            foreach ($expenses as $expense) {
                $sum += $expense->value;
            }
            $envelope->expenses = $sum;
            $envelope->balance = Envelope::envelopeEarnings($envelope->id) - $sum;
            $arrayOfEnvelopes[] = $envelope;
        }
        return $arrayOfEnvelopes;
    }

    //recebe um valor inteiro de dinheiro e retorna no formatado em string para view
    public static function formatCurrency($value)
    {
        $value = $value / 100;
        $value = number_format($value, 2, ',', ' ');
        return $value;
    }

    //recebe um valor em string para view de dinheiro e retorna no formatado inteiro
    public static function formatNumber($value)
    {
        $value = str_replace(' ', '', $value);
        $value = str_replace(',', '', $value);
        $value = intval($value);
        return $value;
    }

    /*
     * Função que retorna o balanço mês a mês de todos os evelopes do usuário em array
     * [report -> month, spent, earned, name, envelope_id]
     */
    public static function userMonthsEnvelopeReport($id)
    {
        $envelope = Envelope::where("id", $id)->first();

            $now = Carbon::now();
            $now->setTimezone('America/Sao_Paulo');

            $dataArray = [];
            //esse mês
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("envelope_id", $envelope->id)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 2) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month,
            );


            //mes passado
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("envelope_id", $envelope->id)
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 2) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4) {
                    $balanceSpent += $feed->value;
                }

            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //mes retrasado
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("envelope_id", $envelope->id)
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 2) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //3 meses atras
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("envelope_id", $envelope->id)
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 2) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //4 meses atras
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("envelope_id", $envelope->id)
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 2) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

        return array_reverse($dataArray);
    }

    public static function userMonthsReport()
    {
            $now = Carbon::now();
            $now->setTimezone('America/Sao_Paulo');

            $dataArray = [];
            //esse mês
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("user_id", Auth::id())
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 1) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4 || $feed->type == 3) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month,
            );


            //mes passado
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("user_id", Auth::id())
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 1) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4 || $feed->type == 3) {
                    $balanceSpent += $feed->value;
                }

            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //mes retrasado
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("user_id", Auth::id())
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 1) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4 || $feed->type == 3) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //3 meses atras
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("user_id", Auth::id())
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 1) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4 || $feed->type == 3) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );

            //4 meses atras
            $balanceSpent = 0;
            $balanceEarn = 0;
            $feeds = Feed::where("user_id", Auth::id())
                ->whereMonth('created_at', $now->subMonth()->month)
                ->whereYear('created_at', $now->year)
                ->get();

            foreach ($feeds as $feed) {
                if ($feed->type == 1) {
                    $balanceEarn += $feed->value;
                } elseif ($feed->type == 4 || $feed->type == 3) {
                    $balanceSpent += $feed->value;
                }
            }
            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $now->month
            );
        return array_reverse($dataArray);

    }
}
/*
    *  Type of envelopes:
    *
    *  1- balance earning
    *  2- earning on envelope
    *  3- balance expense
    *  4- expense on envelope
    *
    */
