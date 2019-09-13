<?php namespace Shohabbos\UserProfile\Components;

use Auth;
use Flash;
use Input;
use Validator;
use ValidationException;
use System\Models\File;
use Cms\Classes\ComponentBase;
use Shohabbos\UserProfile\Models\Image as ImageModel;
use Shohabbos\Comments\Models\Comment;

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

        $this->user->images()->add(new ImageModel($data));
    }
    


    //
    // AJAX
    //
    
    public function onDeletePhoto() {
        $this->prepareVars();

        $data = Input::only(['id']);
        
        $rules = [
            'id' => 'required|exists:shohabbos_userprofile_images',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->user->images()->find($data['id'])->delete();
        Flash::success('Фотография удалена');
    }

    //
    // Helpers
    //
    public function onToggleLike()
    {
        $user = Auth::getUser();

        if (!$user){
            return Flash::error('invalid token');
        }

        $id = post('id');
        $validation = Validator::make(
            [ 'id' => $id ],
            [ 'id' => 'required|exists:shohabbos_userprofile_images']
        );
        $image = ImageModel::find($id);
        $like = clone $image->likes();
        $like = $like->where('author_id', $user->id)->count();

        $newImage = clone $image;

        if ($like){
            $newImage->likes()->where(['author_id' => $user->id])->delete();
        } else {
            $newImage->likes()->create(['author_id' => $user->id]);
        }

        return [
            '#likesCount' . $id => $image->likes()->count()
        ];

        Flash::info('spasibo');
    }

    public function onAddComment()
    {
        $user = Auth::getUser();
        
        if (!$user){
            return Flash::error('invalid token');
        }

        $data = Input::only('id', 'content');
        $validation = Validator::make($data, [
            'id' => 'required|exists:shohabbos_userprofile_images',
            'content' => 'required|min:1'
        ]);

        if ($validation->fails()){
            throw new ValidationException($validation);
        }

        $comment = [
            'content' => $data['content'],
            'author_id' => $user->id
        ];

        $comment = ImageModel::find($data['id'])->comments()->create($comment);
        $this->page['comment'] =  Comment::where('author_id', $user->id)->orderByDesc('created_at')->first();
        return [
            '#commentsCount' . $data['id'] => ImageModel::find($data['id'])->comments()->count()
        ];
    }

}
