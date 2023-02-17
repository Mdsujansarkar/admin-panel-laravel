<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as OriginalRole;
use Illuminate\Database\Eloquent\Model;

class Role extends OriginalRole
{
    use HasFactory;
    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at'
    ];
}
