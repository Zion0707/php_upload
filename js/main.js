$(function(){



	// 以form方式 提交
	// $('#myFile').on('change',function(){

	// 	var fileObj = document.getElementById('myFile').files[0];
	// 	var formData = new FormData();
	// 	formData.append('file',fileObj);
	// 	formData.append('uploadType',0); //表示上传图片

	// 	$.ajax({
	// 		type:'POST',
	// 		dataType: "json",
	// 		url:'api/Upload.class.php',
	// 		data:formData,
	// 		cache: false,//上传文件无需缓存
 //           	processData: false,//用于对data参数进行序列化处理 这里必须false
 //           	contentType: false, //必须
	// 		success(data){
	// 			console.log(data);
	// 			if (data.code==0) {
	// 				$('#myPic').attr('src','learn/'+data.url);
	// 			}else{
	// 				alert(data.msg);
	// 			}
	// 		}
	// 	});
		
	// });


	// 文件预览
	$('#myFile').on('change',function(e){
		var file = e.target.files[0];
	    if(window.FileReader) {
	         var fr = new FileReader();
	          fr.readAsDataURL(file);
	          fr.onloadend = function(e) {
	              base64Data = e.target.result;
	              $('#myPic').attr('src',base64Data);
	          }
	    }
		
	});


	//富文本创建	
	var E = window.wangEditor;
    var editor = new E('#editor');
    // 或者 var editor = new E( document.getElementById('editor') );
    editor.create();

	//提交信息
	$('#submit').on('click',function(){

		if ( $('#myPic').attr('src')=='' || editor.txt.html() == '' ) {
			alert('请上传图片和填写文本信息！');
			return;
		}

		$.ajax({
			type:'POST',
			dataType: "json",
			url:'api/Upload.class.php',
			data:{
				uploadType: 1, //表示上传所有信息
				imgUrl: $('#myPic').attr('src'),
				richText: editor.txt.html()
			},
			success(data){
				if (data.code==0) {
					alert(data.msg);
					$('#resPic').show().attr('src','learn/'+data.imgUrl);
					$('#resHtml').html(data.richText);
				}else{
					alert(data.msg);
				}
			}
		});
	});
});