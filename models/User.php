<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_role_id
 * @property string $first_name
 * @property string $last_name 
 * @property string $middle_name
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $name_in_urdu 
 * @property string $email 
 * @property string $auth_key
 * @property integer $status
 * @property integer $last_ip_address 
 * @property string $last_login
 * @property integer $created_at
 * @property integer $updated_at
 * @property resource $Image
 *
 * @property FulName[] $fullName
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_ACTIVE = 'active';

    public $password;
    public $confirm_password;

    //public $file;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            //['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['first_name', 'auth_key', 'password_hash', 'status', 'fk_role_id'], 'required'],
            ['username', 'required', 'message' => 'Registration No Cannot Be Blank.'],
            ['username', 'string', 'min' => 2, 'max' => 20],
            //['email', 'email'],
            // [['Image'], 'file'],
            //[['Image'], 'file', 'types' => 'jpg'],
            // [['Image'], 'file', 'extensions' => 'png, jpg'],
            // ['Image', 'file', 'extensions' => 'jpg, jpeg, gif, png', 'mimeTypes' => 'image/jpeg, image/gif, image/png', 'skipOnEmpty' => true],
            // [['Image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            //[['Image'], 'file', 'mimeTypes' => 'image/gif, image/jpeg'],
            // [['Image'], 'file','extensions' => 'png', 'maxFiles' => 4,'skipOnEmpty' => true, 'on' =>'update'],
            //['username', 'match', 'pattern' => '/^[a-z]\w*$/i'],
            ['username', 'validateUsernameAlreadyExist', 'on' => 'update'],
            /* ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.','on'=>'create'], */
            ['email', 'validateEmailAlreadyExist', 'on' => 'update'],
            [['name_in_urdu'], 'string', 'max' => 300],
            [['password', 'confirm_password'], 'required', 'on' => 'create'],
            [['fk_branch_id', 'fk_role_id'], 'integer'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'New password and confirm password must be same.'],
            ['confirm_password', 'required', 'message' => 'Confirm Password cannot be blank', 'when' => function($model) {
                    return $model->password != '';
                },
                'whenClient' => "function (attribute, value)
                 {
                         return $('#user-password').val() != '';
                }", 'on' => 'update'],
            [['first_name', 'last_name'], 'string', 'max' => 150],
            [['username', 'email', 'password_hash', 'password_reset_token', 'avatar'], 'string', 'max' => 255],
            [['middle_name'], 'string', 'max' => 20],
            [['last_ip_address'], 'string', 'max' => 80],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            // [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['status'], 'string'],
            [['created_at', 'updated_at', 'Image', 'name_in_urdu','last_login'], 'safe'],
            [['Image'], 'file', 'extensions' => 'jpg,jpeg, png', 'mimeTypes' => 'image/jpg,image/jpeg, image/png'],
        ];
    }

    /**
     * @attributes name
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fk_branch_id' => 'Branch ID',
            'fk_role_id' => 'Role',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'username' => 'Student Registration No.',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'last_ip_address' => 'Last Ip Address',
            'last_login' => 'Last Login',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name_in_urdu' => 'اردو میں نام',
            'Image' => 'Image',
        ];
    }

    /**/

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        //'fk_branch_id'=>Yii::$app->common->getBranch();
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /* validate email already exist */

    public function validateEmailAlreadyExist() {
        $alreadyexistbyemail = $this->find()
                ->where("id !=" . $this->id . " and email ='" . $this->email . "'")
                ->count();
        if ($alreadyexistbyemail > 0) {
            $this->addError('email', 'This email address has already been taken.');
        }
    }

    /* validate Username already exist */

    public function validateUsernameAlreadyExist() {
        $alreadyexistbyusername = $this->find()
                ->where("id !=" . $this->id . " and username ='" . $this->email . "'")
                ->count();
        if ($alreadyexistbyusername > 0) {
            $this->addError('username', 'This username has already been taken.');
        }
    }

    /*
     * user full name
     */

    public function getfullName() {
        return $this->first_name . ' ' . $this->middle_name . '' . $this->last_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkRole() {
        return $this->hasOne(UserRoles::className(), ['id' => 'fk_role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch() {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->created_at = new \yii\db\Expression('NOW()');
                if (Yii::$app->controller->id != 'branch') {
                    $this->fk_branch_id = Yii::$app->common->getBranch();
                }
                $this->updated_at = null;
            } elseif (!$this->isNewRecord) {
                $this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;
        }
    }

    public function getPhotoName() {
        return yii::$app->common->getSlug($this->first_name . '-' . $this->last_name) . '-' . uniqid();
    }

}
