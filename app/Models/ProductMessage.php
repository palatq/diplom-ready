<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMessage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sender_id', 'receiver_id', 'message', 'is_read'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function replies()
    {
        return $this->hasMany(ProductMessage::class, 'parent_id');
    }
}