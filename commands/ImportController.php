<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

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
    public $file;
    public $model;
    private $json;

    /**
     * @param string $actionID
     * @return array|string[]
     */
    public function options($actionID)
    {
        return ['file', 'model'];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return [
            'file' => 'file',
            'model' => 'model',
        ];
    }

    /**
     * Check model is correct.
     *
     */
    private function checkModel()
    {
        if (array_search($this->model, ['user', 'loan']) === false) {
            $this->stdout("Error! model is not correct, acceptable: user, loan\n\n", Console::FG_RED);
            return;
        }

        return true;
    }

    /**
     * Check file exist.
     *
     * @return bool
     */
    private function checkJson()
    {
        if (!file_exists($this->file)) {
            $this->stdout("File {$this->file} not exist.\n", Console::FG_RED);
            return;
        }

        // Set json variable.
        $this->set_json();

        // Validate
        $validator = new JsonSchema\Validator();
        $validator->validate($this->json, (object)array('$ref' => 'file://' . realpath($this->model . '-schema.json')));

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
        if (!$this->file || !$this->model) {
            $this->stdout("Error! arguments -file or -model not found.\n", Console::FG_RED);
            return false;
        }

        if (!$this->checkModel()) {
            return false;
        }

        if (!$this->checkJson()) {
            return false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Import the json file into database which select file and model.
     */
    public function actionIndex()
    {
        foreach ($this->json as $item) {
            echo $this->ansiFormat("Imported successfully.", Console::FG_GREEN);

            echo "\n";
        }
    }

    /**
     * @return mixed
     */
    private function set_json()
    {
        $this->json = json_decode(file_get_contents($this->file));
    }
}
