<?php
require_once __DIR__ . '/../Dao/bulbCalculationDao.php';
require_once __DIR__ . '/../Dao/projectDao.php';

Class BulbCalculationService {
	public function calculate($postData){
		$projectDao = new ProjectDao();
		foreach ($postData['areas'] as $data) {
			$noOfBulbsPerArea = $this->calculateBulbs($data);
			$FanCMFValue = $this->calculateFans($data);
			$noOfShocketOutLets = $this->calculateShocketOutLets($data);

			$currentOf16AMCB = $this->calculate16AMCBCurrent($data);
			$currentOf6AMCB = $this->calculate6AMCBCurrent($data,$noOfBulbsPerArea);
			$noOf16AMCB = ceil($currentOf16AMCB/16);
			$noOf6AMCB = ceil($currentOf6AMCB/6);
			$totalCurrent = $currentOf16AMCB+$currentOf6AMCB;
			$noOfSwitches = $noOfBulbsPerArea;//$this->calculateSwitches($data);
			$projectAreaId = $projectDao->saveProjectArea($postData['projectId'], $data, round($noOfBulbsPerArea), $FanCMFValue, $noOfShocketOutLets, $noOfSwitches, $noOf6AMCB, $noOf16AMCB, $totalCurrent);
			$projectDao->saveProjectAreaElectricItems($projectAreaId, $data['electricItems']);
		}

	}
	public function calculateBulbs($data){
		$bulbIlluminations = array(
			"LED" => array(
				6 => 450,
				9 => 800,
				10 => 800,
				13 => 1100,
				16 => 1600,
				18 => 1600
			),
			"Flourescent" => array(
				8 => 450,
				9 => 450,
				13 => 800,
				14 => 800,
				18 => 1100,
				19 => 1100,
				23 => 1600,
			),
			"Incandescent" => array(
				40 => 450,
				60 => 800,
				75 => 1100,
				100 => 1600,
			),
			"Tube Light" => array(
				29 => 450,
				43 => 800,
				53 => 1100,
				72 => 1600,
			),
			"Night Light" => array(
				5 => 450,
			)
		);
		
		$projectDao = new ProjectDao();
		$bulbCaluculationDao = new BulbCalculationDao();
		$illuminationLevels = $bulbCaluculationDao->getIlluminationLevels();
		$noOfBulbs = 0;
		$noOfBulbsPerArea = ($data['area']*0.09*$illuminationLevels[$data['type']])/$bulbIlluminations[$data['bulbModel']][$data['bulbType']];
		return round($noOfBulbsPerArea);
			

	}
	
	public function calculateFans($data){
		$FanCMFValue = "";

		$achValues = array(
			'Bed Room' => 5.5,
			'Tv Lobby' => 9.5,
			'Kitchen' => 7.5,
			'Dining Area' => 9.5,
			'Garage/Workshop' => 7,
			'Bathroom' => 6.5,
			'Varendar' => 9.5,
			'Laundry Room' => 8.5
		);

		$cubicFeetPerMin = $data['area']*$data['height']*$achValues[$data['type']]/60;
		
		if($cubicFeetPerMin <= 150){
			$FanCMFValue = "1000 - 3000";
		} elseif($cubicFeetPerMin > 150 && $cubicFeetPerMin <= 250){
			$FanCMFValue = "1600 - 4500";
		} elseif($cubicFeetPerMin > 250 && $cubicFeetPerMin <= 400){
			$FanCMFValue = "2300 - 6500";
		} else {
			$FanCMFValue = "5500 - 13500";
		}
		
		
		return $FanCMFValue;
			

	}
	
	public function calculateShocketOutLets($data){
		$noOfShocketOutlets = intval($data['area']/200)+3;
		if($data['type'] == 'Bed Room'){
			$noOfShocketOutlets = intval($data['area']/200)+3;
		} else if($data['type'] == 'Tv Lobby'){
			$noOfShocketOutlets = intval($data['area']/150)+3;
		} else if($data['type'] == 'Kitchen'){
			$noOfShocketOutlets = intval($data['area']/100)+3;
		} else if($data['type'] == 'Dining Area'){

		} else if($data['type'] == 'Garage/Workshop'){
			$noOfShocketOutlets = intval($data['area']/100)+3;
		} else if($data['type'] == 'Bathroom'){
			$noOfShocketOutlets = intval($data['area']/150)+3;
		} else if($data['type'] == 'Varendar'){

		} else if($data['type'] == 'Laundry Room'){

		}


		return $noOfShocketOutlets;
	}

	public function calculate6AMCBCurrent($data,$noOfBulbsPerArea){
		$bulbCurrent = $noOfBulbsPerArea*$data['bulbType']*0.6/230;
		$fanCurrent = array(
			'Table Fan' => 0.06,
			'Tower Fan' => 0.16,
			'Wall Fan' => 0.16,
			'Ceiling Fan' => 0.18
		);
		$totalCurrent = $bulbCurrent+ $fanCurrent[$data['fanType']];
		return $totalCurrent;
	}

	public function calculate16AMCBCurrent($data){
		$tvCurrent = array(
		22 => 0.04,
		32 => 0.16,
		42 => 0.16,
		46 => 0.18,
		49 => 0.22,
		55 => 0.3
		);


		$electricItems = $data['electricItems'];
		$electricItemsString = implode("','", $electricItems);
		$projectDao = new ProjectDao();
		$currentForElectricItem = $projectDao->getTotalCurrentPerElectricItems($electricItemsString);

		$currentForElectricItem = $currentForElectricItem+$tvCurrent[$data['tvSize']];



		return $currentForElectricItem;
	}
	
	public function calculateSwitches($data){
		return 4;
	}
	
}


?>
