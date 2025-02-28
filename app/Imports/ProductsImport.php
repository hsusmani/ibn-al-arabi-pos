<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Maatwebsite\Excel\Concerns\Importable;


class ProductsImport implements WithHeadingRow, ToCollection
{

    use Importable;
    use WithFileUploads;

    public function collection(Collection $rows)
    {

        $products = [];
        foreach($rows as $row) {
            $products[] = [
                'name' => $row['name'],
                'price_egp' => $row['price_egp'],
                'price_usd' => $row['price_usd'],
                'price_aed' => $row['price_aed'],
                'price_mad' => $row['price_mad'],
                'cost' => $row['cost'],
                'author' => $row['author'],
                'edition_no' => $row['edition_no'],
                'weight' => $row['weight'],
                'dimensions' => $row['dimensions'],
                'no_of_pages' => $row['no_of_pages'],
                'cover_type' => $row['cover_type'],
                'isbn' => $row['isbn'],
                'qnty' => $row['qnty'],
            ];

        }
    }
}
