<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $avatarFile;
    public $avatarOption = 'url'; 
    public $password_repeat;
    public $avatar_url;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique'],
            ['username', 'unique'],
            ['avatar', 'url', 'defaultScheme' => 'http'],
            ['avatar', 'required', 'when' => function($model) {
                return $model->avatarOption === 'url';
            }],
            [['avatarFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'when' => function($model) {
                return $model->avatarOption === 'file';
            }],
            [['avatarFile'], 'safe'],
        ];
        
    }

    /**
     * Uploads the avatar file if chosen
     *
     * @return bool whether the upload was successful
     */
    public function upload()
    {
        if ($this->validate() && $this->avatarOption === 'file' && $this->avatarFile) {
            $filePath = Yii::getAlias('@webroot/uploads/avatars/') . $this->avatarFile->baseName . '.' . $this->avatarFile->extension;

            if ($this->avatarFile->saveAs($filePath)) {
                $this->avatar = $this->avatarFile->baseName . '.' . $this->avatarFile->extension;
                return true;
            } else {
                Yii::error("Failed to save file to: " . $filePath);
            }
        }
        return false;
    }

    public function assignRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        $auth->revokeAll($this->id); 
        return $auth->assign($role, $this->id); 
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->avatarOption === 'file' && $this->avatarFile) {
                return $this->upload();
            } elseif ($this->avatarOption === 'url') {
                if (!empty($this->avatar)) {
                    $this->avatar = trim($this->avatar);
                    return true;
                } else {
                    Yii::error("URL not provided");
                    return false;
                }
            }
            return false; 
        }
        return false;
    }

    public function getAvatarUrl()
    {
        if (!empty($this->avatar)) {
            if (strpos($this->avatar, 'http') === 0) {
                return $this->avatar;
            }
            return Yii::getAlias('@web/uploads/avatars/' . $this->avatar);
        }

        return Yii::getAlias('@web/uploads/avatars/default_avatar.png');
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getPassword()
    {
        return $this->password_hash;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
