<!DOCTYPE html>
<html>
<head>
	<title>Storage Example</title>
</head>
<body>
<!-- <a href='#' id="dnperm">Reuqest Permission</a><br /><br />
Username: <input type="text" id="username" /><br/>
Message: <input type="text" id="message" /><br/>
<input type="button" id="btnGetMessage" value="Get Message" /><br/><br/>
<image src = "" id = "myimg" ></image>
<!-- <a id="get_img" download="sajid.jpg">Download img</a> 
<ul id="comment">
</ul> -->

<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<!-- <script src="https://www.gstatic.com/firebasejs/3.6.10/firebase.js"></script> -->
<!-- <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase.js"></script> -->




<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-app.js"></script>

<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-functions.js"></script>

<!-- Comment out (or don't include) services that you don't want to use -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-storage.js"></script>




<script>

	// var dnperm = document.getElementById('dnperm');

	// dnperm.addEventListener('click',function(e){
	// 	e.preventDefault();
	// 	if(!window.Notification){
	// 		alert('Not supported');
	// 	}else{
	// 		Notification.requestPermission().then(function(p){
	// 			if(p=='denied'){
	// 				alert('You denied to show notification');
	// 			}else if(p=='granted'){
	// 				alert('You allowed to show notification');
	// 			}
	// 		});
	// 	}
	// });


	// function writeUserData(name, message) {
	//   database.push().set({
	//     username: name,
	//     message: message
	//   });
	// }

	// function renderUI(obj){
	// 	var html='';
		
	// 	var keys = Object.keys(obj);
	// 	for(var i=0;i<keys.length;i++){
	// 		html+="<li><b><i>"+obj[keys[i]].username+"</i></b> says: "+obj[keys[i]].message+"</li>";
	// 	}
	// 	$('#comment').html(html);
	// }



  // Initialize Firebase
  // TODO: Replace with your project's customized code snippet
  var config = {
    apiKey: "AIzaSyB-O0hzCMMcEEtGPMLcpYHL1ULV5ikt58w",
    authDomain: "fbtest-e7425.firebaseapp.com",
    databaseURL: "https://fbtest-e7425.firebaseio.com",
    projectId: "fbtest-e7425",
    storageBucket: "fbtest-e7425.appspot.com",
    messagingSenderId: "395355079099"
  };
  firebase.initializeApp(config);

  var database = firebase.database().ref("Barcodes");
  //var storage = firebase.storage().ref('images').child('resize_image_004.jpg');
  //var storage = firebase.storage().ref('Barcodes');
  //console.log(storage);

firebase.database().ref('Barcodes').on('value').then(function(snapshot) {
 //var username = (snapshot.val() && snapshot.val().username) || 'Anonymous';
  //console.log(snapshot.val());

$.ajax({
            url: "<?php echo base_url(); ?>firebase/c_firebase/getFirebaseData",
            type: 'POST',
            dataType: 'json',
            data: { 'data' : snapshot.val()},
            success: function (data) {
                console.log("ok");
            }
        });



  //for (var barcode in snapshot.val().Barcodes) {
    //if (snapshot.hasOwnProperty(key)) {
        //console.log(barcode + " -> " + snapshot[key]);
       // console.log(barcode );

        // $.ajax({
        //     url: "<?php //echo base_url(); ?>index.php/seed/c_seed/get_template",
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { 'data' : TempID}
        //     success: function (data) {
        //         console.log("ok");
        //     }
        // });

    //}
//}

  // ...
})


// var gsReference = storage.refFromURL('gs://bucket/images/resize_image_004.jpg');
// console.log(gsReference);
  // database.on('value', function(snapshot) {
  //   renderUI(snapshot.val());
  // });

  // database.on('child_added', function(data) {
  //   	if(Notification.permission!=='default'){
		// 			var notify;
					
		// 				notify= new Notification('New message from '+data.val().username,{
		// 					'body': data.val().message,
		// 					'icon': 'images.jpeg',
		// 					'tag': data.getKey()
		// 				});

		// 				notify.onclick = function(){
		// 					alert(this.tag);
		// 				}

		// }else{
		// 	alert('Please allow the notification first');
		// }
  // });


</script>
</body>
</html>