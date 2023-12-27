<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistSubitem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'completed'];

    public function checklistItem()
    {
        return $this->belongsTo(Checklist::class);
    }
}
