<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SenseVisitor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sense_visitor_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'sense_id',
        'unique_id',
        'card_no',
        'name',
        'financial_hold',
        'type',
        'active',
        'created_by',
        'updated_by',
        'status',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_ts' => 'datetime',
        'updated_ts' => 'datetime',
        'last_update_ts' => 'datetime',
        'f_update_ts' => 'datetime',
        'fr_update_ts' => 'datetime',
    ];

    /**
     * Get whether the visitor has a financial hold.
     */
    public function isOnFinancialHold(): bool
    {
        return $this->financial_hold === 'Y';
    }

    /**
     * Get whether the visitor is active.
     */
    public function isActive(): bool
    {
        return $this->active === 'Y';
    }

    /**
     * Create a custom accessor for formatted name
     */
    protected function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn () => ucwords(strtolower($this->name))
        );
    }
}