<?php

namespace App\Http\Controllers;

use App\Todo;
use Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    // GET    /api/todo
    public function index()
    {
        // Auth::user เป็น class รับรองความถูกต้องของ user ถูกเรียกใช้งานจาก middleware/authenticate.php ต้องไปเปิด facades ด้วยถึงจะใช้งานได้
        // ถ้า user ถูกรับรองแล้ว เรียกใช้งาน method todo() จาก user model app/Users.php เพื่อดึงข้อมูลทั้งหมดจาก table todo
        $todo = Auth::user()->todo()->get();

        // คืนค่า array ออกเป็น json

        return response()->json( ['status' => 'success', 'result' => $todo] );
    }

    // POST    /api/todo
    public function store( Request $request )
    {
        // validate เป็น object ที่ laravel ทำมาให้ใช้ตรวจสอบข้อมูล จาก doc https://lumen.laravel.com/docs/6.x/validation
        $this->validate( $request, [
            'todo'        => 'required',
            'description' => 'required',
            'category'    => 'required',
        ] );

        // ถ้าถูกต้องก็ ใช้ method create (เนื่องจากรับข้อมูลมาเป็น array) เพื่อ insert ข้อมูลลง db ดูจาก doc https://laravel.com/docs/6.x/eloquent-relationships#the-create-method
        if ( Auth::user()->todo()->Create( $request->all() ) )
        {
            return response()->json( ['status' => 'success'] );
        }
        else
        {
            return response()->json( ['status' => 'fail'] );
        }

    }

    // GET    /api/todo/{id}
    public function show( $id )
    {
        // เรียกใช้งาน todo medel select ข้อมูลจาก id ที่ได้รับมา
        $todo = Todo::where( 'id', $id )->get();

        return response()->json( $todo );

    }

    // PUT    /api/todo/{id}
    public function update( Request $request, $id )
    {
        $this->validate( $request, [
            'todo'        => 'filled',
            'description' => 'filled',
            'category'    => 'filled',
        ] );
        // find ดูจาก doc https://laravel.com/docs/6.x/eloquent-relationships#inserting-and-updating-related-models
        // เป็นการ where id เพื่อนทำการอัพเดท request ทั้งหมดที่ได้รับมา และเรียกใช้ method fill เพราะว่าข้อมูลที่ได้รับมาเป็น array จำนวนมาก
        // จึงใช้ fill กรองเช็ค feild ที่ตรงกับ todo model ในตัวแปร $fillable key อันไหนตรงบ้างก็อัพเดทอันนั้น
        $todo = Todo::find( $id );
        if ( $todo->fill( $request->all() )->save() )
        {
            return response()->json( ['status' => 'success'] );
        }

        return response()->json( ['status' => 'failed'] );
    }

    // DELETE    /api/todo/{id}
    // method destroy ลบ ข้อมูลตาม id ที่อ้างอิงมา
    public function destroy( $id )
    {
        if ( Todo::destroy( $id ) )
        {
            return response()->json( ['status' => 'success'] );
        }
    }
}
