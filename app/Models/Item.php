<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        "name",
        "description",
        "price",
        "file_url",
        "imagem_path",
        "type",
        "features",
        "is_premium",
    ];

    protected $casts = [
        "images" => "array",
        "features" => "array",
    ];

    // Um item pertence a uma coleção
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            "item_collection", // pivot
            "parent_id", // FK que aponta para Category
            "collection_id", // FK que aponta para Item? → se não existe, precisa ajustar
        )->wherePivot("type", "category");
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            "items_tag",
            "item_id", // FK do item na pivot
            "tag_id", // FK da tag na pivot
        );
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, "favorites")->withTimestamps();
    }

    public function is_premium(): string
    {
        return $this->is_premium ? "Exclusivo" : "Gratuito";
    }
}
