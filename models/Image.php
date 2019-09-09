<?php namespace Shohabbos\UserProfile\Models;

use Model;

/**
 * Model
 */
class Image extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_userprofile_images';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'image' => \System\Models\File::class
    ];

    public $belongsTo = [
        'user' => \Rainlab\User\Models\User::class
    ];

    public $morphMany = [
        'comments' => [ \Shohabbos\Comments\Models\Comment::class, 'name' => 'attachment'],
        'likes' => [\Shohabbos\Like\Models\Like::class, 'name' => 'attachment']
    ];
    
    protected $guarded = ['id'];
}
