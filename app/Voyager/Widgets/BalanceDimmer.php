<?php

namespace App\Voyager\Widgets;

use App\Http\Controllers\TopUpController;
use App\TopUpWithdrawal;
use App\WithdrawalBankAccount;
use App\WithdrawalBankCard;
use App\WithdrawalStatus;
use App\WithdrawalYandex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class BalanceDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = TopUpController::getBalance();

        $string = 'Баланс';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-credit-cards',
            'title'  => "{$count} руб.",
            'text'   => "На вашем счету {$count} руб.",
            'button' => [
                'text' => 'Пополнить',
                'link' => "//b2b.qiwi.com/payin/",
            ],
            'image' => ('images/voyager/widgets/04.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
