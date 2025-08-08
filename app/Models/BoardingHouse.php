<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BoardingHouse
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $number_of_rooms
 * @property string $owner
 * @property string $contact
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $rooms
 * @property-read int|null $rooms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $occupiedRooms
 * @property-read int|null $occupied_rooms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $vacantRooms
 * @property-read int|null $vacant_rooms_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereNumberOfRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardingHouse whereUpdatedAt($value)
 * @method static \Database\Factories\BoardingHouseFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class BoardingHouse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'address',
        'number_of_rooms',
        'owner',
        'contact',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'number_of_rooms' => 'integer',
    ];

    /**
     * Get all rooms belonging to this boarding house.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get occupied rooms for this boarding house.
     */
    public function occupiedRooms(): HasMany
    {
        return $this->hasMany(Room::class)->where('status', 'occupied');
    }

    /**
     * Get vacant rooms for this boarding house.
     */
    public function vacantRooms(): HasMany
    {
        return $this->hasMany(Room::class)->where('status', 'vacant');
    }
}