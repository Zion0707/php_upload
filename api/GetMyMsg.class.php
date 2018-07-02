<?php 
	
	
	require_once('Main.class.php');
	use main\Main as MyMain;

	/**
	* 获取详情类
	*/
	class GetMyMsg
	{
		
		public function __construct()
		{
			# code...
		}

		public function toGetMyMsg(){
			$MyMain=new MyMain();
			$pdo=$MyMain->connDb();

			$sql="SELECT * FROM my_msg";
			$res=$pdo->prepare($sql);
			$res->execute();
			$arr=array();
			while ( $row = $res->fetch(PDO::FETCH_ASSOC) ) {
				$arr[]=$row;
			}




			$photoName = '1111.png';
			if (preg_match_all('/\.jpg$|\.png$/i', $photoName)) {
				echo '找到';
			}else{
				echo '未找到';
			}


		}

	}




	$GetMyMsg=new GetMyMsg();
	$GetMyMsg->toGetMyMsg();