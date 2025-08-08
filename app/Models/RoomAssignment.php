<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\RoomAssignment
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $room_id
 * @property string $check_in_date
 * @property string|null $check_out_date
 * @property float $monthly_rate
 * @property bool $is_active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @property-read \App\Models\Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bill> $bills
 * @property-read int|null $bills_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereCheckInDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereCheckOutDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereMonthlyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomAssignment active()
 * @method static \Database\Factories\RoomAssignmentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RoomAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'monthly_rate',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'monthly_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'tenant_id' => 'integer',
        'room_id' => 'integer',
    ];

    /**
     * Get the tenant for this assignment.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the room for this assignment.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get all bills for this assignment.
     */
    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Scope a query to only include active assignments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}