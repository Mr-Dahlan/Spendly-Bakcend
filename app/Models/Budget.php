<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';
    protected $primaryKey = 'budget_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'amount_limit',
        'period',
        'start_date',
    ];

    protected $casts = [
        'amount_limit' => 'decimal:2',
        'start_date'   => 'date',
        'period'       => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }
}