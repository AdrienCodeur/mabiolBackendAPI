<?php

namespace App\Listeners  ;

use App\Events\RegisterUser;
use Illuminate\Events\Dispatcher;

class RegisterEventSubscribe{


    public  function testSubscribe(){

        return 'ok le  test est bon';
    }


    public function subscribe(Dispatcher $dispatcher):array {


        return [
                RegisterUser::class=>'testSubscribe' ,

        ] ;
        // cette methode n'est utiliser que si nous utilisons d'autre classe hors mis du subscriber 
        // $dispatcher->listen( 
        //         RegisterUser::class  ,
        //         [RegisterEventSubscribe::class ,'testsubscribe']
        // ) ;

    }
}