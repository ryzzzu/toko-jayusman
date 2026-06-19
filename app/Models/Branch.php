<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'city',
        'address',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}