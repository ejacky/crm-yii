<?php
class AssistController extends Controller
{
	public $layout='//layouts/column2';

	public static function actionDataBak($withData = true, $dropTable = true, $saveName = null, $savePath = true)
	{
		$savePath = Yii::app()->basePath . '/data';
		
		$pdo = Yii::app()->db->pdoInstance;
		$mysql = '';
		$statments = $pdo->query("show tables");
		foreach ($statments as $value)
		{
			$tableName = $value[0];
			if ($dropTable === true)
			{
				$mysql.="DROP TABLE IF EXISTS `$tableName`;\n";
			}
			$tableQuery = $pdo->query("show create table `$tableName`");
			$createSql = $tableQuery->fetch();
			$mysql.=$createSql['Create Table'] . ";\r\n\r\n";
			if ($withData != 0)
			{
				$itemsQuery = $pdo->query("select * from `$tableName`");
				$values = "";
				$items = "";
				while ($itemQuery = $itemsQuery->fetch(PDO::FETCH_ASSOC))
				{
					$itemNames = array_keys($itemQuery);
					$itemNames = array_map("addslashes", $itemNames);
					$items = join('`,`', $itemNames);
					$itemValues = array_values($itemQuery);
					$itemValues = array_map("addslashes", $itemValues);
					$valueString = join("','", $itemValues);
					$valueString = "('" . $valueString . "'),";
					$values.="\n" . $valueString;
				}
				if ($values != "")
				{
					$insertSql = "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . ";\n\r";
					$mysql.=$insertSql;
				}
			}
		}

		ob_start();
		echo $mysql;
		$content = ob_get_contents();
		ob_end_clean();
		$content = gzencode($content, 9);

		if (is_null($saveName))
		{
			//$saveName = date('YmdHms') . ".sql.gz";
			$saveName = "crm.sql.gz";
		}

		if ($savePath === false)
		{
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: Download SQL Export");
			header('Content-Disposition: attachment; filename='.$saveName);
			echo $content;
			die();
		}
		else
		{
			$filePath = $savePath ? $savePath . '/' . $saveName : $saveName;
			file_put_contents($filePath, $content);
			echo "Database file saved: " . $saveName;
		}
	}

	public function dataUpdate($importSql)
	{
		if( isset($importSql))
		{
			$file = fopen(Yii::app()->basePath .'/data/'.$importSql .'.sql', "r") or exit("Unable to open file!");
			$sqlcontent = '-- phpMyAdmin SQL Dump';
			while(!feof($file))
			{
				$sqlcontent .=  fgets($file);
			}

			$con = Yii::app()->db;
			$com = $con->createCommand($sqlcontent);
			$com->execute();
		}

		Yii::app()->user->setFlash('pageInfo', "数据导入成功");
		$this->redirect('index');
	}

	public function actionIndex()
	{
		$formfields = PaForm::model()->findByAttributes(array('name' => 'assist'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'assist'))->fields ;
		if (isset($_POST['form'])) {                      
			 $this->dataUpdate($_POST['form']['sqlData']);
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                        'model' => new stdClass(),
		));
	}
        
        public function actionMigration()
        {
            $dsn = 'mysql:host=localhost;dbname=crm-migration';
            $con = new CDbConnection($dsn, 'root', '');
            $dr = $con->createCommand('select * from keycompany')->query();
            foreach ($dr->read() as $row)
            {
                Yii::app()->db->createCommand('insert fu_crm_client values()')->execute();
            }
            $this->render('migration');
        }

	public function actionSystemUpdate()
	{
		$this->render('systemUpdate');
	}
        
        public function actionAddContact()
        {
            $this->render('addContact');
        }

}
