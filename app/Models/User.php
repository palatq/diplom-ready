<?php

namespace App\Models;
use App\Models\Message;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'login',
        'password',
        'seller',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'seller' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->login === 'admin'; // Основное исправление, которое нужно сохранить
    }

    // Оставьте остальные методы без изменений
    public function sellerApplications()
    {
        return $this->hasMany(SellerApplication::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function sentMessages()
{
    return $this->hasMany(ProductMessage::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(ProductMessage::class, 'receiver_id');
}
    
}