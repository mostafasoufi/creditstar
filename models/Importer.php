<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Importer extends Model
{
    /**
     * @param $data
     * @return int
     * @throws Exception
     */
    public function user($data)
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

    /**
     * @param $data
     * @param $user_id
     * @return int
     * @throws Exception
     */
    public function loan($data, $user_id)
    {
        return Yii::$app->db->createCommand()->insert('loan', array(
            'user_id' => $user_id,
            'amount' => $data['amount'],
            'interest' => $data['interest'],
            'duration' => $data['duration'],
            'start_date' => date('Y-m-d', $data['start_date']),
            'end_date' => date('Y-m-d', $data['end_date']),
            'campaign' => $data['campaign'],
            'status' => $data['status'],
        ))->execute();
    }
}
