<?php
namespace app\models;
use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $avatar;
    public $avatarOption; 
    public $avatarFile; 

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match'],
            ['avatar', 'string', 'max' => 255],
            ['avatar', 'url', 'defaultScheme' => 'http'],
            ['avatarOption', 'in', 'range' => ['file', 'url']], 
            ['avatarFile', 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
        ];
    }

    public function register()
{
    if ($this->load(Yii::$app->request->post()) && $this->validate()) {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();

        if ($this->avatarOption === 'url' && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            $user->avatar = $this->avatar;
        } elseif ($this->avatarOption === 'file' && $this->avatarFile) {
            $file = $this->avatarFile;
            $filePath = 'uploads/avatars/' . $file->baseName . '.' . $file->extension;

            if ($file->saveAs($filePath)) {
                $user->avatar = $filePath;
            } else {
                $this->addError('avatarFile', 'Failed to upload file.');
                Yii::error('Failed to save file to path: ' . $filePath);
                return false;
            }
        }

        if ($user->save()) {

            Yii::info('User successfully created: ' . $user->username);
                
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');
            if ($role !== null) {
                if ($auth->assign($role, $user->id)) {
                    Yii::info('Role "user" assigned to user ID: ' . $user->id);
                } else {
                    Yii::error('Failed to assign role "user" to user ID: ' . $user->id);
                }
            } else {
                Yii::error('Role "user" not found in authManager');
            }
            
            return true;
        } else {
            Yii::error('Failed to save user: ' . json_encode($user->errors));
        }
    } else {
        Yii::error('Validation failed: ' . json_encode($this->errors));
    }

    return false;
}
}
