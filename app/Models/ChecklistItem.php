<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'completed'];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function subItems()
    {
        return $this->hasMany(ChecklistSubitem::class);
    }
}
