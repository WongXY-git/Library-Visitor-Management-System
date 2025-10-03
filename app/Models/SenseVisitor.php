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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Constants for visitor identification
     */
    public const VISITOR_TYPE = '1';
    public const VISITOR_FINANCIAL_HOLD = 'N';
    public const VISITOR_ID_LENGTH = 10;

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
        'type',
        'active',
        'status',
        'remarks',
        'financial_hold', // Included for explicit storage even though it's constant
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'updated_ts' => 'datetime',
        'fr_create_ts' => 'datetime',
        'fr_update_ts' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     * These are visitor-specific constants that are always stored
     * to maintain data consistency and aid in identification.
     *
     * @var array
     */
    protected $attributes = [
        'financial_hold' => self::VISITOR_FINANCIAL_HOLD,
        'type' => self::VISITOR_TYPE,
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Always ensure visitor-specific constants are set
        static::creating(function ($visitor) {
            $visitor->financial_hold = self::VISITOR_FINANCIAL_HOLD;
            $visitor->type = self::VISITOR_TYPE;
        });

        static::updating(function ($visitor) {
            $visitor->financial_hold = self::VISITOR_FINANCIAL_HOLD;
            $visitor->type = self::VISITOR_TYPE;
        });
    }

    /**
     * Validation rules for visitor data
     *
     * @return array
     */
    public static function validationRules(): array
    {
        return [
            'unique_id' => ['nullable', 'string', 'size:' . self::VISITOR_ID_LENGTH, 'regex:/^[0-9]{' . self::VISITOR_ID_LENGTH . '}$/'],
            'card_no' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Scope a query to only include records that match visitor criteria.
     * This is used to identify visitor records when pulling from the external system.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisitorIdentifiers($query)
    {
        return $query->where('type', self::VISITOR_TYPE)
                    ->where('financial_hold', self::VISITOR_FINANCIAL_HOLD)
                    ->whereRaw('LENGTH(unique_id) = ?', [self::VISITOR_ID_LENGTH])
                    ->whereRaw('unique_id REGEXP ?', ['^[0-9]{' . self::VISITOR_ID_LENGTH . '}$']);
    }

    /**
     * Check if a record matches visitor identification criteria
     *
     * @return bool
     */
    public function isValidVisitorRecord(): bool
    {
        return $this->type === self::VISITOR_TYPE &&
               $this->financial_hold === self::VISITOR_FINANCIAL_HOLD &&
               $this->unique_id !== null &&
               strlen($this->unique_id) === self::VISITOR_ID_LENGTH &&
               preg_match('/^[0-9]{' . self::VISITOR_ID_LENGTH . '}$/', $this->unique_id);
    }

    /**
     * Format remarks for display, ensuring non-null value
     *
     * @return string
     */
    public function getFormattedRemarks(): string
    {
        return $this->remarks ?? 'No remarks';
    }

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