<?php

namespace App\Models;

use Database\Factories\SubscriberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function newFactory()
    {
        return SubscriberFactory::new();
    }

    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class);
    }
}
