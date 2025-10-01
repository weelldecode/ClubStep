<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    //
    protected $fillable = ["name", "slug", "description", "type", "parent_id"];

    public function parent()
    {
        return $this->belongsTo(Tag::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(Tag::class, "parent_id");
    }

    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            "item_collection",
            "parent_id", // FK da tag
            "collection_id", // FK do collection
        )->wherePivot("type", "tag");
    }
    public function items()
    {
        return $this->belongsToMany(
            Item::class,
            "items_tag",
            "tag_id",
            "item_id",
        );
    }
}
