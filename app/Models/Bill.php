<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Bill
 *
 * @property int $id
 * @property int $room_assignment_id
 * @property string $invoice_number
 * @property string $billing_period_start
 * @property string $billing_period_end
 * @property float $amount
 * @property float $utilities
 * @property float $other_charges
 * @property string $due_date
 * @property string $status
 * @property string|null $payment_date
 * @property string|null $payment_method
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RoomAssignment $roomAssignment
 * @property-read float $total_amount
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillingPeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillingPeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereOtherCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereRoomAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUtilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill overdue()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill forCurrentMonth()
 * @method static \Database\Factories\BillFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Bill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'room_assignment_id',
        'invoice_number',
        'billing_period_start',
        'billing_period_end',
        'amount',
        'utilities',
        'other_charges',
        'due_date',
        'status',
        'payment_date',
        'payment_method',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
        'amount' => 'decimal:2',
        'utilities' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
        'room_assignment_id' => 'integer',
    ];

    /**
     * Get the room assignment for this bill.
     */
    public function roomAssignment(): BelongsTo
    {
        return $this->belongsTo(RoomAssignment::class);
    }

    /**
     * Get the total amount including utilities and other charges.
     *
     * @return float
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->amount + $this->utilities + $this->other_charges;
    }

    /**
     * Scope a query to only include paid bills.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include pending bills.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include overdue bills.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Scope a query to bills for the current month.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCurrentMonth($query)
    {
        return $query->whereMonth('billing_period_start', now()->month)
                    ->whereYear('billing_period_start', now()->year);
    }
}