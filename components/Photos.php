<?php namespace Shohabbos\UserProfile\Components;

use Auth;
use Input;
use Validator;
use ValidationException;
use System\Models\File;
use Cms\Classes\ComponentBase;
use Shohabbos\UserProfile\Models\Image;

class Photos extends ComponentBase
{

    public $user;

    public function componentDetails()
    {
        return [
            'name'        => 'User photos',
            'description' => 'List of photos'
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

    private function prepareVars() {
        $this->page['user'] = $this->user = Auth::getUser();
    }

    public function onAddPhotos() {
        $this->prepareVars();

        $data = Input::only(['image', 'title']);
        
        $rules = [
            'image' => 'required|image',
            'title' => 'string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->user->images()->add(new Image($data));
    }
    


    //
    // AJAX
    //
    


    //
    // Helpers
    //
    

}
