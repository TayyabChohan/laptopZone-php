(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{28:function(e,t,a){e.exports=a(40)},34:function(e,t,a){},39:function(e,t,a){e.exports=a.p+"static/media/logo.5d5d9eef.svg"},40:function(e,t,a){"use strict";a.r(t);var n=a(0),l=a.n(n),s=a(13),c=a.n(s),r=(a(34),a(7)),i=a(8),o=a(11),m=a(9),d=a(10),u=function(e){function t(){return Object(r.a)(this,t),Object(o.a)(this,Object(m.a)(t).apply(this,arguments))}return Object(d.a)(t,e),Object(i.a)(t,[{key:"render",value:function(){return l.a.createElement(l.a.Fragment,null,l.a.createElement("header",{className:"main-header"},l.a.createElement("a",{href:"../../index2.html",className:"logo"},l.a.createElement("span",{className:"logo-lg"},l.a.createElement("b",null,"Laptop"),"Zone")),l.a.createElement("nav",{className:"navbar navbar-static-top"},l.a.createElement("a",{href:"#",className:"sidebar-toggle","data-toggle":"push-menu",role:"button"},l.a.createElement("span",{className:"sr-only"},"Toggle navigation"),l.a.createElement("span",{className:"icon-bar"}),l.a.createElement("span",{className:"icon-bar"}),l.a.createElement("span",{className:"icon-bar"})),l.a.createElement("div",{className:"navbar-custom-menu"},l.a.createElement("ul",{className:"nav navbar-nav"},l.a.createElement("li",null,l.a.createElement("a",{href:"#","data-toggle":"control-sidebar"},l.a.createElement("i",{className:"fa fa-gears"}))))))))}}]),t}(l.a.Component),p=a(12),h=function(e){function t(){return Object(r.a)(this,t),Object(o.a)(this,Object(m.a)(t).apply(this,arguments))}return Object(d.a)(t,e),Object(i.a)(t,[{key:"render",value:function(){return l.a.createElement(l.a.Fragment,null,l.a.createElement("section",{className:"content-header"},l.a.createElement("h1",null,"roniew",l.a.createElement("small",null,"asad")),l.a.createElement("ol",{className:"breadcrumb"},l.a.createElement("li",null,l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-dashboard"})," Home")),l.a.createElement("li",null,l.a.createElement("a",{href:"#"},"Tables")),l.a.createElement("li",{className:"active"},"Data tables"))),l.a.createElement("section",{className:"content"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box"},l.a.createElement("div",{className:"box-header"},l.a.createElement("h3",{className:"box-title"},"data1")),l.a.createElement("div",{className:"box-body"},l.a.createElement("div",{className:"input-group"},l.a.createElement("input",{type:"text",name:"q",className:"form-control",placeholder:"Search..."}),l.a.createElement("span",{className:"input-group-btn"},l.a.createElement("button",{type:"submit",name:"search",id:"search-btn",className:"btn btn-flat"},l.a.createElement("i",{className:"fa fa-search"}))))))))))}}]),t}(l.a.Component),E=a(2),b=a.n(E),N=function(e){function t(e){var a;Object(r.a)(this,t);var n=window.location,l=n.protocol+"//"+n.hostname;return(a=Object(o.a)(this,Object(m.a)(t).call(this,e))).state={error:null,isLoaded:!1,items:[],baseUrl:l},a}return Object(d.a)(t,e),Object(i.a)(t,[{key:"componentDidMount",value:function(){var e=this;fetch(this.state.baseUrl+"/laptopzone/restgetcontroller/get_unposted_items").then(function(e){return e.json()}).then(function(t){e.setState({isLoaded:!0,items:t.get_items})},function(t){e.setState({isLoaded:!1,error:t})})}},{key:"render",value:function(){var e=this.state,t=e.error,a=e.isLoaded,n=e.items;return t?l.a.createElement("div",null," Error: ",t.message):a?l.a.createElement(l.a.Fragment,null,l.a.createElement("section",{className:"content-header"},l.a.createElement("h1",null,"Item",l.a.createElement("small",null,"Recognition")),l.a.createElement("ol",{className:"breadcrumb"},l.a.createElement("li",null,l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-dashboard"})," Home")),l.a.createElement("li",null,l.a.createElement("a",{href:"#"},"Tables")),l.a.createElement("li",{className:"active"},"Unposted Items"))),l.a.createElement("section",{className:"content"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box"},l.a.createElement("div",{className:"box-header"},l.a.createElement("h3",{className:"box-title"},"Unposted Items")),l.a.createElement("div",{className:"box-body"},l.a.createElement("table",{id:"example2",className:"table table-bordered table-hover"},l.a.createElement("thead",null,l.a.createElement("tr",null,l.a.createElement("th",null,"Action"),l.a.createElement("th",null,"Barcode No"),l.a.createElement("th",null,"Condition"),l.a.createElement("th",null,"Object"),l.a.createElement("th",null,"Mpn Desc"),l.a.createElement("th",null,"Mpn"),l.a.createElement("th",null,"Upc"),l.a.createElement("th",null,"Pic Date"),l.a.createElement("th",null,"Pic By"),l.a.createElement("th",null,"Remarks"),l.a.createElement("th",null,"Folder Name"),l.a.createElement("th",null,"Item Type"))),l.a.createElement("tbody",null,n.map(function(e){return l.a.createElement("tr",{key:e.BARCODE_PRV_NO},l.a.createElement("td",null,l.a.createElement(p.b,{to:{pathname:"/varify",state:{barcodePass:e.BARCODE_PRV_NO}}},l.a.createElement("button",{className:"btn btn-info pull-left"},"Edit"))),l.a.createElement("td",null,e.BARCODE_PRV_NO),l.a.createElement("td",null,e.COND_NAME),l.a.createElement("td",null,e.OBJECT_NAME),l.a.createElement("td",null,e.MPN_DESC),l.a.createElement("td",null,e.MPN),l.a.createElement("td",null,e.UPC),l.a.createElement("td",null,e.PIC_DATE_TIME),l.a.createElement("td",null,e.PIC_BY),l.a.createElement("td",null,e.REMARKS),l.a.createElement("td",null,e.FOLDER_NAME),l.a.createElement("td",null,e.BAROCDE_TYPE))}))))))))):l.a.createElement("section",{className:"content-header"},l.a.createElement("h1",null,"LOADING......"),l.a.createElement("ol",{className:"breadcrumb"},l.a.createElement("li",null,l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-dashboard"})," Home")),l.a.createElement("li",null,l.a.createElement("a",{href:"#"},"Tables")),l.a.createElement("li",{className:"active"},"Unposted Items")))}}]),t}(l.a.Component),v=a(16),f=a(4),g=function(e){function t(e){var a;Object(r.a)(this,t);var n=window.location,l=n.protocol+"//"+n.hostname;return(a=Object(o.a)(this,Object(m.a)(t).call(this,e))).state={baseUrl:l,error:null,isLoaded:!1,conditions:[],shipname:[],tempData:[],itemTitle:"",categId:"",categName:"",defCond:"",hidenCond:"",retAccept:"",defCondDis:"",listRule:"",price:"",qty:"",shipServ:"",retDay:"",otherNote:"",bin:"",editTemp:"",epId:"",hiddenItemId:"",seedUpc:"",seedMpn:"",seedBrand:"",getBarcode:a.props.passBarcode,showSpecific:!1,specQueryVal:[],specificValQuery:[],arrayCount:"",arrayCat:"",custom_name:"",custom_value:"",messg:"Loading ....."},a.handleInput=a.handleInput.bind(Object(f.a)(Object(f.a)(a))),a.closeSpecific=a.closeSpecific.bind(Object(f.a)(Object(f.a)(a))),a.saveSpecific=a.saveSpecific.bind(Object(f.a)(Object(f.a)(a))),a.saveCustomSpecific=a.saveCustomSpecific.bind(Object(f.a)(Object(f.a)(a))),a}return Object(d.a)(t,e),Object(i.a)(t,[{key:"componentDidMount",value:function(){console.log(this.state.getBarcode),b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_dropdowns",dataType:"json",type:"POST",data:{barocde:this.state.getBarcode},success:function(e){1==e.exist?this.setState({isLoaded:!0,conditions:e.condition_quer,shipname:e.ship_quer,tempData:e.temp_data,hiddenItemId:e.seed_data[0].ITEM_ID,seedUpc:e.seed_data[0].UPC,seedMpn:e.seed_data[0].MFG_PART_NO,seedBrand:e.seed_data[0].MANUFACTURER,itemTitle:e.seed_data[0].ITEM_MT_DESC,categId:e.seed_data[0].CATEGORY_ID,categName:e.seed_data[0].CATEGORY_NAME,defCond:e.seed_data[0].DEFAULT_COND,hidenCond:e.seed_data[0].DEFAULT_COND,defCondDis:e.seed_data[0].DETAIL_COND,price:e.seed_data[0].EBAY_PRICE,shipServ:e.seed_data[0].SHIPPING_SERVICE,bin:e.seed_data[0].BIN_NAME,editTemp:e.seed_data[0].TEMPLATE_ID,retDay:e.seed_data[0].RETURN_DAYS,retAccept:e.seed_data[0].RETURN_OPTION,otherNote:e.seed_data[0].OTHER_NOTES,qty:e.list_qty[0].QTY}):this.setState({isLoaded:!1})}.bind(this),error:function(e,t,a){console.log(e,t,a)}}),b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_pictures",dataType:"json",type:"POST",data:{barocde:this.state.getBarcode},success:function(e){1==e.exist&&this.setState({})}.bind(this),error:function(e,t,a){console.log(e,t,a)}})}},{key:"handleInput",value:function(e){var t=e.target.name;this.setState(Object(v.a)({},t,e.target.value))}},{key:"handleForm",value:function(){var e=this.state.seedUpc,t=this.state.seedMpn,a=this.state.seedBrand,n=this.state.itemTitle,l=this.state.categId,s=this.state.categName,c=this.state.defCond,r=this.state.defCondDis,i=this.state.hidenCond,o=this.state.price,m=this.state.shipServ,d=this.state.bin,u=this.state.editTemp,p=this.state.retDay,h=this.state.retAccept,E=this.state.otherNote;this.setState({isLoaded:!1}),b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/update_seed",dataType:"json",type:"POST",data:{barocde:this.state.getBarcode,seedUpc:e,seedMpn:t,seedBrand:a,itemTitle:n,categId:l,categName:s,defCond:c,defCondDis:r,hidenCond:i,price:o,shipServ:m,bin:d,editTemp:u,retDay:p,retAccept:h,otherNote:E},success:function(e){e?this.setState({isLoaded:!0,hidenCond:this.state.defCondDis,messg:"Updating Seed ..."}):this.setState({isLoaded:!0})}.bind(this),error:function(e,t,a){}})}},{key:"updateSpecific",value:function(){this.setState({showSpecific:!0}),b()("#spec").focus(),b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/queryData",dataType:"json",type:"POST",data:{barocde:this.state.getBarcode},success:function(e){if(e){var t=e.mt_id.length;console.log(e.mt_id),console.log(e.specs_qry),this.setState({specQueryVal:e.mt_id,specificValQuery:e.specs_qry,arrayCount:t,arrayCat:e.mt_id[0].EBAY_CATEGORY_ID,showSpecific:!0})}else this.setState({showSpecific:!1})}.bind(this),error:function(e,t,a){}})}},{key:"saveSpecific",value:function(){for(var e=b()("#arrayCount").val(),t=this.state.hiddenItemId,a=this.state.seedMpn,n=this.state.seedUpc,l=this.state.categId,s=[],c=[],r=1;r<=e;r++)s.push(b()("#specific_name_"+r).text()),c.push(b()("#specific_"+r).val());console.log(s),console.log(c),b.a.ajax({dataType:"json",type:"POST",url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/add_specifics",data:{item_id:t,cat_id:l,spec_name:s,spec_value:c,item_upc:n,item_mpn:a},success:function(e){return""!=e?(alert("Item Specific Updated"),!1):(alert("Error:UPC & MPN not found"),!1)}})}},{key:"saveCustomSpecific",value:function(){var e=this.state.categId,t=this.state.custom_name,a=this.state.custom_value;b()("#maxValue").val(),b()("#selectionMode").val(),b()("#catalogue_only").val();return""==t||null==t?(alert("Please insert specific name"),b()("#custom_name").focus(),!1):""==a||null==a?(alert("Please insert specific value"),b()("#custom_value").focus(),!1):void b.a.ajax({dataType:"json",type:"POST",url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/add_custom_specifics",data:{cat_id:e,custom_name:t,custom_value:a},success:function(e){return 0==e?(alert("Specific name is already exist."),!1):(alert("Record successfully added."),!1)}})}},{key:"closeSpecific",value:function(){this.setState({showSpecific:!1})}},{key:"render",value:function(){var e=this,t=this,a=this.state,n=a.error,s=a.isLoaded;a.conditions;if(n)return l.a.createElement("div",null," Error: ",n.message);if(s){var c=this.state.conditions.map(function(e){return l.a.createElement("option",{key:e.ID,value:e.ID},e.COND_NAME)}),r=this.state.shipname.map(function(e){return l.a.createElement("option",{key:e.SHIPING_NAME,value:e.SHIPING_NAME},e.SHIPING_NAME)}),i=this.state.tempData.map(function(e){return l.a.createElement("option",{key:e.TEMPLATE_ID,value:e.TEMPLATE_ID},e.TEMPLATE_NAME)}),o=this.state.specQueryVal.map(function(e,a){var n=a+1,s="specific_name_"+n,c="specific_"+n;e.MT_ID;return l.a.createElement("div",{key:a,className:"col-sm-3"},l.a.createElement("label",{id:s},e.SPECIFIC_NAME),l.a.createElement("select",{className:"form-control  ",id:c},l.a.createElement("option",{value:"select"},"------------Select------------"),t.state.specificValQuery.map(function(t,a){if(t.MT_ID==e.MT_ID)return l.a.createElement(l.a.Fragment,null,l.a.createElement("option",{key:a,value:t.SPECIFIC_VALUE},t.SPECIFIC_VALUE))})))});return l.a.createElement(l.a.Fragment,null,l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("h3",{align:"center"},"Item Seed.."),l.a.createElement("div",{className:"box box-info"},l.a.createElement("div",{className:"box-body"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Seed Upc:"),l.a.createElement("input",{type:"hidden",className:"form-control",name:"hiddenItemId",value:this.state.hiddenItemId,onChange:this.handleInput}),l.a.createElement("input",{type:"text",className:"form-control",name:"seedUpc",value:this.state.seedUpc,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Seed Mpn:"),l.a.createElement("input",{type:"text",className:"form-control",name:"seedMpn",value:this.state.seedMpn,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Seed Brand:"),l.a.createElement("input",{type:"text",className:"form-control",name:"seedBrand",value:this.state.seedBrand,onChange:this.handleInput}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Master Pictures:"),l.a.createElement("input",{type:"text",className:"form-control",name:"",value:""}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Dekit Remarks:"),l.a.createElement("input",{type:"text",className:"form-control",name:"",value:""}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Picture Notes:"),l.a.createElement("input",{type:"text",className:"form-control",name:"",value:""}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Title:"),l.a.createElement("input",{type:"text",className:"form-control",name:"itemTitle",value:this.state.itemTitle,onChange:this.handleInput}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Category Id:"),l.a.createElement("input",{type:"number",className:"form-control",name:"categId",value:this.state.categId,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Category Name:"),l.a.createElement("input",{type:"name",className:"form-control",name:"categName",value:this.state.categName,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("label",null,"Default Condition:"),l.a.createElement("input",{type:"hidden",className:"form-control",name:"hidenCond",value:this.state.hidenCond,onChange:this.handleInput}),l.a.createElement("select",{className:"form-control selectpicker ",name:"defCond",value:this.state.defCond,onChange:this.handleInput},l.a.createElement("option",{value:"0"},"Select Condiotion.. "),c)),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("label",null,"Return Accepted:"),l.a.createElement("select",{className:"form-control selectpicker ",name:"retAccept",value:this.state.retAccept,onChange:this.handleInput},l.a.createElement("option",{value:"0"},"Select Option.. "),l.a.createElement("option",{value:"ReturnsAccepted"},"Yes"),l.a.createElement("option",{value:"ReturnsNotAccepted"},"No")))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Default Condition Description:"),l.a.createElement("textarea",{style:{color:"red"},type:"text",className:"form-control",name:"defCondDis",value:this.state.defCondDis,onChange:this.handleInput}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Listing Rule:"),l.a.createElement("textarea",{type:"text",className:"form-control",name:"listRule",value:this.state.listRule}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-2 "},l.a.createElement("label",null,"Price:"),l.a.createElement("div",{className:"input-group "},l.a.createElement("span",{className:"input-group-addon"},"US $"),l.a.createElement("input",{type:"number",step:"0.01",min:"0",className:"form-control",name:"price",value:this.state.price,onChange:this.handleInput}))),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"QTY:"),l.a.createElement("input",{type:"number",className:"form-control",name:"qty",disabled:!0,value:this.state.qty,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Hold Barcode:"),l.a.createElement("input",{type:"text",className:"form-control",name:"",value:""})),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Bin:"),l.a.createElement("input",{type:"text",className:"form-control",name:"bin",value:this.state.bin,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Other Notes:"),l.a.createElement("input",{type:"text",className:"form-control",name:"otherNote",value:this.state.otherNote,onChange:this.handleInput}))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-4"},l.a.createElement("label",null,"Shipping Service:"),l.a.createElement("select",{className:"form-control selectpicker ",name:"shipServ",value:this.state.shipServ,onChange:this.handleInput},l.a.createElement("option",{value:"0"},"Select Shipping.. "),r)),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Return In Days:"),l.a.createElement("select",{className:"form-control selectpicker ",name:"retDay",value:this.state.retDay,onChange:this.handleInput},l.a.createElement("option",{value:"14"},"14 Days"),l.a.createElement("option",{value:"30"},"30 Days"),l.a.createElement("option",{value:"60"},"60 Days"))),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("label",null,"Edit Templete:"),l.a.createElement("select",{className:"form-control selectpicker ",name:"editTemp",value:this.state.editTemp,onChange:this.handleInput},l.a.createElement("option",{value:"0"},"Select Shipping.. "),i)),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("label",null,"Epid:"),l.a.createElement("input",{type:"number",className:"form-control",name:"epId",value:this.state.epId,onChange:this.handleInput})))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box-footer",align:"center"},l.a.createElement("button",{onClick:function(){e.handleForm()},className:"btn btn-success pull-left"},"Update"),l.a.createElement("button",{onClick:function(){e.updateSpecific()},className:"btn btn-warning pull-left"},"Update Specifics"),l.a.createElement("button",{className:"btn btn-danger pull-right"},"List"))))))),this.state.showSpecific?l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-sm-12"},l.a.createElement("div",{className:"box box-warning"},l.a.createElement("div",{className:"box-header with-border"},l.a.createElement("h3",{className:"box-title"},"Item Specifics "),l.a.createElement("div",{className:"box-tools pull-right"},l.a.createElement("button",{type:"button",className:"btn btn-danger btn-sm",onClick:function(){e.closeSpecific()},title:"Close"},l.a.createElement("i",{className:"fa fa-times"})))),l.a.createElement("div",{className:"box-body"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-sm-12"},l.a.createElement("input",{type:"hidden",name:"arrayCount",id:"arrayCount",value:this.state.arrayCount}),l.a.createElement("input",{type:"hidden",name:"arrayCat",id:"arrayCat",value:this.state.arrayCat}),o)),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box-footer",align:"right"},l.a.createElement("button",{type:"button",className:"btn btn-success pull-right",onClick:function(){e.saveSpecific()}},"Save")))),l.a.createElement("br",null),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("h4",null,"Add your own item specific")),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("input",{type:"text",className:"form-control",placeholder:"Enter item specific name",id:"custom_name",name:"custom_name",value:this.state.custom_name,onChange:this.handleInput}),l.a.createElement("span",null,"For example, Brand, Material, or Year")),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("input",{type:"text",className:"form-control",placeholder:"Enter item specific value",id:"custom_value",name:"custom_value",value:this.state.custom_value,onChange:this.handleInput}),l.a.createElement("span",null,"For example, Ty, plastic, or 2007")),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("button",{type:"button",className:"btn btn-success ",onClick:function(){e.saveCustomSpecific()}},"Save"))))))):null)}return l.a.createElement("div",null,l.a.createElement("h1",null,this.state.messg))}}]),t}(l.a.Component);a(39);function y(e){return l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("label",null,"Available Condition"),e.data.map(function(t,a){return l.a.createElement(l.a.Fragment,{key:a},"\xa0",l.a.createElement("input",{type:"radio",name:"condRadio",onChange:e.handle,value:t.CONDITION_ID}),"\xa0",l.a.createElement("span",null,t.COND_NAME))}))}function _(e){return l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box"},l.a.createElement("div",{className:"box-header"},l.a.createElement("h3",{className:"box-title"},"History Title Against (",e.boxHead,")"),l.a.createElement("div",{className:"box-tools pull-right"},l.a.createElement("button",{type:"button",className:"btn btn-danger btn-sm",onClick:function(){e.closePane()},title:"Close"},l.a.createElement("i",{className:"fa fa-times"})))),l.a.createElement("div",{className:"box-body"},l.a.createElement("table",{id:"example2",className:"table table-bordered table-hover"},l.a.createElement("thead",null,l.a.createElement("tr",null,l.a.createElement("th",null,"Category Id"),l.a.createElement("th",null,"Title"),l.a.createElement("th",null,"Mpn"),l.a.createElement("th",null,"Upc"),l.a.createElement("th",null,"Object"),l.a.createElement("th",null,"Brand"),l.a.createElement("th",null,"Condition"),l.a.createElement("th",null,"Select"))),l.a.createElement("tbody",null,e.data.map(function(t,a){return l.a.createElement("tr",{key:a},l.a.createElement("td",null,t.CATE),l.a.createElement("td",null,t.TITLE),l.a.createElement("td",null,t.MPN),l.a.createElement("td",null,t.UPC),l.a.createElement("td",null,t.OBJECT_NAME),l.a.createElement("td",null,t.BRAND),l.a.createElement("td",null,t.COND_NAME),l.a.createElement("td",null,l.a.createElement("button",{type:"button",className:"btn btn-danger pull-right btn-sm",onClick:function(){e.serchtest(a+1)}},"Select")))})))))))}var C=function(e){function t(e){var a;Object(r.a)(this,t);var n=window.location,l=n.protocol+"//"+n.hostname;return(a=Object(o.a)(this,Object(m.a)(t).call(this,e))).state={baseUrl:l,error:null,isLoaded:!1,showSeed:"hide",UpcTitleCheck:!1,MpnTitleCheck:!1,CondCheck:!1,mpnTitle:[],seedVal:"1",objects:[],conditions:[],barcodeNo:"",itemType:"",idS:"",upcNum:"",mpnName:"",objName:"",catId:"",brandName:"",mpnDesc:"",remarks:"",avgSold:"",getCond:"",boxHeader:"",availCond:[],condRadio:""},a.handleForm=a.handleForm.bind(Object(f.a)(Object(f.a)(a))),a.handleInput=a.handleInput.bind(Object(f.a)(Object(f.a)(a))),a.serchMpn=a.serchMpn.bind(Object(f.a)(Object(f.a)(a))),a.serchtest=a.serchtest.bind(Object(f.a)(Object(f.a)(a))),a.closePane=a.closePane.bind(Object(f.a)(Object(f.a)(a))),a}return Object(d.a)(t,e),Object(i.a)(t,[{key:"componentDidMount",value:function(){var e=this,t=this.props.location.state.barcodePass;fetch(this.state.baseUrl+"/laptopzone/restgetcontroller/get_obj_drop").then(function(e){return e.json()}).then(function(t){e.setState({isLoaded:!0,objects:t.get_obj_itm})},function(t){e.setState({isLoaded:!0,error:t})}),fetch(this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_verify_item/"+t).then(function(e){return e.json()}).then(function(t){console.log(t),e.setState({barcodeNo:t.get_items[0].BARCODE_PRV_NO,itemType:t.get_items[0].BAROCDE_TYPE,idS:t.get_items[0].IDS,upcNum:t.get_items[0].UPC,mpnName:t.get_items[0].MPN,catId:t.get_items[0].CATEGORY_ID,brandName:t.get_items[0].BRAND,mpnDesc:t.get_items[0].MPN_DESC,remarks:t.get_items[0].REMARKS,avgSold:t.get_items[0].CATEGORY_ID,availCond:t.get_cond,CondCheck:!0})},function(t){e.setState({isLoaded:!0,error:t})}),b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_pictures",dataType:"json",type:"POST",data:{barocde:this.state.barcodeNo},success:function(e){for(var t=[],a=0;a<e.dekitted_pics.length;a++){var n=e.uri[a].split("/"),l=(n[4].substring(1),e.dekitted_pics[a]),s='<img style="width:  220px; height: 180px;" className="sort_img up-img popup_zoom_01" id="'+e.uri[a]+'" name="dekit_image[]" src="data:image;base64,'+l+'"/>';t.push('<li style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;" id="'+n[4]+'"> <span class="tg-li"> <div className="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);  width:99%; height:99%; background: #eee!important; margin:5px;">'+s+' <input type="hidden" name="" value=""> <div className="text-center" style="width: 100px;"> <span className="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" className="fa fa-arrows" aria-hidden="true"></i></span> <span className="d_spn"><i title="Delete Picture" style="padding: 3px;" className="fa fa-trash specific_delete"></i></span> </div> </div> </span> </li> ')}b()("#getsortable").html(""),b()("#getsortable").append(t.join(""))}.bind(this),error:function(e,t,a){console.log(e,t,a)}})}},{key:"handleInput",value:function(e){var t=e.target.name;this.setState(Object(v.a)({},t,e.target.value))}},{key:"handleForm",value:function(e){e.preventDefault(),console.log(this.state.condRadio);var t=this.state.barcodeNo,a=this.state.itemType,n=(this.state.idS,[]);n.push(this.state.idS);var l=this.state.upcNum,s=this.state.mpnName,c=this.state.objName,r=this.state.catId,i=this.state.brandName,o=this.state.mpnDesc,m=this.state.remarks,d=this.state.avgSold;b.a.ajax({url:this.state.baseUrl+"/laptopzone/reactcontroller/c_react/verify_item",dataType:"json",type:"POST",data:{barcodeNo:t,itemType:a,idArray:n,upcNum:l,mpnName:s,objName:c,catId:r,brandName:i,mpnDesc:o,remarks:m,avgSold:d},success:function(e){1==e.exist?this.setState({showSeed:"show"}):0==e.exist&&this.setState({showSeed:"hide"})}.bind(this),error:function(e,t,a){console.log(e,t,a)}})}},{key:"serchtest",value:function(e){var t=e,a=document.getElementById("example2"),n=b()(a.rows[t].cells[0]).text(),l=b()(a.rows[t].cells[1]).text(),s=b()(a.rows[t].cells[2]).text(),c=b()(a.rows[t].cells[3]).text(),r=(b()(a.rows[t].cells[4]).text(),b()(a.rows[t].cells[5]).text());this.setState({catId:n,mpnDesc:l,mpnName:s,upcNum:c,brandName:r}),console.log(n)}},{key:"serchMpn",value:function(e){if(console.log(e),"up1"==e){var t=this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_upc_title",a=this.state.upcNum;this.setState({boxHeader:"Upc"})}else if("mp1"==e){t=this.state.baseUrl+"/laptopzone/reactcontroller/c_react/serch_mpn_sys",a=this.state.mpnName;this.setState({boxHeader:"Mpn"})}else if("desc1"==e){t=this.state.baseUrl+"/laptopzone/reactcontroller/c_react/serch_desc_sys",a=this.state.mpnDesc;this.setState({boxHeader:"Description"})}b.a.ajax({url:t,dataType:"json",type:"POST",data:{passVal:a},success:function(e){1==e.exist?(console.log("mpn"),this.setState({mpnTitle:e.desc_quer,MpnTitleCheck:!0})):this.setState({MpnTitleCheck:!1})}.bind(this),error:function(e,t,a){console.log(e,t,a)}})}},{key:"serchCond",value:function(){var e=this.state.baseUrl+"/laptopzone/reactcontroller/c_react/get_avail_cond";b.a.ajax({url:e,dataType:"json",type:"POST",data:{catId:this.state.catId},success:function(e){e.exist,this.setState({availCond:e.get_cond,CondCheck:!0})}.bind(this),error:function(e,t,a){console.log(e,t,a)}})}},{key:"closePane",value:function(){this.setState({MpnTitleCheck:!1})}},{key:"render",value:function(){var e=this,t=this.state,a=t.error,n=t.isLoaded,s=(t.objects,this.state.showSeed);if(a)return l.a.createElement("div",null," Error: ",a.message);if(n){var c=this.state.objects.map(function(e){return l.a.createElement("option",{key:e.OBJECT_ID,value:e.OBJECT_ID},e.OBJECT_NAME)});return l.a.createElement(l.a.Fragment,null,l.a.createElement("section",{className:"content-header"},l.a.createElement("h1",null,"Verify",l.a.createElement("small",null,"Item")),l.a.createElement("ol",{className:"breadcrumb"},l.a.createElement("li",null,l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-dashboard"})," Home")),l.a.createElement("li",null,l.a.createElement("a",{href:"#"},"Tables")),l.a.createElement("li",{className:"active"},"Verify Item"))),l.a.createElement("section",{className:"content"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-12"},l.a.createElement("div",{className:"box box-danger"},l.a.createElement("form",{onSubmit:this.handleForm},l.a.createElement("div",{className:"box-body"},l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Item Type"),l.a.createElement("input",{type:"text",className:"form-control",name:"itemType",value:this.state.itemType,onChange:this.handleInput,disabled:!0}),l.a.createElement("input",{type:"hidden",className:"form-control",name:"idS",value:this.state.idS,onChange:this.handleInput,disabled:!0})),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Barcode"),l.a.createElement("input",{type:"number",className:"form-control",name:"barcodeNo",disabled:!0,value:this.state.barcodeNo,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Upc"),l.a.createElement("div",{className:"input-group input-group-md"},l.a.createElement("input",{type:"text",className:"form-control",name:"upcNum",value:this.state.upcNum,onChange:this.handleInput}),l.a.createElement("div",{className:"input-group-btn"},l.a.createElement("button",{className:"btn btn-info ",title:"Search on Ebay",type:"button",onClick:function(){e.serchMpn("up1")}},l.a.createElement("i",{className:"glyphicon glyphicon-search"}))))),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Mpn"),l.a.createElement("div",{className:"input-group input-group-md"},l.a.createElement("input",{type:"text",className:"form-control",name:"mpnName",value:this.state.mpnName,onChange:this.handleInput}),l.a.createElement("div",{className:"input-group-btn"},l.a.createElement("button",{className:"btn btn-info ",title:"Search on Ebay",type:"button",onClick:function(){e.serchMpn("mp1")}},l.a.createElement("i",{className:"glyphicon glyphicon-search"}))))),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Object"),l.a.createElement("select",{className:"form-control selectpicker ",name:"objName",value:this.state.objName,onChange:this.handleInput},l.a.createElement("option",{value:"0"},"Select Object.. "),c)),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Category Id"),l.a.createElement("div",{className:"input-group input-group-md"},l.a.createElement("input",{type:"text",className:"form-control",name:"catId",value:this.state.catId,onChange:this.handleInput}),l.a.createElement("div",{className:"input-group-btn"},l.a.createElement("button",{className:"btn btn-info ",title:"Search Availble Condition",type:"button",onClick:function(){e.serchCond()}},l.a.createElement("i",{className:"glyphicon glyphicon-search"})))))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Brand"),l.a.createElement("input",{type:"text",className:"form-control",name:"brandName",value:this.state.brandName,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-5"},l.a.createElement("label",null,"Mpn Description"),l.a.createElement("div",{className:"input-group input-group-md"},l.a.createElement("input",{type:"text",className:"form-control",name:"mpnDesc",value:this.state.mpnDesc,onChange:this.handleInput}),l.a.createElement("div",{className:"input-group-btn"},l.a.createElement("button",{className:"btn btn-info ",title:"Search on Ebay",type:"button",onClick:function(){e.serchMpn("desc1")}},l.a.createElement("i",{className:"glyphicon glyphicon-search"}))))),l.a.createElement("div",{className:"col-xs-3"},l.a.createElement("label",null,"Remarks"),l.a.createElement("input",{type:"text",className:"form-control",name:"remarks",value:this.state.remarks,onChange:this.handleInput})),l.a.createElement("div",{className:"col-xs-2"},l.a.createElement("label",null,"Avg Sold $"),l.a.createElement("input",{type:"text",className:"form-control",name:"avgSold",value:this.state.avgSold,onChange:this.handleInput}))),l.a.createElement("div",{className:"row"},this.state.CondCheck?l.a.createElement(y,{data:this.state.availCond,handle:this.handleInput}):null),l.a.createElement("div",{className:"box-footer "},l.a.createElement("button",{type:"submit",className:"btn btn-info pull-right"},"Save"))))),l.a.createElement("div",{className:"row"},l.a.createElement("div",{className:"col-sm-12"},l.a.createElement("div",{className:"col-sm-12 b-full"},l.a.createElement("div",{className:"col-sm-12 docs-galley",style:{padding_top:"12px"}},l.a.createElement("ul",{id:"getsortable",style:{color:"black",height:"auto !important",width:" 100%"}}))))))),this.state.MpnTitleCheck?l.a.createElement(_,{boxHead:this.state.boxHeader,data:this.state.mpnTitle,serchtest:this.serchtest,closePane:this.closePane}):null,"show"==s?l.a.createElement(g,{passBarcode:this.state.barcodeNo}):"hide"))}return l.a.createElement("section",{className:"content-header"},l.a.createElement("h1",null,"LOADING......"),l.a.createElement("ol",{className:"breadcrumb"},l.a.createElement("li",null,l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-dashboard"})," Home")),l.a.createElement("li",null,l.a.createElement("a",{href:"#"},"Tables")),l.a.createElement("li",{className:"active"},"Verify Item")))}}]),t}(l.a.Component),x=function(e){function t(){return Object(r.a)(this,t),Object(o.a)(this,Object(m.a)(t).apply(this,arguments))}return Object(d.a)(t,e),Object(i.a)(t,[{key:"render",value:function(){return l.a.createElement(l.a.Fragment,null,l.a.createElement(p.a,null,l.a.createElement("div",{className:"content-wrapper"},l.a.createElement("aside",{className:"main-sidebar"},l.a.createElement("section",{className:"sidebar"},l.a.createElement("div",{className:"user-panel"},l.a.createElement("div",{className:"pull-left image"},l.a.createElement("img",{src:"assets/dist/img/user2-160x160.jpg",className:"img-circle",alt:"User Image"})),l.a.createElement("div",{className:"pull-left info"},l.a.createElement("p",null,"Admin"),l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-circle text-success"})," Online"))),l.a.createElement("form",{action:"#",method:"get",className:"sidebar-form"},l.a.createElement("div",{className:"input-group"},l.a.createElement("input",{type:"text",name:"q",className:"form-control",placeholder:"Search..."}),l.a.createElement("span",{className:"input-group-btn"},l.a.createElement("button",{type:"submit",name:"search",id:"search-btn",className:"btn btn-flat"},l.a.createElement("i",{className:"fa fa-search"}))))),l.a.createElement("ul",{className:"sidebar-menu","data-widget":"tree"},l.a.createElement("li",{className:"treeview "},l.a.createElement("a",{href:"#"},l.a.createElement("i",{className:"fa fa-table"})," ",l.a.createElement("span",null,"Tables"),l.a.createElement("span",{className:"pull-right-container"},l.a.createElement("i",{className:"fa fa-angle-left pull-right"}))),l.a.createElement("ul",{className:"treeview-menu"},l.a.createElement("li",{className:"active"},l.a.createElement(p.b,{to:"/"},l.a.createElement("i",{className:"fa fa-circle-o"})," box1 ")),l.a.createElement("li",{className:"active"},l.a.createElement(p.b,{to:"/box2"},l.a.createElement("i",{className:"fa fa-circle-o"})," box2 "))))))),l.a.createElement(p.d,null,l.a.createElement(p.c,{path:"/",exact:!0,component:h}),l.a.createElement(p.c,{path:"/box2",exact:!0,component:N}),l.a.createElement(p.c,{path:"/varify",exact:!0,component:C})))))}}]),t}(l.a.Component),I=function(e){function t(){return Object(r.a)(this,t),Object(o.a)(this,Object(m.a)(t).apply(this,arguments))}return Object(d.a)(t,e),Object(i.a)(t,[{key:"render",value:function(){return l.a.createElement("footer",{className:"main-footer"},l.a.createElement("div",{className:"pull-right hidden-xs"}),l.a.createElement("strong",null,"Copyright \xa9 2014-2016 ",l.a.createElement("a",{href:"https://adminlte.io"},"Almsaeed Studio"),".")," All rights reserved.")}}]),t}(l.a.Component);var S=function(){return l.a.createElement(l.a.Fragment,null,l.a.createElement(u,null),l.a.createElement(x,null),l.a.createElement(I,null))};Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));c.a.render(l.a.createElement(S,null),document.getElementById("root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then(function(e){e.unregister()})}},[[28,2,1]]]);
//# sourceMappingURL=main.f831fb4f.chunk.js.map