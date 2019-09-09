<?php namespace Shohabbos\UserProfile;

use System\Classes\PluginBase;
use Event;
use Yaml;
use Shohabbos\UserProfile\Models\Profile;
use Shohabbos\UserProfile\Models\Image;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
class Plugin extends PluginBase
{
	
	public function boot()
    {
        UserModel::extend(function ($model) {
            $model->addFillable(['profile', 'key', 'leader']);
            $model->hasOne['profile'] = Profile::class;
            $model->hasMany['images'] = Image::class;
            $model->bindEvent('model.beforeSave', function() use ($model) {
                if (!$model->profile) {
                    $model->profile = new Profile();
                }
            });

        });

        Event::listen('rainlab.user.register', function ($user, $data) {
            $key = md5($data['email'] . $data['password']);
            dump($data, $key);
            $user->key = $key;
            $user->save();
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
