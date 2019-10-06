<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    // GET    /api/login
    public function authenticate( Request $request ) // Request คือการกำหนด type hint เป็น Request Class ว่าฟังก์ชั่นนี้รับแต่ http reqeust เท่านั้น
    // ข้อมูลเพิ่มเติมเกี่ยวกับ type hint ที่หามาว่ามันคืออะไร https://medium.com/nawawish/php-type-hinting-44603d09e1be
    {
        // validate เป็น object ที่ laravel ทำมาให้ใช้ตรวจสอบข้อมูล จาก doc https://lumen.laravel.com/docs/6.x/validation
        // rules อื่น ๆ https://laravel.com/docs/6.x/validation#available-validation-rules
        $this->validate( $request, [
            'email'    => 'required',
            'password' => 'required',
        ] );

        // เรียกใช้ model class ของ Users เอาข้อมูลที่ login มาเช็ค
        // $user จะได้ข้อมูลจากฐานข้อมูลที่ email ตรงกัน
        $user = Users::where( 'email', $request->input( 'email' ) )->first();
        // เช็คถ้า password ตรงกับใครฐานข้อมูลให้ทำเงื่อนไขต่อ ถ้าไม่ใช่ก็ส่ง 401 Unauthorized
        if ( Hash::check( $request->input( 'password' ), $user->password ) )
        {
            // ให้อัพเดท api key แล้ว return api key ใหม่ออกมา
            $apikey = base64_encode( Str::random( 40 ) );
            Users::where( 'email', $request->input( 'email' ) )->update( ['api_key' => "$apikey"] );

            return response()->json( ['status' => 'success', 'api_key' => $apikey] );
        }
        else
        {
            return response()->json( ['status' => 'fail'], 401 );
        }
    }
}
