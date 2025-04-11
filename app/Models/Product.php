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
        'user_id'
    ];

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
}