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

/**
 * Database Importer Command.
 **
 */
class ImportController extends Controller
{
    public $file;
    public $model;

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
     * Check file exist.
     *
     * @return bool
     */
    private function checkFileExist()
    {
        return file_exists($this->file);
    }

    /**
     * Check model is correct.
     *
     */
    private function checkModel()
    {
        $model = 'app\models\\' . ucfirst($this->model);
        return class_exists($model);
    }

    /**
     * @param Action $action
     * @return bool|void
     */
    public function beforeAction($action)
    {
        if (!$this->file || !$this->model) {
            echo $this->ansiFormat('Error! arguments -file or -model not found.', Console::FG_RED) . "\n";
            return;
        }

        if (!$this->checkFileExist()) {
            echo $this->ansiFormat('Error! the file is not exist.', Console::FG_RED) . "\n";
            return;
        }

        if (!$this->checkModel()) {
            echo $this->ansiFormat('Error! the model is not exist.', Console::FG_RED) . "\n";
            return;
        }

        return parent::beforeAction($action);
    }

    /**
     * Import the json file into database which select file and model.
     */
    public function actionIndex()
    {
        $name = $this->ansiFormat('Success', Console::FG_GREEN);
        echo "$name.\n";
    }
}
