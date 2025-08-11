<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{

    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'paid_amount',
        'change_amount',
        'due_amount',
        'status',
    ];

    public function user():BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function detail() :HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }


    
}
