var firebase = require("firebase");

// download file from stamps url

  // Initialize Firebase
var config = {
    apiKey: "AIzaSyB-O0hzCMMcEEtGPMLcpYHL1ULV5ikt58w",
    authDomain: "fbtest-e7425.firebaseapp.com",
    databaseURL: "https://fbtest-e7425.firebaseio.com",
    projectId: "fbtest-e7425",
    storageBucket: "fbtest-e7425.appspot.com",
    messagingSenderId: "395355079099"
  };
  firebase.initializeApp(config);

  var database = firebase.database().ref("dataToDownload/Barcode");
  //var BarcodeRef = firebase.database().ref("Barcodes");

const { URL } = require('url');

var request = require('request');

var pull_url = 'http://71.78.236.20/laptopzone/firebase/c_firebase/getFbData';
//var pull_url = 'http://localhost/laptopzone/firebase/c_firebase/getFbData';

database.on('value',snapshot => {
 console.log('Downloade Data for barocde:'+ snapshot.val());//return;
/*==================================================
    =            get data from barcode node            =
    ==================================================*/
    //firebase.database().ref('Barcodes/'+snapshot.val()).once('value').then(function(childsnapshot) {

        firebase.database().ref('Barcodes/'+snapshot.val()).once('value',childsnapshot => {
        var paramsObject = {'parm_order':JSON.stringify(childsnapshot.val()),'barcode':snapshot.val()};
        //console.log(JSON.stringify(childsnapshot.val()));return;

        request({url:pull_url, qs:paramsObject}, function(err, response, body) {
          if(err) { console.log(err); return; }
          console.log("Response: " + body);
        });
    });
    /*=====  End of get data from barcode node  ======*/

});
// var paramsObject = { userId:12345 };
//database.on('child_changed').then(function(snapshot) {
   // console.log(snapshot.val());return;
    /*==================================================
    =            get data from barcode node            =
    ==================================================*/
    // firebase.database().ref('Barcodes/'+snapshot.val()).on('value').then(function(snapshot) {
    //     var paramsObject = {'parm_order':JSON.stringify(snap.val())};
    //     request({url:pull_url, qs:paramsObject}, function(err, response, body) {
    //       if(err) { console.log(err); return; }
    //       console.log("Response: " + body);
    //     });
    // });
    /*=====  End of get data from barcode node  ======*/
    
//});

