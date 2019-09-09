<?php namespace Shohabbos\UserProfile\Models;

use Model;
use RainLab\User\Models\User;
/**
 * Model
 */
class Profile extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $dates = ['birthday'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'shohabbos_userprofile_profile';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'background_image' => 'System\Models\File'
    ];

    public $belongsTo = [
        'user' => \RainLab\User\Models\User::class
    ];

    public $guarded = ['id'];
}
