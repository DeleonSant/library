<?php

namespace App\Models;

use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function checkout(User $user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now()
        ]);
    }

    public function checkin(User $user)
    {
        $reservation =  $this->reservations()
            ->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (!$reservation) {
            throw new \Exception();
        }

        $reservation->update([
            'checked_in_at' => now()
        ]);
    }

    public function getPathAttribute()
    {
        return '/books/' . $this->id ;
    }

    public function setAuthorAttribute($authorName)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $authorName
        ])->id;
    }
}
