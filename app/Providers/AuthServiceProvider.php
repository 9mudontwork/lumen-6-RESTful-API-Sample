<?php

namespace App\Providers;

use App\Users;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        // เช็ค ความถูกต้องของ API key ที่ user ส่งมาเพื่อนดำเนินการต่อ
        $this->app['auth']->viaRequest( 'api', function ( $request )
        {
            if ( $request->header( 'Authorization' ) )
            {
                $key  = $request->header( 'Authorization' );
                $user = Users::where( 'api_key', $key )->first();
                if ( !empty( $user ) )
                {
                    $request->request->add( ['userid' => $user->id] );

                }

                return $user;
            }
        } );
    }
}
