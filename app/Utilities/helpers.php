<?php
use App\Models\Product;
use App\Models\Location;

$prices = ['egp', 'usd', 'aed', 'mad'];

function pricePerCurrency($price) {
    foreach ($price as $key => $item) {
        if(strtoupper($key) == session('preferred_currency')) {
            return $value = $item;
        }
    }
}

function generateSKU() {
    if(Product::count() == 0) {
        return 1001;
    } else {
        return (int)Product::latest('sku')->pluck('sku')->first() + 1;
    }
}

function getPrices($amount) {
    foreach ($prices as $key => $price) {
        dd($price);
    }
}

function isAdmin() {
    if(auth()->user()->hasRole('Super') || auth()->user()->hasRole('Admin')) {
        return true;
    } else  {
        return false;
    }
}

function getUserLocationId() {
    $locationId = NULL;
    foreach(Location::get() as $location) {
        foreach($location['users'] as $user) {
            if(auth()->user()->id == (int)$user) {
                $locationId = $location->id;
            }
        }
    }
    return $locationId;
}
