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

    //recebe um valor int 000000 retorna formatado em string 0 000,00
    public static function formatCurrency($value)
    {
        $value = $value / 100;
        $value = number_format($value, 2, ',', ' ');
        return $value;
    }

    //recebe um valor formatado em string 0 000,00 retorna int 000000
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
//    relatório da página do envelope
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
            ->whereMonth('valid_at', $now->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

//    relatório da home
    public static function userMonthsReport()
    {
        $now = Carbon::now();
        $now->setTimezone('America/Sao_Paulo');

        $dataArray = [];
        //esse mês
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->month)
            ->whereYear('valid_at', $now->year)
            ->get();

        foreach ($feeds as $feed) {
            if ($feed->type == 1) {
                $balanceEarn += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $balanceSpent += $feed->value;
            }
        }

        $historyBalance = 0;
        $historyFeedUntilToday = Feed::where("user_id", Auth::id())
            ->where('valid_at', '<=', $now)
            ->get();
        foreach ($historyFeedUntilToday as $feed) {
            if ($feed->type == 1) {
                $historyBalance += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $historyBalance -= $feed->value;
            }
        }

        $dataArray[] = array(
            "spent" => $balanceSpent,
            "earn" => $balanceEarn,
            "month" => $now->month,
            "historyBalance" => $historyBalance
        );


        //mes passado
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
            ->get();

        foreach ($feeds as $feed) {
            if ($feed->type == 1) {
                $balanceEarn += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $balanceSpent += $feed->value;
            }
        }

        $historyBalance = 0;
        $historyFeedUntilToday = Feed::where("user_id", Auth::id())
            ->where('valid_at', '<=', $now)
            ->get();
        foreach ($historyFeedUntilToday as $feed) {
            if ($feed->type == 1) {
                $historyBalance += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $historyBalance -= $feed->value;
            }
        }

        $dataArray[] = array(
            "spent" => $balanceSpent,
            "earn" => $balanceEarn,
            "month" => $now->month,
            "historyBalance" => $historyBalance,
        );

        //mes retrasado
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
            ->get();

        foreach ($feeds as $feed) {
            if ($feed->type == 1) {
                $balanceEarn += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $balanceSpent += $feed->value;
            }
        }

        $historyBalance = 0;
        $historyFeedUntilToday = Feed::where("user_id", Auth::id())
            ->where('valid_at', '<=', $now)
            ->get();
        foreach ($historyFeedUntilToday as $feed) {
            if ($feed->type == 1) {
                $historyBalance += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $historyBalance -= $feed->value;
            }
        }

        $dataArray[] = array(
            "spent" => $balanceSpent,
            "earn" => $balanceEarn,
            "month" => $now->month,
            "historyBalance" => $historyBalance
        );

        //3 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
            ->get();

        foreach ($feeds as $feed) {
            if ($feed->type == 1) {
                $balanceEarn += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $balanceSpent += $feed->value;
            }
        }

        $historyBalance = 0;
        $historyFeedUntilToday = Feed::where("user_id", Auth::id())
            ->where('valid_at', '<=', $now)
            ->get();
        foreach ($historyFeedUntilToday as $feed) {
            if ($feed->type == 1) {
                $historyBalance += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $historyBalance -= $feed->value;
            }
        }

        $dataArray[] = array(
            "spent" => $balanceSpent,
            "earn" => $balanceEarn,
            "month" => $now->month,
            "historyBalance" => $historyBalance
        );

        //4 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
            ->get();

        foreach ($feeds as $feed) {
            if ($feed->type == 1) {
                $balanceEarn += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $balanceSpent += $feed->value;
            }
        }

        $historyBalance = 0;
        $historyFeedUntilToday = Feed::where("user_id", Auth::id())
            ->where('valid_at', '<=', $now)
            ->get();
        foreach ($historyFeedUntilToday as $feed) {
            if ($feed->type == 1) {
                $historyBalance += $feed->value;
            } elseif ($feed->type == 4 || $feed->type == 3) {
                $historyBalance -= $feed->value;
            }
        }

        $dataArray[] = array(
            "spent" => $balanceSpent,
            "earn" => $balanceEarn,
            "month" => $now->month,
            "historyBalance" => $historyBalance
        );
        return array_reverse($dataArray);

    }

//    relatório de um ano todo
    public static function userMonthsFullReport()
    {
        $now = Carbon::now();
        $now->setTimezone('America/Sao_Paulo');

        $dataArray = [];
        //esse mês
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth(4)->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //5 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //6 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //7 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //8 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //9 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //10 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

        //11 meses atras
        $balanceSpent = 0;
        $balanceEarn = 0;
        $feeds = Feed::where("user_id", Auth::id())
            ->whereMonth('valid_at', $now->subMonth()->month)
            ->whereYear('valid_at', $now->year)
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

    public static function userMonthly($fromDate, $toDate, $envelopeId){
//        fromDate = data de início
//        toDate = numero de meses para exibir
//        envelopeId = id do envelope para filtrar, se -1, mostrar todos

        $envelope = Envelope::where("id", $envelopeId)->first();
        $fromDate->setTimezone('America/Sao_Paulo');
        $dataArray = [];

        while($toDate != 0 ){
            $balanceSpent = 0;
            $balanceEarn = 0;
            $balanceProgression = 0;
            $endMonth = clone $fromDate;
            $endMonth->addMonth()->firstOfMonth();

//            se tudo no feed
            if ($envelopeId == -1){
                $feeds = Feed::where("user_id", Auth::id())
                    ->whereMonth('valid_at', $fromDate->month)
                    ->whereYear('valid_at', $fromDate->year)
                    ->get();

                $completeFeed = Feed::where("user_id", Auth::id())
                    ->where('valid_at', '<=', $endMonth)
                    ->get();

                foreach ($feeds as $feed) {
                    if ($feed->type == 1) {
                        $balanceEarn += $feed->value;
                    } elseif ($feed->type == 4 || $feed->type == 3) {
                        $balanceSpent += $feed->value;
                    }
                }
                foreach ($completeFeed as $feed) {
                    if ($feed->type == 1) {
                        $balanceProgression += $feed->value;
                    } elseif ($feed->type == 4 || $feed->type == 3) {
                        $balanceProgression -= $feed->value;
                    }
                }

            }else{
//                ou envelope específico
                $feeds = Feed::where("envelope_id", $envelope->id)
                    ->whereMonth('valid_at', $fromDate->month)
                    ->whereYear('valid_at', $fromDate->year)
                    ->get();

                $completeFeed = Feed::where("envelope_id", $envelope->id)
                    ->where('valid_at', '<=', $fromDate)
                    ->get();

                foreach ($feeds as $feed) {
                    if ($feed->type == 2) {
                        $balanceEarn += $feed->value;
                    } elseif ($feed->type == 4) {
                        $balanceSpent += $feed->value;
                    }
                }
                foreach ($completeFeed as $feed) {
                    if ($feed->type == 2) {
                        $balanceProgression += $feed->value;
                    } elseif ($feed->type == 4) {
                        $balanceProgression -= $feed->value;
                    }
                }

            }

            $dataArray[] = array(
                "spent" => $balanceSpent,
                "earn" => $balanceEarn,
                "month" => $fromDate->month,
                "balanceProgression" => $balanceProgression
            );
            $fromDate->subMonth();
            $toDate--;
        }
        return array_reverse($dataArray);
    }


//    Todo: fazer aqui uma posição do saldo no mês, ver quanto do saldo total tinha no fim do mês
    public static function userMonthsReportBalanceSoFar()
    {
        $array = [];

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
