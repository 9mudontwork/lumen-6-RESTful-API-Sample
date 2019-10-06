<?php
namespace App;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Users extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'users';

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
        // hasMany จาก doc https://laravel.com/docs/6.x/eloquent-relationships#one-to-many
        // ดึง ข้อมูล todo อ้างอิง suer id จาก auth ที่กำลัง login ใช้งานอยู่
        return $this->hasMany( 'App\Todo', 'user_id' );
    }
}
