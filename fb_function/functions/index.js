/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for t`he specific language governing permissions and
 * limitations under the License.
 */
'use strict';

const functions = require('firebase-functions');
const request = require('request');
//const mkdirp = require('mkdirp-promise');
// Include a Service Account Key to use a Signed URL
//const gcs = require('@google-cloud/storage')({keyFilename: 'service-account-credentials.json'});
//const {Storage} = require('@google-cloud/storage');
const admin = require('firebase-admin');
admin.initializeApp();
//const spawn = require('child-process-promise').spawn;
//const path = require('path');
//const os = require('os');
//const fs = require('fs');


const pull_url = 'http://71.78.236.20/laptopzone/cron_job/c_cron_job/pullOrders';

exports.getOrders = functions.database.ref('PlateformNotification/ebay/itemSold/{key}').onCreate((snapshot,context) => {
  const data = snapshot.val();
  const Timestamp = data.Timestamp;
  const merchantName = data.merchant_name;
  const NotificationEventName = data.NotificationEventName;
  const ItemID = data.ItemID;
  const nodeKey = context.params.key;
  console.log('key:' + nodeKey + ' Timestamp: '+ Timestamp + 'merchantName: ' + merchantName);

  /*====================================
  =            send request            =
  ====================================*/
    const paramsObject = {'Timestamp':Timestamp,'merchantName':merchantName , 'NotificationEventName': NotificationEventName , 'ItemID':ItemID};
    // const paramsObject = {'parm_order':JSON.stringify(snap.val())};
    request({url:pull_url, qs:paramsObject}, (error, response, body) => {
        if (!error && response.statusCode === 200) {
            console.log(body);
        }
        else
        {
            console.error(error);
        }
    });

  /*=====  End of send request  ======*/

  return true;
  });