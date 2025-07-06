<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'profile';
    protected $primaryKey = 'id_profile';
    protected $fillable = [
        'id_user',
        'phone',
        'address',
        'gender',
        'birthdate',
        'image',
        'position',
    ];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
