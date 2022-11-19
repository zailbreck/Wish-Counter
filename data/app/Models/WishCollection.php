<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishCollection extends Model
{
    public $timestamps = false;
    protected $table = 'wish_history';
    protected $primaryKey = 'id_wish';
    protected $fillable = [
        "id",
        "gacha_type",
        "time",
        "name",
        "item_type",
        "rank_type"
    ];
}
