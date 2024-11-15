<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function discountAmount($discount_sort)
    {
        $arr = ['نسبة','مبلغ'];
        $discountAmounts = Discount::whereSort($arr[$discount_sort])->whereActive(1)->get();

        return $discountAmounts;
    }
}
