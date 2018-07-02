<?php 
	
	
	require_once('Main.class.php');
	use main\Main as MyMain; //转换命名空间

	/**
	* 上传类
	*/
	class Upload
	{
		
		public function __construct()
		{
			# code...
		}


		//前端form形式提交的文件
		public function toUpload($post){
			$postData = json_decode(json_encode( $post ));

			if ( $_FILES['file']['error'] > 0 ) {
				echo json_encode(array(
					'code'=>-2,
					'msg'=>'文件错误，请重新提交！'
				));
			}else{
				$name = explode('.',$_FILES['file']['name']);
				$url = '../upload/'.time().'.'.$name[1];
				move_uploaded_file($_FILES['file']['tmp_name'], $url);

				echo json_encode(array(
					'code'=>0,
					'msg'=>'上传成功！',
					'url'=>$url,
					'uploadType'=>$postData->uploadType
				));
			}
		}




		/**
		 * [将Base64图片转换为本地图片并保存]
		 * @param  [Base64] $base64_image_content [要保存的Base64]
		 * @param  [目录] $path [要保存的路径]
		 */
		public function base64_image_content($base64_image_content,$path){
		    //匹配出图片的格式
		    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
		        $type = $result[2];
		        $new_file = $path."/";
		        if(!file_exists($new_file)){
		            //检查是否有该文件夹，如果没有就创建，并给予最高权限
		            mkdir($new_file, 0700);
		        }
		        $new_file = $new_file.time().".{$type}";
		        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
		            return $new_file;
		        }else{
		            return false;
		        }
		    }else{
		        return false;
		    }
		}




		//前端base64文件的转换操作
		public function conversionUp($post){	
			$postData = json_decode(json_encode( $post ));
			//转成本地路径图片文件
		   	$imgUrl = $this->base64_image_content($postData->imgUrl,'../upload');
		   	$richText = $postData->richText;
		   	
		   	//如果存在则返回
		   	if ( $imgUrl && $richText ) {

		   		//连接数据库并把前端传过来的数据插入到数据库
		   		$MyMain = new MyMain();
		   		$pdo = $MyMain->connDb();

		   		//处理sql插入
		   		$stmt = $pdo->prepare('INSERT INTO my_msg(`imgUrl`,`richText`) VALUES (?,?)');
		   		$stmt->bindParam(1,$imgUrl);
		   		$stmt->bindParam(2,$richText);
		   		$q = $stmt->execute();

		   		//判断处理
		   		if ( $q ) {
			   		echo json_encode(array(
			   			'code'=> 0,
			   			'msg'=> '上传成功！',
			   			'imgUrl'=> $imgUrl,
			   			'richText'=> $richText
			   		));
		   		}else{
		   			echo json_encode(array(
			   			'code'=>-2,
			   			'msg'=>'提交失败，请重新提交！'
			   		));
		   		}
		   	}else{
		   		echo json_encode(array(
		   			'code'=>-2,
		   			'msg'=>'提交失败，请重新提交！'
		   		));
		   	}
		}

	}



	if ( isset($_POST) ) {
		switch($_POST['uploadType']){
			case 0;	
				$Upload=new Upload();
				$Upload->toUpload($_POST);
			break;
			case 1:
				$Upload=new Upload();
				$Upload->conversionUp($_POST);
			break;
		}
	}

	