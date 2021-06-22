<?php
require_once __DIR__ . '/connectionDao.php';

Class BulbCalculationDao {
	public function getIlluminationLevels(){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT name ,illuminationLevel FROM areaType";
		$result = $conn->query($sql);
		$illuminationLevels = array();
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			$illuminationLevels[$row["name"]] = $row["illuminationLevel"];
		  }
		} 
		
		return $illuminationLevels;
	}
}


?>
