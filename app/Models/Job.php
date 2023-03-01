<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'instrument_list',
        'payment',
        'extra_info',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * Get the Users for the Job.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_user')->withPivot('status');
    }

    /**
     * Get the Gig who owns the Job.
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class);
    }

    public function jobHasBeenBooked($job)
    {
        return ($job->users()->wherePivot('status', 'Booked')->count() > 0);
    }
}