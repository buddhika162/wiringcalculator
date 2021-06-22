<?php
require_once __DIR__ . '/connectionDao.php';

Class ProjectDao {
	public function saveProjectInfo($name, $description, $type, $phase, $email, $housePlan){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "INSERT INTO `project` (`id`, `name`, `description`, `phase`, `type`,`email`,`housePlan`) VALUES (NULL, '" . $name . "', '" . $description . "', '" . $phase . "', '" . $type . "','" . $email . "',\"" . $housePlan . "\"); ";
		$result = $conn->query($sql);
		if($result){
			return $conn->insert_id;
		} else {
			var_dump($result);
		}
	}
	
	public function saveProjectArea($projectId, $areaData, $noOfBulbsPerArea, $fanCMFValue, $noOfShocketOutLets, $noOfSwitches, $noOf6AMCB, $noOf16AMCB, $totalCurrent){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "INSERT INTO `projectareas` (`id`, `projectId`, `areaType`, `width`, `length`, `height`, `area`, `bulbModel`, `bulbType`, `noOfBulbs`, `fanType`, `fanCmf`, `tvSize`, `noOfShocketOutLets`, `noOfSwitches`, `6Amcb`, `16Amcb`,`current`) VALUES (NULL, '".$projectId."', '".$areaData['type']."', '".$areaData['width']."', '".$areaData['length']."', '".$areaData['height']."', '".$areaData['area']."', '".$areaData['bulbModel']."', '".$areaData['bulbType']."', '".$noOfBulbsPerArea."', '".$areaData['fanType']."', '".$fanCMFValue."', '".$areaData['tvSize']."', '".$noOfShocketOutLets."', '".$noOfSwitches."', '".$noOf6AMCB."', '".$noOf16AMCB."', '".$totalCurrent."');";
		$result = $conn->query($sql);
		if($result){
			return $conn->insert_id;
		}
	}

	public function saveProjectAreaElectricItems($projectAreaId, $electricItems){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();

		$sql = "INSERT INTO `projectAreaElectricItems` (`projectAreaId`,`electicItemName`)  VALUES ";
		foreach ($electricItems as $electricItem) {
			$sql = $sql . "(".$projectAreaId.", '" .$electricItem. "'),";
		}
		$sql = substr_replace($sql,";",-1);
		$result = $conn->query($sql);
		if($result){
			return $conn->insert_id;
		}
	}
	
	public function getProjectInfo($projectId){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT name ,description,phase,type FROM project WHERE id = '".$projectId."';";
		$result = $conn->query($sql);
		$projectInfo = array();
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			$projectInfo["name"] = $row["name"];
			$projectInfo["description"] = $row["description"];
			$projectInfo["phase"] = $row["phase"];
			$projectInfo["type"] = $row["type"];
		  }
		} 
		
		return $projectInfo;
	}
	
	public function getProjectSummery($projectId){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT * FROM projectareas WHERE projectId = '".$projectId."';";
		$result = $conn->query($sql);
		$projectSummery = array();
		$projectSummery["totalNoOfHolders"] = 0;
		$projectSummery["totalCurrent"] = 0;
		$projectSummery["total16AMCB"] = 0;
		$projectSummery["total6AMCB"] = 0;
		$projectSummery["NoOfFans"] = 0;
		$projectSummery["totalNoOfBulbs"] = array();
		$projectSummery["totalNoOfBulbs"][5] = 0;
		$projectSummery["totalNoOfBulbs"][10] = 0;
		$projectSummery["totalNoOfBulbs"][15] = 0;
		$projectSummery["totalNoOfShocketOutLets"] = 0;
		$projectSummery["totalNoOfSwitches"] = 0;
		$projectSummery["totalNoOfFans"] = array();
		$projectSummery["noOfSwitches"][5] = 0;
		$projectSummery["noOfSwitches"][4] = 0;
		$projectSummery["noOfSwitches"][3] = 0;
		$projectSummery["noOfSwitches"][2] = 0;
		$projectSummery["noOfSwitches"][1] = 0;
		$projectSummery["totalNoOFSunBoxes"] = 0;
		
		
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
		 	if(array_key_exists($row["bulbModel"], $projectSummery["totalNoOfBulbs"])){
				if(array_key_exists($row["bulbType"], $projectSummery["totalNoOfBulbs"][$row["bulbModel"]])){
					$projectSummery["totalNoOfBulbs"][$row["bulbModel"]][$row["bulbType"]] = $projectSummery["totalNoOfBulbs"][$row["bulbModel"]][$row["bulbType"]] + $row["noOfBulbs"];
				} else {
					$projectSummery["totalNoOfBulbs"][$row["bulbModel"]][$row["bulbType"]] = $row["noOfBulbs"];
				}
			} else {
				$projectSummery["totalNoOfBulbs"][$row["bulbModel"]][$row["bulbType"]] = $row["noOfBulbs"];
			}

		 	if(array_key_exists($row["fanType"], $projectSummery["totalNoOfFans"])){
				$projectSummery["totalNoOfFans"][$row["fanType"]] = $projectSummery["totalNoOfFans"][$row["fanType"]]+1;
				$projectSummery["NoOfFans"] = $projectSummery["NoOfFans"]+1;
			} else {
				$projectSummery["totalNoOfFans"][$row["fanType"]] = 1;
				$projectSummery["NoOfFans"] = $projectSummery["NoOfFans"]+1;
			}

			 $projectSummery["totalNoOfHolders"]  = $projectSummery["totalNoOfHolders"]  + $row["noOfBulbs"];
//		 	var_dump($projectSummery);
//			$projectSummery["totalNoOfBulbs"][$row["bulbType"]] = $projectSummery["totalNoOfBulbs"][$row["bulbType"]]+ $row["noOfBulbs"];
			 
			$projectSummery["totalNoOfShocketOutLets"] = $projectSummery["totalNoOfShocketOutLets"] + $row["noOfShocketOutLets"];
			$projectSummery["totalNoOfSwitches"] = $projectSummery["totalNoOfSwitches"] + $row["noOfBulbs"];
			
//			$projectSummery["totalNoOfFans"][$row["fanCmf"]]++;
			$switchMultiplier = 1;
			if($row["areaType"] == "Bed Room"){
				$switchMultiplier = 2;
			}
			
			$projectSummery["noOfSwitches"][5] = $projectSummery["noOfSwitches"][5] + (intval($row["noOfBulbs"]/5) * $switchMultiplier);
			$remaining = $row["noOfBulbs"] - (intval($row["noOfBulbs"]/5)*5);
			$projectSummery["noOfSwitches"][$remaining] = $projectSummery["noOfSwitches"][$remaining] + (1*$switchMultiplier);
			
			$projectSummery["noOfSwitches"][1] = $projectSummery["noOfSwitches"][1]  + (1*$switchMultiplier);
			 $projectSummery["totalCurrent"] = $projectSummery["totalCurrent"] + $row["current"];
			 $projectSummery["total16AMCB"] = $projectSummery["total16AMCB"] + $row["16Amcb"];
			 $projectSummery["total6AMCB"] = $projectSummery["total6AMCB"] + $row["6Amcb"];

		  }
		  $projectSummery["totalNoOFSunBoxes"] = $projectSummery["noOfSwitches"][1] + $projectSummery["noOfSwitches"][2] + $projectSummery["noOfSwitches"][3] + $projectSummery["noOfSwitches"][4] + $projectSummery["noOfSwitches"][5] + $projectSummery["totalNoOfShocketOutLets"];
		  
		} 
		
		return $projectSummery;
	}
	
	public function getProjectDetails($projectId){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT * FROM projectareas WHERE projectId = '".$projectId."';";
		$result = $conn->query($sql);
		$projectDetails = array();
		
		
		
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			 $projectDetail = array();
			 $projectSummery["current"] = 0;
			 $projectSummery["16Amcb"] = 0;
			 $projectSummery["6Amcb"] = 0;
			 $projectDetail["noOfSwitches"][5] = 0;
			$projectDetail["noOfSwitches"][4] = 0;
			$projectDetail["noOfSwitches"][3] = 0;
			$projectDetail["noOfSwitches"][2] = 0;
			$projectDetail["noOfSwitches"][1] = 0;
			
			 $projectDetail['areaType'] = $row["areaType"];
			 $projectDetail['noOfBulbs'] = $row["noOfBulbs"];
			 $projectDetail['bulbType'] = $row["bulbType"];
			 $projectDetail['bulbModel'] = $row["bulbModel"];
			 $projectDetail['fanType'] = $row["fanType"];
			 $projectDetail['current'] = $row["current"];
			 $projectDetail['16Amcb'] = $row["16Amcb"];
			 $projectDetail['6Amcb'] = $row["6Amcb"];
			 $projectDetail['noOFFans'] = 1;
			 $projectDetail['cmf'] = $row["fanCmf"];
			 $projectDetail['noOfShocketOutLets'] = $row["noOfShocketOutLets"];
			 
			 
			$switchMultiplier = 1;
			if($row["areaType"] == "Bed Room"){
				$switchMultiplier = 2;
			}
			
			$projectDetail["noOfSwitches"][5] = (intval($row["noOfBulbs"]/5) * $switchMultiplier);
			$remaining = $row["noOfBulbs"] - (intval($row["noOfBulbs"]/5)*5);
			$projectDetail["noOfSwitches"][$remaining] = (1*$switchMultiplier);
			
			$projectDetail["noOfSwitches"][1] = (1*$switchMultiplier);
			
			$projectDetail["noOFSunBoxes"] = $projectDetail["noOfSwitches"][1] + $projectDetail["noOfSwitches"][2] + $projectDetail["noOfSwitches"][3] + $projectDetail["noOfSwitches"][4] + $projectDetail["noOfSwitches"][5] + $projectDetail["noOfShocketOutLets"];
		  
			
			$projectDetails[] = $projectDetail;
			
		  }
		}
			 
		
		
		return $projectDetails;
	}
	
	public function getProjectData($projectId){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT project.name ,project.description,projectareas.areaType, projectareas.width, projectareas.length, projectareas.area, projectareas.bulbType, projectareas.noOfBulbs FROM projectareas LEFT JOIN project ON project.id = projectareas.projectId WHERE projectareas.projectId = '".$projectId."';";
		$result = $conn->query($sql);
		$illuminationLevels = array();
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			$illuminationLevels[$row["name"]] = $row["illuminationLevel"];
		  }
		} 
		
		return $illuminationLevels;
	}

	public function getTotalCurrentPerElectricItems($electricItemsString){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT SUM(current) AS totalCurrent FROM electricItem WHERE name IN ('".$electricItemsString."');";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return $row['totalCurrent'];
			}
		}

	}
}


?>
