<?php
require_once __DIR__ . '/../Dao/projectDao.php';

$postData = $_POST;
$fileContent = null;
if(count($_FILES) > 0 && $_FILES['housePlanFile']){
	$fileContent = file_get_contents($_FILES["housePlanFile"]["tmp_name"]);
	$fileContent = base64_encode($fileContent);
}

$SaveProjectInfoController = new SaveProjectInfoController();
$SaveProjectInfoController->saveProject($postData, $fileContent);

class SaveProjectInfoController {
	public function saveProject($postData, $fileContent){
			$projectDao = new ProjectDao();
			$projectId = $projectDao->saveProjectInfo($postData['name'],$postData['description'],$postData['projectType'],$postData['phase'],$postData['email'],$fileContent);
			echo $projectId;
	}
}


?>
