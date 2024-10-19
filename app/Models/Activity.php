<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'guide_id',
        'name',
        'description',
        'start_time',
        'price',
        'photo'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
