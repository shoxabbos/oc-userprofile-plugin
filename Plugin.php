<?php namespace Shohabbos\UserProfile;

use System\Classes\PluginBase;
use Event;
use Yaml;
use Mail;
use Shohabbos\UserProfile\Models\Profile;
use Shohabbos\UserProfile\Models\Image;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
class Plugin extends PluginBase
{
	
	public function boot()
    {
        UserModel::extend(function ($model) {
            $model->addFillable(['profile', 'leader']);
            
            $model->hasOne['profile'] = Profile::class;
            $model->hasMany['images'] = Image::class;

            $model->bindEvent('model.beforeSave', function() use ($model) {
                if (!$model->profile) {
                    $model->profile = new Profile();
                }
            });
        });


        Event::listen('rainlab.user.register', function ($user, $data) {
            $user->username = md5(time().rand());
            $user->is_activated = 1;
            $user->activated_at = date("Y-m-d H:i:s");
            $user->save();

            $data = [
                'name' => $user->name,
                'code' => $user->username
            ];

            Mail::send('shohabbos.userprofile::mail.sendsecretkey', $data, function($message) use ($user) {
                $message->to($user->email, $user->name);
            });
        });

        
        // extend form
        UsersController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof UserModel) {
                return;
            }

            if (!$model->exists) {
                return;
            }

            static::getUserProfile($model);

            $fields = Yaml::parseFile('./plugins/shohabbos/userprofile/models/profile/user_fields.yaml');
            $form->addTabFields($fields);
        });

    }
    
    public function registerComponents()
    {
        return [
            \Shohabbos\UserProfile\Components\Login::class       => 'keylogin',
            \Shohabbos\UserProfile\Components\Photos::class       => 'userphotos',
        ];
    }

    public function registerSettings()
    {
    }

    static public function getUserProfile($user) {
        if ($user->profile) {
            return $user->profile;
        }

        $profile = new Profile();
        $profile->user = $user;
        $profile->save();

        $user->profile = $profile;
        $user->save();

        return $profile;
    }
}
