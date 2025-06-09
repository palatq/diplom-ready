<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
     use HasFactory;

    // Поля, которые можно массово назначать
    protected $fillable = [
        'name', 
        'email',
        'message'
    ];

    // Дополнительно можно добавить:
    // - Каст дат
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // - Скрытые поля (не будут отображаться в JSON)
    protected $hidden = [];
}
