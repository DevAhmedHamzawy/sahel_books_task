<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\ExchangeStore;
use App\Models\Item;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$items = ['خيار', 'طماطم' , 'بطاطس' , 'جزر' , 'فلفل' , 'زيتون' , 'لمون' , 'برتقال' , 'موز' , 'عدس' , 'تمر' , 'يوسفى' , 'بلح' , 'بطيخ' , 'برقوق' , 'كوسة' , 'رز' , 'بسلة' , 'مشمش' , 'تفاح'];

        $units = ['كيلو', 'ربع كيلو' , 'نص كيلو' , 'ثلاثة ارباع كيلو' , 'حبة'];


        foreach ($items as $item) {
            Item::updateOrCreate(['name' => $item] , ['name' => $item]);
        }


        foreach ($units as $unit) {
            Unit::updateOrCreate(['name' => $unit] , ['name' => $unit]);
        }

        */

        $exchangeStores = ExchangeStore::inRandomOrder()->pluck('id');
        $items = Item::inRandomOrder()->pluck('id');
        $units = Unit::inRandomOrder()->pluck('id');



        for($j = 0; $j < 1000; $j++){
            for ($i=0; $i < 5 ; $i++) {
                /*if(!ModerateTable::whereExchangeStoreId($exchangeStores[$i])
                                ->whereItemId($items[$i])
                                ->whereUnitId($units[$i])
                                ->exists()) {
                */
                Product::updateOrCreate(
                    [
                    'exchange_store_id' => $exchangeStores[$i],
                    'item_id' => $items[$i],
                    'unit_id' => $units[$i],
                    ],[
                    'exchange_store_id' => $exchangeStores[$i],
                    'item_id' => $items[$i],
                    'unit_id' => $units[$i],
                    'price' => rand(0,1000)
                    ]
                );

                }
            }
        /*}*/


        $discount_sort = ['نسبة' , 'مبلغ'];
        $rand_discount = rand(0,1);


        for($j = 0; $j < 100; $j++){
            Discount::updateOrCreate(
                [
                'sort' => $discount_sort[$rand_discount],
                'amount' => $rand_discount == 0 ? rand(0,100) : rand(100,1000),
                'active' => rand(0,1)
                ],[
                'sort' => $discount_sort[$rand_discount],
                'amount' => $rand_discount == 0 ? rand(0,100) : rand(100,1000),
                'active' => rand(0,1)
                ]
            );
        }
    }
}
