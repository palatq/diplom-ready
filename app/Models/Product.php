<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Поля, доступные для массового заполнения
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category_id',
        'user_id',
        'moderation_status',
        'discount', 
        'discounted_price'
    ];
    protected $casts = [
    'discount' => 'integer',
    'discounted_price' => 'float'
    ];
    const MODERATION_PENDING = 0;
const MODERATION_APPROVED = 1;
const MODERATION_REJECTED = 2;
    /**
     * Связь с категорией (один товар принадлежит одной категории)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с пользователем (один товар принадлежит одному пользователю)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor для получения полного URL изображения
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Форматирование цены (добавляем знак валюты)
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ₽';
    }
    public function scopeApproved($query)
    {
    return $query->where('moderation_status', self::MODERATION_APPROVED);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function getAvgRatingAttribute()
    {
        return (float) $this->reviews()->avg('rating') ?? 0;
    }
    
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
    public function messages()
    {
    return $this->hasMany(ProductMessage::class);
    }
    public function getFormattedDiscountedPriceAttribute()
    {
    return number_format($this->discounted_price, 0, '.', ' ') . ' ₽';
    }
}