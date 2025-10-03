<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class SenseVisitor
 * 
 * @package App\Models
 * 
 * This model represents a visitor in the library management system.
 * It handles all visitor-related data and provides methods for validation
 * and data formatting.
 * 
 * Key Features:
 * - Visitor identification through unique ID and card number
 * - Photo management
 * - Remarks tracking
 * - Name formatting
 * - Activity status tracking
 * 
 * @property string $sense_id System-generated identifier
 * @property string $unique_id 10-digit unique identifier
 * @property string $card_no Library card number
 * @property string $name Visitor's full name
 * @property string $active Activity status (Y/N)
 * @property string $status Current status
 * @property string|null $remarks Additional notes about the visitor
 * @property string|null $photo_path Path to visitor's photo in storage
 * @property \Carbon\Carbon $updated_ts Last update timestamp
 * @property \Carbon\Carbon $fr_create_ts Face recognition creation timestamp
 * @property \Carbon\Carbon $fr_update_ts Face recognition update timestamp
 */
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
        'active',
        'status',
        'remarks'
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
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Validation rules for visitor data
     *
     * @return array
     */
    /**
     * Get validation rules for visitor data
     * 
     * Defines the validation rules for visitor data fields:
     * - unique_id: Must be exactly 10 digits if provided
     * - card_no: Required, string with maximum 255 characters
     * - name: Required, string with maximum 255 characters
     * - remarks: Optional, string with maximum 255 characters
     * 
     * @return array Array of Laravel validation rules
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
    /**
     * Scope query to only include records with valid visitor identifiers
     * 
     * This scope filters records to ensure they have properly formatted unique IDs:
     * - Must be exactly VISITOR_ID_LENGTH digits
     * - Must contain only numbers
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisitorIdentifiers($query)
    {
        return $query->whereRaw('LENGTH(unique_id) = ?', [self::VISITOR_ID_LENGTH])
                    ->whereRaw('unique_id REGEXP ?', ['^[0-9]{' . self::VISITOR_ID_LENGTH . '}$']);
    }

    /**
     * Check if a record matches visitor identification criteria
     *
     * @return bool
     */
    /**
     * Check if a record has a valid visitor ID format
     * 
     * Validates that the visitor record has:
     * - A non-null unique_id
     * - A unique_id of exactly VISITOR_ID_LENGTH digits
     * - A unique_id containing only numbers
     * 
     * @return bool True if the visitor ID format is valid
     */
    public function isValidVisitorRecord(): bool
    {
        return $this->unique_id !== null &&
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
     * Get whether the visitor is active.
     * 
     * Checks if the visitor's account is currently active in the system.
     * Active visitors have full access to library services.
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