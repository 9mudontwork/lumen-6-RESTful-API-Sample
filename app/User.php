<?php
namespace App;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'user';

    // fillable ให้แสดงออกมาใน api ได้
    protected $fillable = [
        'username',
        'email',
        'password',
        'userimage',
    ];

    // hidden ซ่อนไม่ให้แสดงใน api
    protected $hidden = [
        'password',
    ];

    public $timestamps = false;

    public function todo()
    {
        return $this->hasMany( 'App\Todo', 'user_id' );
    }
}
