<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "description"];

    // Uma coleção tem muitos itens
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            "item_collection", // tabela pivot
            "collection_id", // FK do collection
            "parent_id", // FK da category
        )->wherePivot("type", "category");
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            "item_collection",
            "collection_id", // FK do collection
            "parent_id", // FK da tag
        )->wherePivot("type", "tag");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
