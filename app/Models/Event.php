<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = ['name', 'user_id', 'start_date','end_date' ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'user_id' => 'integer'
    ];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
