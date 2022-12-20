<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $fillable =[]; or
    protected $guarded = []; //to mass assign

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // the function name- user should be singular has it has many notes
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
