<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model {
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Vote::class)->where('type', 'like');
    }

    public function hates() {
        return $this->hasMany(Vote::class)->where('type', 'hate');
    }

    public function hasUserLikeVote($id) {
        return in_array($id, $this->likes()->pluck('user_id')->all());
    }

    public function hasUserHatesVote($id) {
        return in_array($id, $this->hates()->pluck('user_id')->all());
    }
}
