<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use app\models\Loan;
use yii\base\Action;
use yii\console\Controller;
use yii\helpers\Console;
use JsonSchema;
use JsonSchema\Constraints;

/**
 * Database Importer Command.
 **
 */
class ImportController extends Controller
{
    public $user;
    public $loan;
    private $json;

    /**
     * @param string $actionID
     * @return array|string[]
     */
    public function options($actionID)
    {
        return ['user', 'loan'];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return [
            'user' => 'user',
            'loan' => 'loan',
        ];
    }

    /**
     * Check file exist.
     *
     * @return bool
     */
    private function checkFiles()
    {
        if (!file_exists($this->user)) {
            $this->stdout("File {$this->user} not exist.\n", Console::FG_RED);
            return;
        }

        if (!file_exists($this->loan)) {
            $this->stdout("File {$this->loan} not exist.\n", Console::FG_RED);
            return;
        }

        // Set json variable.
        $this->set_json();

        return true;
    }

    private function checkUserSchema()
    {
        // Validate
        $validator = new JsonSchema\Validator();
        $validator->validate($this->json['user'], (object)array('$ref' => 'file://' . realpath('users-schema.json')));

        if (!$validator->isValid()) {
            $this->stdout("JSON does not validate:\n", Console::FG_RED);

            foreach ($validator->getErrors() as $error) {
                $this->stdout(sprintf("[%s] %s\n", $error['property'], $error['message']), Console::FG_YELLOW);
            }

            return;
        }

        return true;
    }

    private function checkLoanSchema()
    {
        // Validate
        $validator = new JsonSchema\Validator();
        $validator->validate($this->json['loan'], (object)array('$ref' => 'file://' . realpath('loans-schema.json')));

        if (!$validator->isValid()) {
            $this->stdout("JSON does not validate:\n", Console::FG_RED);

            foreach ($validator->getErrors() as $error) {
                $this->stdout(sprintf("[%s] %s\n", $error['property'], $error['message']), Console::FG_YELLOW);
            }

            return;
        }

        return true;
    }

    /**
     * @param Action $action
     * @return bool|void
     */
    public function beforeAction($action)
    {
        if (!$this->user || !$this->loan) {
            $this->stdout("Error! arguments -user or -loan not found.\n", Console::FG_RED);
            return false;
        }

        if (!$this->checkFiles() || !$this->checkUserSchema() || !$this->checkLoanSchema()) {
            return false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Import the json file into database which select file and model.
     */
    public function actionIndex()
    {
        foreach ($this->json['user'] as $user) {
            // Check user exist.
            if (User::find()->where(['email' => $user->email])->count()) {
                $this->stdout(sprintf("Email %s already exist.\n", $user->email), Console::FG_RED);
                continue;
            }

            try {
                $user_id = User::insertUser((array)$user);
                $this->stdout(sprintf("User %s imported successfully.\n", $user->id), Console::FG_GREEN);

                // Insert user loans
                foreach ($this->json['loan'] as $loan) {
                    if ($loan->user_id == $user->id) {
                        Loan::insertLoan((array)$loan, $user_id);
                        $this->stdout(sprintf(" - Loan %s imported.\n", $loan->id));
                    }
                }

            } catch (\Exception $e) {
                $this->stdout(sprintf(" - Error: %s\n", $e->getMessage()), Console::FG_RED);
            }
        }
    }

    /**
     * @return mixed
     */
    private function set_json()
    {
        $this->json['user'] = json_decode(file_get_contents($this->user));
        $this->json['loan'] = json_decode(file_get_contents($this->loan));
    }
}
