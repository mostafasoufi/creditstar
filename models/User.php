<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $personal_code
 * @property int $phone
 * @property bool $active
 * @property bool $dead
 * @property string $lang
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'personal_code', 'phone'], 'required'],
            [['first_name', 'last_name', 'email', 'lang'], 'string'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Email already exist. Please try another one.'],
            [['personal_code', 'phone'], 'default', 'value' => null],
            [['personal_code', 'phone'], 'integer'],
            ['personal_code', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Personal code already exist. Please try another one.'],
            ['personal_code', 'string', 'length' => [11, 11]],
            ['phone', 'string', 'length' => [8, 8]],
            ['phone', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Phone already exist. Please try another one.'],
            [['active', 'dead'], 'boolean'],
            ['lang', 'string', 'length' => [3, 3]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'personal_code' => 'Personal Code',
            'phone' => 'Phone',
            'active' => 'Active',
            'dead' => 'Dead',
            'lang' => 'Lang',
        ];
    }

    /**
     * @param $data
     * @return int
     * @throws Exception
     */
    public static function insertUser($data)
    {
        Yii::$app->db->createCommand()->insert('user', array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'personal_code' => $data['personal_code'],
            'phone' => $data['phone'],
            'active' => $data['active'],
            'dead' => $data['dead'],
            'lang' => $data['lang'],
        ))->execute();

        return Yii::$app->db->lastInsertID;
    }
}
