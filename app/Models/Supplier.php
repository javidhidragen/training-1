<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ACTIVE = 'Active'; 
    const INACTIVE = 'Inactive';
    const BLOCKED = 'Blocked';

    public static function generateSupplierNo()
    {
        $prefix = 'SUP';
        $lastSupplier = self::orderBy('id', 'desc')->first();
        $number = $lastSupplier ? (int)substr($lastSupplier->supplier_no, 3) + 1 : 1;
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
