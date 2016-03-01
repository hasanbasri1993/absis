<?php 
Class Activities{

	public $_hot_id;
	public $_nip;

	public function __construct($hot_id,$nip,$username){
		$this->_hot_id=$_hot_id;
		$this->_nip=$nip;
	}
	
	public function cekActivities(){
		$dbTA=new DB($_SESSION['database']);

		
	}
	
	public function buatActivities($keterangan){
		$dbTA=new DB($_SESSION['database']);

		
	}	

	public function updateActivities($keterangan){
		$dbTA=new DB($_SESSION['database']);

		
	}

	public function getActivities(){
		$dbTA=new DB($_SESSION['database']);

		
	}

	public function cariKeterangan($array,$keterangan){
		
		
	}

	public function updateKeterangan($array,$keterangan){
		if (cariKeterangan($array,$keterangan)==0) {
			array_push($array, $keterangan);
		}
		
	}

}
?>
