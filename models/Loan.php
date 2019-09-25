<?php

namespace app\models;

use app\components\validators\LoanValidator;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "loan".
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount
 * @property string $interest
 * @property int $duration
 * @property string $start_date
 * @property string $end_date
 * @property int $campaign
 * @property bool $status
 */
class Loan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'interest', 'duration', 'start_date', 'end_date', 'campaign'], 'required'],
            [['user_id', 'duration', 'campaign'], 'default', 'value' => null],
            [['user_id', 'duration', 'campaign'], 'integer'],
            ['user_id', LoanValidator::className()],
            ['user_id', 'exist', 'targetAttribute' => 'id', 'targetClass' => '\app\models\User', 'message' => 'User not exist.'],
            [['amount', 'interest'], 'number'],
            [['start_date', 'end_date'], 'safe'],
            [['status'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'interest' => 'Interest',
            'duration' => 'Duration',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'campaign' => 'Campaign',
            'status' => 'Status',
        ];
    }

    /**
     * @param $data
     * @param $user_id
     * @return int
     * @throws Exception
     */
    public static function insertLoan($data, $user_id)
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
