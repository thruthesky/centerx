(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-41948662"],{"0738":function(t,e,n){t.exports=n.p+"img/fas-trash.7677c3c9.svg"},"450c":function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"pr-2 position-relative overflow-hidden pointer"},[s("img",{staticClass:"pointer",style:{width:t.defaultSize+"px",height:t.defaultSize+"px"},attrs:{src:n("872d")}}),s("input",{staticClass:"h-100 top right position-absolute fs-lg opacity-0 pointer",attrs:{type:"file"},on:{change:t.onFileChange}})])},o=[],i=n("9ab4"),a=n("d68b"),r=n("2b0e"),l=n("2fe1"),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=35,e.app=a["a"].instance,e}return Object(i["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size)},e.prototype.onFileChange=function(t){var e,n;if(this.app.notLoggedIn)this.app.error("error_login_first");else if(null!==t.target.files&&0!==(null===(n=null===(e=t.target)||void 0===e?void 0:e.files)||void 0===n?void 0:n.length)){var s=t.target.files[0];this.app.api.fileUpload(s,{},this.onUploaded,this.app.error,this.onProgress)}},e.prototype.onUploaded=function(t){this.$emit("success",t)},e.prototype.onProgress=function(t){this.$emit("progress",t)},e=Object(i["b"])([Object(l["a"])({props:["size"]})],e),e}(r["a"]),u=c,p=u,d=n("2877"),f=Object(d["a"])(p,s,o,!1,null,null,null);e["a"]=f.exports},"872d":function(t,e,n){t.exports=n.p+"img/camera.f2c26d4b.svg"},8857:function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"file-display grid"},[s("div",{staticClass:"row"},t._l(t.files,(function(e){return s("div",{key:e.idx,staticClass:"position-relative p-1 col-3",staticStyle:{height:"150px"}},[t.showDelete?s("div",{staticClass:"icon-lg position-absolute m-2 bg-light circle-center pointer",on:{click:function(n){return t.onClickDelete(e.idx)}}},[s("img",{staticClass:"icon-md",attrs:{src:n("0738")}})]):t._e(),s("img",{staticClass:"w-100 h-100",attrs:{src:e.url,alt:e.name}})])})),0)])},o=[],i=(n("d3b7"),n("c740"),n("a434"),n("9ab4")),a=n("9f3a"),r=n("2b0e"),l=n("2fe1"),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=a["a"].instance,e}return Object(i["c"])(e,t),e.prototype.onClickDelete=function(t){return Object(i["a"])(this,void 0,Promise,(function(){var e,n,s;return Object(i["d"])(this,(function(o){switch(o.label){case 0:if(e=confirm("Are you sure you want to delete this file?"),!e)return[2];o.label=1;case 1:return o.trys.push([1,3,,4]),[4,this.api.fileDelete(t)];case 2:return o.sent(),n=this.files.findIndex((function(e){return e.idx==t})),this.files.splice(n,1),this.$emit("file-deleted",t),[3,4];case 3:return s=o.sent(),this.api.error(s),[3,4];case 4:return[2]}}))}))},e=Object(i["b"])([Object(l["a"])({props:["files","showDelete"]})],e),e}(r["a"]),u=c,p=u,d=n("2877"),f=Object(d["a"])(p,s,o,!1,null,null,null);e["a"]=f.exports},bece:function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.settings?n("div",[n("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[n("div",[t._v(" @todo If there is no advertisement, guide the user how to create first advertisement esialy. ")]),n("div",{staticClass:"box d-flex mt-2"},[n("upload-button",{attrs:{size:30},on:{success:t.onFileUploaded,progress:function(e){t.uploadProgress=e}}}),n("div",{staticClass:"ml-3"},[t.post.files.length?t._e():n("div",{staticClass:"p-1"},[t._v("No banner chosen ..")]),n("file-display",{attrs:{files:t.post.files,showDelete:!0}})],1)],1),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v(" Name ")]),n("input",{directives:[{name:"model",rawName:"v-model",value:t.post.name,expression:"post.name"}],staticClass:"form-control",attrs:{placeholder:"Name",type:"text"},domProps:{value:t.post.name},on:{input:function(e){e.target.composing||t.$set(t.post,"name",e.target.value)}}}),n("small",{staticClass:"form-text text-muted"},[t._v(" Input name of the advertisement ")])]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v("Contact No.")]),n("input",{directives:[{name:"model",rawName:"v-model",value:t.post.phoneNo,expression:"post.phoneNo"}],staticClass:"form-control",attrs:{placeholder:"Contact number",type:"text"},domProps:{value:t.post.phoneNo},on:{input:function(e){e.target.composing||t.$set(t.post,"phoneNo",e.target.value)}}}),n("small",{staticClass:"form-text text-muted"},[t._v(" Input your phone number. ")])]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v("Banner Type/Position")]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.post.code,expression:"post.code"}],staticClass:"form-control",on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.post,"code",e.target.multiple?n:n[0])}}},[n("option",{attrs:{value:"",disabled:"",selected:""}},[t._v("Select Type")]),t._l(t.settings.types,(function(e){return n("option",{key:e},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" Select where you want to display your banner. ")])]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v("Category(or global)")]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.post.subcategory,expression:"post.subcategory"}],staticClass:"form-control",on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.post,"subcategory",e.target.multiple?n:n[0])}}},[n("option",{attrs:{value:"",disabled:"",selected:""}},[t._v(" Select category or global(default) ")]),t._l(t.settings.categories,(function(e){return n("option",{key:e},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" Select which category you want to display your advertisement, if you don't choose category, it will default to global. ")])]),t.countries?n("div",{staticClass:"form-group mt-2"},[n("label",[t._v("Cafe Country")]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.post.countryCode,expression:"post.countryCode"}],staticClass:"form-control",attrs:{value:""},on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.post,"countryCode",e.target.multiple?n:n[0])}}},[n("option",{attrs:{disabled:"",selected:""}},[t._v("Select Country")]),t._l(t.countries,(function(e,s){return n("option",{key:s,domProps:{value:s}},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" Select the country. 어느 국가의 교민 카페들에게 광고 표시를 할지 선택해 주세요. ")])]):t._e(),t.post.code&&t.post.countryCode?n("div",{staticClass:"box"},[t._v(" Points Per Day: "),n("b",[t._v(t._s(t.countryPointListing[t.post.code]))]),t._v(" "),n("br"),n("small",{staticClass:"text-info"},[t._v(" Note: Point per day may vary depending on the banner type and chosen country. ")])]):t._e(),n("div",{staticClass:"form-group bg-light p-3 mt-2"},[n("label",[t._v(t._s(t._f("t")("advertisement_begin_end_date")))]),n("div",{staticClass:"d-flex justify-content-between"},[n("label",[t._v("Begin Date "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.post.beginAt,expression:"post.beginAt"}],attrs:{type:"date",name:"beginAt",min:t.beginAtMin,max:t.beginAtMax,disabled:t.isNotEdittable},domProps:{value:t.post.beginAt},on:{input:function(e){e.target.composing||t.$set(t.post,"beginAt",e.target.value)}}})]),n("label",[t._v(" End Date "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.post.endAt,expression:"post.endAt"}],attrs:{type:"date",name:"endAt",min:t.endAtMin,disabled:t.isNotEdittable},domProps:{value:t.post.endAt},on:{input:function(e){e.target.composing||t.$set(t.post,"endAt",e.target.value)}}})])]),n("small",{staticClass:"form-text text-muted mb-2"},[t._v(" "+t._s(t._f("t")("advertisement_serving_days"))+": "),n("b",[t._v(t._s(t.servingDaysLeft))]),t._v(" "+t._s(t._f("t")("days"))+" ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" 광고비 시작 날짜와 끝 날짜를 선택해주세요. ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" 참고: 날짜 입력은 직접 입력하지 않고, Input 태그의 달력에서 날짜를 선택한다. type=date 의 표시는 YYYY/MM/DD 이지만, PHP 로 전달은 YYYY-MM-DD 이다. ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" 참고: 광고가 23일 까지이면, 밤 23일까지 표시된다. 즉, 광고가 0일 남아도, 마지막 날 밤까지 광고가 표시된다. ")])]),n("div",{staticClass:"alert alert-info"},[t._v(" Total Points required: "),t.priceInPoint?n("b",[t._v(t._s(t.priceInPoint))]):t._e(),n("br"),n("small",{staticClass:"text-info"},[t._v(' To get total points, points per day is multiplied to the total number of days beginning from "Begin date" to "End date". ')]),n("br"),n("br"),t._v(" My Points: "),t.api.user?n("b",[t._v(t._s(t.api.user.point))]):t._e(),t._v(" "),n("br"),t.isPointInsufficient?n("small",{staticClass:"text-danger"},[t._v(" Insufficient point! You don't have enough point to create this kind of advertisement. ")]):t._e(),n("br"),t._v(" @todo when user change dates, display the price (point)."),n("br"),t._v(" @todo If the user is lack of point, display warning."),n("br")]),n("div",[n("button",{staticClass:"w-100 btn btn-outline-primary",attrs:{type:"submit",disabled:!t.isPointInsufficient}},[t._v(" Save the advertisement ")]),t._v(' @todo After save, display one of "cancel" or "refund" button.'),n("br"),t._v(" @todo When the user press save button, deduct the point from user. And the date is no loger changable."),n("br"),t._v(' @todo Delete button will be shown if the banner has no point. Meaning 1) the user may not have paid the point yet. 2) the banner was cancelled, or refunded. In which case, the banner can be deleted without point refund computation, then "delete button" will be displayed. ')]),t.isNotEdittable?n("div",[t.isRefundable?n("button",{staticClass:"w-100 btn btn-outline-success",attrs:{type:"button"}},[t._v(" Refund ")]):t._e(),t.isRefundable?t._e():n("button",{staticClass:"w-100 btn btn-outline-danger",attrs:{type:"button"}},[t._v(" Cancel ")]),t._v(" @todo Cancel button will be shown if the banner has not begin yet."),n("br"),t._v(" @todo Refund button will be shown if the banner has begun."),n("br"),t._v(' @todo after cancel or refund, display "resume the advertisement" or "delete" button.'),n("br"),n("hr")]):t._e(),n("div",{staticClass:"box"},[n("p",[t._v(" Advertisement Points Listing: "),t.post.countryCode?n("span",[t._v(t._s(t.post.countryCode))]):t._e(),t.post.countryCode?t._e():n("span",[t._v("Default")]),t._v(" "),n("br"),n("small",{staticClass:"text-info"},[t._v(" Note: Points listing vary depending on the chosen country. ")])]),n("table",{staticClass:"w-100 mt-2 table table-striped"},[t._m(0),n("tbody",t._l(t.countryPointListing,(function(e,s){return n("tr",{key:s},[n("td",[t._v(t._s(s))]),n("td",[t._v(t._s(e))])])})),0)]),t._m(1)]),t._v(" @todo banner price computation. The price list is comming from the admin settings. and the price is difference based on country and banner place. "),n("br"),t._v(" @todo 무통장 입금 표시. 세금을 포함해서 계산한다. "),n("hr"),t._v(" @todo 경고. 회원 활동으로 획득한 포인트를 광고에 이용 할 수 있습니다. 하지만, 직접 활동하여 얻는 포인트(예, 포인트가 많은 다른 사용자의 계정으로 광고 등록)하면, 광고 해지 및 포인트 0점 처리, 그리고 영구 차단이 되므로 주의하시기 바랍니다. ")]),t._v(" "+t._s(t.noOfDays)+" ")]):t._e()},o=[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",{staticClass:"table-header"},[n("th",{attrs:{scope:"col"}},[t._v("Banner Type")]),n("th",{attrs:{scope:"col"}},[t._v("Points(per day)")])])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("small",{staticClass:"text-info"},[t._v(" To get "),n("b",[t._v("Total Points Required")]),t._v(" to create an advertisement, "),n("b",[t._v("Points Per Day")]),t._v(" from chosen "),n("b",[t._v("Banner Type")]),t._v(" is multiplied to the total number of days beginning from "),n("b",[t._v('"Begin date"')]),t._v(" to "),n("b",[t._v('"End date"')]),t._v(". ")])}],i=(n("ac1f"),n("1276"),n("d3b7"),n("9ab4")),a=n("2b0e"),r=n("2fe1"),l=n("d28a"),c=n("450c"),u=n("8857"),p=n("9f3a"),d=n("d661"),f=n("0613"),b=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=p["a"].instance,e.post=new l["g"],e.uploadProgress=0,e.now=new Date,e.beginAtMin="",e}return Object(i["c"])(e,t),Object.defineProperty(e.prototype,"settings",{get:function(){return f["a"].state.advertisementSettings},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"countries",{get:function(){return f["a"].state.countries},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"countryPointListing",{get:function(){var t=this.post.countryCode;if(!this.settings.point)return{};var e=this.settings.point[t];return e&&void 0!=e?e:this.settings.point["default"]},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"priceInPoint",{get:function(){return this.settings&&this.noOfDays?this.post.code?this.countryPointListing[this.post.code]*this.noOfDays:this.countryPointListing["default"]*this.noOfDays:0},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"endAtMin",{get:function(){var t=this.now;return this.post.beginAt&&(t=new Date(this.post.beginAt)),t.setDate(t.getDate()+1),t.toISOString().split("T")[0]},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"beginAtMax",{get:function(){if(this.post.endAt){var t=new Date(this.post.endAt);return t.setDate(t.getDate()-1),t.toISOString().split("T")[0]}return""},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"noOfDays",{get:function(){return this.post.beginAt&&this.post.endAt?Object(d["b"])(new Date(this.post.beginAt),new Date(this.post.endAt)):0},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"servingDaysLeft",{get:function(){return this.post.endAt?this.post.beginAt&&new Date(this.post.beginAt).getMilliseconds()<this.now.getMilliseconds()?this.noOfDays:Object(d["b"])(this.now,new Date(this.post.endAt)):0},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isPointInsufficient",{get:function(){return!this.api.user||(0==this.api.user.point||this.api.user.point<this.priceInPoint)},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isNotEdittable",{get:function(){return!!this.post.idx},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isRefundable",{get:function(){return Object(d["b"])(this.now,new Date(this.post.beginAt))<=0},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){var t=this.$route.params.idx;t&&(this.post.idx=t,this.loadAdvertisement()),this.post.categoryId="advertisement",this.beginAtMin=this.now.toISOString().split("T")[0]},e.prototype.loadAdvertisement=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,this.api.postGet({idx:this.post.idx})];case 1:return t=n.sent(),this.post=t,[3,3];case 2:return e=n.sent(),this.api.error(e),[3,3];case 3:return[2]}}))}))},e.prototype.onSubmit=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:console.log(this.post.toJson),n.label=1;case 1:return n.trys.push([1,3,,4]),[4,this.api.postEdit(this.post.toJson)];case 2:return t=n.sent(),this.post=t,[3,4];case 3:return e=n.sent(),this.api.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.onFileUploaded=function(t){this.post.files.push(t),this.uploadProgress=0},e=Object(i["b"])([Object(r["a"])({components:{UploadButton:c["a"],FileDisplay:u["a"]}})],e),e}(a["a"]),v=b,m=v,h=n("2877"),g=Object(h["a"])(m,s,o,!1,null,null,null);e["default"]=g.exports}}]);
//# sourceMappingURL=chunk-41948662.7e83bf51.js.map