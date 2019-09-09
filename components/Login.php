<?php namespace Shohabbos\UserProfile\Components;

use Auth;
use Input;
use Validator;
use ValidationException;
use Cms\Classes\ComponentBase;

class Login extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Login by KEY',
            'description' => 'Login by KEY'
        ];
    }

    public function defineProperties()
    {
        return [
            // 'recordsPerPage' => [
            //     'title'   => 'Records per page',
            //     'comment' => 'Number of notifications to display per page',
            //     'default' => 7
            // ]
        ];
    }


    


    //
    // AJAX
    //
    public function onLogin () {
        $data = Input::only('username');
        
        $validation = Validator::make($data, [
            'username' => 'required|exists:users,username'  
        ]);
        
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        
        $user = User::where('username', $data['username'])->first();
        Auth::login($user);
        
        return Redirect::to('/');
    }


    //
    // Helpers
    //
    public function geenerateUsername() {
        return md5(time() . rand(1000, 9999));
    }

}
