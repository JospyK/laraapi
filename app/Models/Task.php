<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom',
        'delai',
        'description',
        'commentaire',
        'user_id'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
