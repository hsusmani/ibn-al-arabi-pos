<?php

namespace App\Imports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Carbon;
use App\Models\Product;

use Maatwebsite\Excel\Concerns\Importable;

class OrdersImport implements WithHeadingRow, ToCollection
{
    use Importable;
    use WithFileUploads;

    public $orders = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row)
        {
                $sameId = array_filter($this->orders, function($order) use($row) {
                    if($row['id'] == $order['id']) return true;
                });
                $lastIndex = count($this->orders) - 1;
                if($sameId) {
                    $product = Product::where('name', $row['name'])->get();
                    array_push($this->orders[$lastIndex]['items'], [
                        "id" => $product->first()->id,
                        "name" => $product->first()->name,
                        "qnty" => (int)$row['qnty'],
                        "value" => [
                            "discount" => (float)$row['discount_percent'] * 100,
                            "original_price" => [
                                "egp" => $product->first()->price['egp'] * (int)$row['qnty'],
                                "usd" => $product->first()->price['usd'] * (int)$row['qnty'],
                                "aed" => $product->first()->price['aed'] * (int)$row['qnty'],
                            ],
                            "discounted_price" => [
                                "egp" => ($product->first()->price['egp'] - ((float)$row['discount_percent'] * $product->first()->price['egp'])) * (int)$row['qnty'],
                                "usd" => ($product->first()->price['usd'] - ((float)$row['discount_percent'] * $product->first()->price['usd'])) * (int)$row['qnty'],
                                "aed" => ($product->first()->price['aed'] - ((float)$row['discount_percent'] * $product->first()->price['aed'])) * (int)$row['qnty'],
                            ],
                        ],
                    ]);

                } else {
                    $product = Product::where('name', $row['name'])->get();

                    $this->orders[] = [
                        'id' => $row['id'],
                        'date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']))->toDateTimeString(),
                        'items' => [
                            0 => [

                                "id" => $product->first()->id,
                                "name" => $product->first()->name,
                                "qnty" => (int)$row['qnty'],
                                "value" => [
                                    "discount" => (float)$row['discount_percent'] * 100,
                                    "original_price" => [
                                        "egp" => $product->first()->price['egp'] * (int)$row['qnty'],
                                        "usd" => $product->first()->price['usd'] * (int)$row['qnty'],
                                        "aed" => $product->first()->price['aed'] * (int)$row['qnty'],
                                    ],
                                    "discounted_price" => [
                                        "egp" => ($product->first()->price['egp'] - ((float)$row['discount_percent'] * $product->first()->price['egp'])) * (int)$row['qnty'],
                                        "usd" => ($product->first()->price['usd'] - ((float)$row['discount_percent'] * $product->first()->price['usd'])) * (int)$row['qnty'],
                                        "aed" => ($product->first()->price['aed'] - ((float)$row['discount_percent'] * $product->first()->price['aed'])) * (int)$row['qnty'],

                                    ],
                                ],
                            ],
                        ],
                        'customer_name' => $row['customer_name'],
                        'customer_phone' => $row['customer_phone'],
                    ];
                }
        }
    }
}
