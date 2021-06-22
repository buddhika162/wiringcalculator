<?php
require_once(__DIR__ . '/../Service/bulbCalculationService.php');

$postData = $_POST;
$calculateControllero = new CalculatController();
$calculateControllero->calculate($postData);


class CalculatController {
	public function calculate($postData){
			$bulbCalculationService = new BulbCalculationService();
			$bulbCalculationService->calculate($postData);
	}
}


?>
