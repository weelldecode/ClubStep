<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    //
    protected $fillable = ["name", "slug", "description", "parent_id"];

    public function items()
    {
        return $this->belongsToMany(Item::class, "items_categories");
    }
    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            "item_collection",
            "parent_id", // FK da category
            "collection_id", // FK do collection
        )->wherePivot("type", "category");
    }
    public function featuredItem()
    {
        return $this->belongsToMany(Item::class, "items_categories")
            ->latest() // baseado em created_at do item
            ->limit(1);
    }

    public function childrenRecursive()
    {
        return $this->children()->with("childrenRecursive");
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(Category::class, "parent_id");
    }
}
