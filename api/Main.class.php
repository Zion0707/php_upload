<?php
	
	//命名空间
	namespace main;
	use PDO; //用了main，就相当于取main目录下面的PDO了，但是PDO是PHP带的，不在main里，所以需要注册一下使用use PDO;
	
	/**
	* 公共类
	*/
	class Main
	{
		
		private $pdo;
		function __construct()
		{
			
		}
		// 连接数据库
		public function connDb(){
			//连接数据库
			try {
				$this->pdo = new PDO('mysql:host=localhost:3306;dbname=phpLearn','root','Zion');
			} catch (PDOException $e) {
				die( $e->getMessage() );
			}
			//设置为debug模式
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//设置为utf8
			$this->pdo->exec('set names utf8');

			return $this->pdo;
		}
	}

