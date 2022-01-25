function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + '';
  return time;
}


function Process(){
	var datas = {
		'dt':$("#datepicker").val(),
		'fl':$("#JSONFrom").val(),
		'tl':$("#JSONTo").val(),
		't':1,
		'trainN':$("#JSONTrain").val(),
		'cl':$("#JSONClass").val(),
		'c':$("#JSONCar").val(),
		's':$("#JSONSeat").val(),
		'fname':$("#JSONFamilly").val(),
		'sname':$("#JSONName").val(),
		'KID':$("#key").val()
	};
	$.ajax({
		type:'POST',
		url:'process.php',
		data:{
			action:'sign',
			JSON_Data:datas
		},
		success:function(data){
			var nData = JSON.parse(data);
			$("#baseCode").html("<b>ID:</b>"+nData['id']+"<br> <b>Valid until:</b>"+timeConverter(nData['vuntil'])+"");
			$("#QRCODE").html("<img src='"+nData['image']+"' width='400' height='400'>")
			console.log(data);
			}
	});
}

function VerifySignature(message){
	$.ajax({
		type:'POST',
		url:'process.php',
		data:{
			action:'verify',
			message:message
		},
		success:function(data){
			var nData = JSON.parse(data);
			var symbol = '';
			var color = '';
			var alert = '';
			if (nData['status'] == true){
				alert = 'success';
			}else{
				alert = 'danger';
			}
			$("#Signature").html("<div class='content'><table class='contentTable'><tr><th><div class='alert alert-"+alert+"' role='alert'>Ticket is "+nData['message']+"</div></th></tr><tr><td><b>"+nData['name']+"</b></td></tr><tr><th>Train:</th></tr><tr><td>Name:<b>"+nData['v']+"</b></td></tr><tr><td>From:<b>"+nData['fl']+"("+timeConverter(nData['dt'])+")</b></td></tr><tr><td>To:<b>"+nData['tl']+"("+timeConverter(nData['at'])+")</b></td></tr><tr><th>Ticket:</th></tr><tr><td>ID:<b>"+nData['id']+"</b></td></tr><tr><td>Valid until:<b>"+timeConverter(nData['vuntil'])+"</b></td></tr><tr><td>Class:<b>"+nData['cl']+"</b></td></tr><tr><td>Car:<b>"+nData['c']+"</b></td></tr><tr><td>Seat:<b>"+nData['s']+"</b></td></tr></table></div>");
			
		}
	});
}