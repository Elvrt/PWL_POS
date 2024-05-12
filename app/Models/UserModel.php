<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
    use HasFactory;

    protected $table = 'm_user'; // mendefinisikan nama tabel yang digunakna oleh model ini
    public $timestamps = false;
    protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['user_id','level_id', 'username', 'nama', 'password'];

    
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
