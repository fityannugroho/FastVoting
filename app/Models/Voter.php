<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory, Uuids;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    /**
     * Get the event of the voter.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the voter's ballot.
     */
    public function ballot()
    {
        return $this->hasOne(Ballot::class);
    }

    /**
     * Generate new token and save it to the database.
     *
     * @return bool Returns `true` if the token is generated and saved successfully.
     */
    public function generateToken()
    {
        $this->token = \Illuminate\Support\Str::random(100);
        return $this->save();
    }
}
