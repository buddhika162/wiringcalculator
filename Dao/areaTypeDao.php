<?php
require_once(__DIR__ . '/connectionDao.php');

Class AreaTypeDao {
	public function getAreaTypes(){
		$connectionDao = new ConnectionDao();
		$conn = $connectionDao->getConnection();
		$sql = "SELECT name FROM areaType";
		$result = $conn->query($sql);
		$areaTypes = array();
		if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			$areaTypes[] = $row["name"];
		  }
		} 
		
		return $areaTypes;
	}
}


?>
