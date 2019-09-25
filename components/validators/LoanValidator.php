<?php

namespace app\components\validators;

use yii;
use app\models\User;
use RKD\PersonalIdCode\PersonalIdCode;
use yii\validators\Validator;

class LoanValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        // Get user.
        $user = User::findOne($model->user_id);

        if (!$user) {
            $this->addError($model, $attribute, 'User not found.');
            return;
        }

        // Get personal code.
        $id = new PersonalIdCode($user->personal_code);

        if ($id->getAge() < Yii::$app->params['min_age_loan']) {
            $this->addError($model, $attribute, 'User is not allowed to get a loan, the minimum age is {minimum_age}.', ['minimum_age' => 12]);
        }
    }
}