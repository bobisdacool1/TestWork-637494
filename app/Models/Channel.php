<?php

namespace App\Models;

use Database\Factories\ChannelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function newFactory()
    {
        return ChannelFactory::new();
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withPivot(['description']);
    }
}
