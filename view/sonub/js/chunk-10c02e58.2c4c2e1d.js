(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-10c02e58"],{"11c8":function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[n("path",{attrs:{d:"M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"}})])},a=[],i=n("2877"),r={},o=Object(i["a"])(r,s,a,!1,null,null,null);e["a"]=o.exports},"3d1d":function(t,e,n){},"611d":function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("AdvertisementEdit",{attrs:{cafeCountryCode:t.app.cafeCountryCode},on:{start:t.onStartOrStop,stop:t.onStartOrStop}})},a=[],i=n("9ab4"),r=n("2b0e"),o=n("2fe1"),l=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",[t.loading?t._e():n("form",{staticClass:"p-2",on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[t.banner.idx?n("div",[t._v(" You are posting banner on "),n("b",[t._v(t._s(t.countryName))])]):t._e(),t.banner.isActive||t.banner.isWaiting?n("div",{staticClass:"box mb-2"},[t._v(" "+t._s(t.banner.pointPerDay)+" "),n("div",{staticClass:"d-flex"},[n("span",[t._v(" "+t._s(t._f("t")("adv_banner_type"))+" "),n("h2",[t._v(t._s(t.banner.code))])]),n("span",{staticClass:"ml-4"},[t._v(" "+t._s(t._f("t")("country"))+" "),n("h2",[t._v(t._s(t.countryName))])]),n("span",{staticClass:"ml-4"},[t._v(" "+t._s(t._f("t")("status"))+" "),n("h2",[t._v(t._s(t.banner.status))])])]),n("div",{staticClass:"mt-3"},[t._v(" "+t._s(t._f("t")("adv_banner_dates"))+" "),n("h2",[t._v(t._s(t.banner.beginDate)+" ~ "+t._s(t.banner.endDate))])]),n("div",{staticClass:"mt-3"},[n("div",{staticClass:"alert alert-info"},[n("div",{staticClass:"d-flex"},[n("span",{staticClass:"mr-3"},[t._v(" "+t._s(t._f("t")("adv_no_of_days"))+": "),n("b",[t._v(t._s(t.noOfDays))])]),n("span",{staticClass:"mr-3"},[t._v(" "+t._s(t._f("t")("advertisement_serving_days"))+": "),n("b",[t._v(t._s(t.servingDaysLeft))])])]),n("div",{staticClass:"d-flex mt-2"},[n("span",{staticClass:"mr-3"},[t._v(" "+t._s(t._f("t")("adv_points_per_day"))+": "),n("b",[t._v(t._s(t.banner.pointPerDay))])]),n("span",[t._v(" "+t._s(t._f("t")("adv_refundable_points"))+": "),n("b",[t._v(t._s(t.refundablePoints))])])]),n("small",{staticClass:"text-info"},[t._v(" "+t._s(t._f("t")("adv_refundable_points_hint"))+" ")])]),t.isCancellable||t.isRefundable?n("button",{staticClass:"w-100 btn btn-outline-danger",attrs:{type:"button"},on:{click:t.onAdvertisementStop}},[t._v(" "+t._s(t._f("t")(t.isCancellable?"cancel_advertisement":"stop_advertisement"))+" ")]):t._e(),t.isDue?n("small",{staticClass:"text-info"},[t._v(" This advertisement is already expired, you can stop it if you want to reset the dates and to start it again. "),n("br"),t._v(" Stopping this advertisement will not cost anything, you will not also get a refund since it is already expired. ")]):t._e()])]):t._e(),t.banner.isInactive?n("div",{staticClass:"mb-2"},[t.banner.code?n("div",{staticClass:"box"},[t._v(" "+t._s(t._f("t")("adv_points_per_day"))+": "),n("b",[t._v(t._s(t.bannerPoints[t.banner.code]))]),t._v(" "),n("br"),n("small",{staticClass:"text-info"},[t._v(" "+t._s(t._f("t")("adv_points_per_day_hint"))+" ")])]):t._e(),n("div",{staticClass:"form-group bg-light p-3 mt-3"},[n("label",[t._v(t._s(t._f("t")("advertisement_begin_end_date")))]),n("div",{staticClass:"d-flex justify-content-between"},[n("label",[t._v(" "+t._s(t._f("t")("adv_begin_date"))+" "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.banner.beginDate,expression:"banner.beginDate"}],attrs:{type:"date",min:t.beginAtMin,max:t.beginAtMax,disabled:t.banner.isActive},domProps:{value:t.banner.beginDate},on:{input:function(e){e.target.composing||t.$set(t.banner,"beginDate",e.target.value)}}})]),n("label",[t._v(" "+t._s(t._f("t")("adv_end_date"))+" "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.banner.endDate,expression:"banner.endDate"}],attrs:{type:"date",min:t.endAtMin,max:t.endAtMax,disabled:t.banner.isActive},domProps:{value:t.banner.endDate},on:{input:function(e){e.target.composing||t.$set(t.banner,"endDate",e.target.value)}}})])]),n("small",{staticClass:"form-text text-muted mb-2"},[t._v(" "+t._s(t._f("t")("advertisement_serving_days"))+": "),n("b",[t._v(t._s(t.servingDaysLeft))]),t._v(" "+t._s(t._f("t")("days"))+" ")]),n("small",{staticClass:"form-text text-muted mb-2"},[t._v(" "+t._s(t._f("t")("adv_no_of_days"))+": "+t._s(t.noOfDays)+" ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_no_of_days_hint_a"))+" ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_no_of_days_hint_b"))+" ")]),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_no_of_days_hint_c"))+" ")])]),t.priceInPoint?n("div",{staticClass:"alert alert-info"},[t._v(" "+t._s(t._f("t")("adv_total_points_required"))+": "),n("b",[t._v(t._s(t.priceInPoint))]),n("br"),n("small",{staticClass:"text-info"},[t._v(" "+t._s(t._f("t")("adv_total_points_required_hint"))+" ")])]):t._e(),n("div",{staticClass:"mt-2"},[n("button",{staticClass:"w-100 btn btn-outline-success",attrs:{type:"button",disabled:!t.canStart},on:{click:t.onAdvertisementStart}},[t._v(" "+t._s(t._f("t")("start_advertisement"))+" ")]),t.isPointInsufficient?n("div",{staticClass:"alert alert-danger mt-2"},[t.isEmptyObj(t.bannerPoints)?n("span",[t._v(t._s(t._f("t")("point_setting_not_set")))]):n("span",[t._v(t._s(t._f("t")("start_advertisement_warning")))])]):t._e()])]):t._e(),n("div",{staticClass:"box mt-3 p-3"},[0==t.banner.idx?n("h2",[t._v("Creating banner")]):n("h2",[t._v("Updating banner")]),t.cafeCountryCode?n("section",{},[t._v(" You are posting banner on "),n("b",[t._v(t._s(t.countryName))])]):n("section",{},[t._v(" Choose country "),t.countries?n("div",{staticClass:"form-group mt-2"},[n("label",[t._v(t._s(t._f("t")("adv_cafe_country")))]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.banner.countryCode,expression:"banner.countryCode"}],staticClass:"form-control",attrs:{value:"",disabled:t.banner.isActive},on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.banner,"countryCode",e.target.multiple?n:n[0])}}},[n("option",{attrs:{disabled:"",selected:""}},[t._v(t._s(t._f("t")("select_country")))]),t._l(t.countries,(function(e,s){return n("option",{key:s,domProps:{value:s}},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_cafe_country_hint"))+" ")])]):t._e()]),n("div",{staticClass:"form-group"},[n("label",[t._v(t._s(t._f("t")("title")))]),n("input",{directives:[{name:"model",rawName:"v-model",value:t.banner.title,expression:"banner.title"}],staticClass:"form-control",attrs:{placeholder:t._f("t")("title"),type:"text"},domProps:{value:t.banner.title},on:{input:function(e){e.target.composing||t.$set(t.banner,"title",e.target.value)}}})]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v(t._s(t._f("t")("category")))]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.banner.subcategory,expression:"banner.subcategory"}],staticClass:"form-control",on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.banner,"subcategory",e.target.multiple?n:n[0])}}},[n("option",{attrs:{value:"",selected:""}},[t._v(" "+t._s(t._f("t")("global"))+" ")]),t._l(t.settings.categoryArray,(function(e){return n("option",{key:e},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_category_hint_b"))+" ")])]),t.togglePointTable?n("div",{staticClass:"mt-3 box"},[n("div",{staticClass:"d-flex justify-content-between"},[n("div",[t._v(t._s(t._f("t")("adv_point_listing")))]),n("div",{staticClass:"btn btn-link btn-sm",on:{click:function(e){t.togglePointTable=!t.togglePointTable}}},[t._v("Hide")])]),n("div",[t._v(" You are posting advertisement under "+t._s(t.cafeCountryCode)+" - "+t._s(t.countryName)+", and the table below is the points of banner type. ")]),t.isEmptyObj(t.bannerPoints)?t._e():n("table",{staticClass:"w-100 mt-2 table table-striped"},[n("thead",[n("tr",{staticClass:"table-header"},[n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("adv_banner_type")))]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("adv_points_per_day")))]),t.settings.globalBannerMultiplying?n("th",{attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("global_adv_price"))+" ")]):t._e()])]),n("tbody",t._l(t.bannerPoints,(function(e,s){return n("tr",{key:s},[n("td",[t._v(t._s(s))]),n("td",[t._v(t._s(e))]),t.settings.globalBannerMultiplying?n("td",[t._v(" "+t._s(e*t.settings.globalBannerMultiplying)+" ")]):t._e()])})),0)]),n("small",{staticClass:"text-info"},[t._v(" "+t._s(t._f("t")("adv_point_listing_hint"))+" ")])]):n("div",{staticClass:"btn btn-link btn-sm",on:{click:function(e){t.togglePointTable=!t.togglePointTable}}},[t._v(" Show advertisement point ")]),n("hr"),n("BannerType",{attrs:{settings:t.settings,banner:t.banner}}),n("div",[t._v("@TODO Display how much is it per day per month(30 days)")]),t._v(" @TODO display banner size tip to user based on banner type. "),n("div",{staticClass:"box mt-4"},[n("label",[t._v(t._s(t._f("t")("adv_banner")))]),t.isMounted?n("UploadImage",{attrs:{taxonomy:"posts",entity:t.banner.idx,code:"banner"},on:{uploaded:t.onFileUpload,deleted:t.onFileDelete}}):t._e(),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_banner_description"))+" ")])],1),n("div",{staticClass:"box mt-2"},[n("label",[t._v(t._s(t._f("t")("adv_content_banner")))]),t.isMounted?n("UploadImage",{attrs:{taxonomy:"posts",entity:t.banner.idx,code:"content"},on:{uploaded:t.onFileUpload,deleted:t.onFileDelete}}):t._e(),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_banner_description"))+" ")])],1),n("div",{staticClass:"form-group mt-4"},[n("label",[t._v(t._s(t._f("t")("content")))]),n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.banner.content,expression:"banner.content"}],staticClass:"form-control",attrs:{placeholder:t._f("t")("content"),type:"text",rows:"5"},domProps:{value:t.banner.content},on:{input:function(e){e.target.composing||t.$set(t.banner,"content",e.target.value)}}})]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v(t._s(t._f("t")("adv_memo")))]),n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.banner.privateContent,expression:"banner.privateContent"}],staticClass:"form-control",attrs:{placeholder:t._f("t")("adv_memo"),rows:"2"},domProps:{value:t.banner.privateContent},on:{input:function(e){e.target.composing||t.$set(t.banner,"privateContent",e.target.value)}}}),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_memo_hint"))+" ")])]),n("div",{staticClass:"form-group mt-2"},[n("label",[t._v(t._s(t._f("t")("click_url")))]),n("input",{directives:[{name:"model",rawName:"v-model",value:t.banner.clickUrl,expression:"banner.clickUrl"}],staticClass:"form-control",attrs:{placeholder:t._f("t")("click_url"),type:"text"},domProps:{value:t.banner.clickUrl},on:{input:function(e){e.target.composing||t.$set(t.banner,"clickUrl",e.target.value)}}}),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("click_url_hint"))+" ")])]),n("div",{staticClass:"d-flex"},[t.banner.idx&&t.banner.isInactive?n("button",{staticClass:"mt-2 btn btn-outline-danger",attrs:{type:"button"},on:{click:t.advertisementDelete}},[t._v(" "+t._s(t._f("t")("delete"))+" ")]):t._e(),n("span",{staticClass:"flex-grow-1"}),t.isSubmitted?t._e():n("button",{staticClass:"mt-2 btn btn-outline-success",attrs:{type:"submit"}},[t.banner.idx?n("span",[t._v(t._s(t._f("t")("update")))]):t._e(),t.banner.idx?t._e():n("span",[t._v(t._s(t._f("t")("save")))])]),t.isSubmitted?n("b-spinner",{staticClass:"m-2",attrs:{type:"grow",variant:"success"}}):t._e()],1)],1)]),t.loading?n("div",{staticClass:"p-3 text-center rounded"},[n("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Loading ... ")],1):t._e()])},c=[],u=(n("d3b7"),n("1b40")),d=n("9f3a"),b=n("d661"),_=n("c210"),p=n("6674"),f=n("5a0c"),v=n.n(f),m=n("a7c6"),h=n("5709"),g=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",{staticClass:"form-group mt-2"},[n("label",[t._v(t._s(t._f("t")("adv_banner_type")))]),n("select",{directives:[{name:"model",rawName:"v-model",value:t.banner.code,expression:"banner.code"}],staticClass:"form-control",attrs:{disabled:t.banner.isActive},on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.banner,"code",e.target.multiple?n:n[0])}}},[n("option",{attrs:{value:"",disabled:"",selected:""}},[t._v(" "+t._s(t._f("t")("select_type"))+" ")]),t._l(t.settings.types,(function(e){return n("option",{key:e},[t._v(" "+t._s(e)+" ")])}))],2),n("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s(t._f("t")("adv_banner_type_hint"))+" ")]),n("div",{staticClass:"alert alert-info"},[n("div",[t._v("Banner image must be JPG only.")]),"top"==t.banner.code?n("div",[t._v("width: 570px, height: 200px.")]):t._e(),"sidebar"==t.banner.code?n("div",[t._v("width: 570px, height: 200px.")]):t._e(),"square"==t.banner.code?n("div",[t._v("width: 360px, height: 360px.")]):t._e(),"line"==t.banner.code?n("div",[t._v("width: 360px, height: 360px.")]):t._e()])])},y=[],x=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),Object(i["b"])([Object(u["b"])()],e.prototype,"banner",void 0),Object(i["b"])([Object(u["b"])()],e.prototype,"settings",void 0),e=Object(i["b"])([Object(u["a"])({})],e),e}(r["default"]),C=x,O=C,j=n("2877"),D=Object(j["a"])(O,g,y,!1,null,null,null),P=D.exports,w=n("190e"),I=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=d["a"].instance,e.s=w["b"].instance,e.isMounted=!1,e.banner=new m["a"],e.uploadProgress=0,e.beginAtMin="",e.isSubmitted=!1,e.loading=!0,e.countries={},e.bannerPoints={},e.settings={},e.togglePointTable=!1,e}return Object(i["c"])(e,t),Object.defineProperty(e.prototype,"countryName",{get:function(){return this.banner.countryCode?this.countries[this.banner.countryCode]:this.countries[this.cafeCountryCode]},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t;return Object(i["d"])(this,(function(e){switch(e.label){case 0:return this.banner.countryCode=this.cafeCountryCode,this.loadCountries(),this.loadGlobalSettings(),t=parseInt(this.$route.params.idx),t?(this.banner.idx=t,[4,this.loadAdvertisement()]):[3,2];case 1:return e.sent(),[3,3];case 2:this.banner.categoryId="advertisement",e.label=3;case 3:return this.loading=!1,this.beginAtMin=this.today,this.isMounted=!0,[2]}}))}))},e.prototype.loadCountries=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),t=this,[4,this.api.countryAll()];case 1:return t.countries=n.sent(),[3,3];case 2:return e=n.sent(),this.s.error(e),[3,3];case 3:return[2]}}))}))},e.prototype.loadGlobalSettings=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,h["a"].instance.advertisementSettings()];case 1:return t=n.sent(),this.settings=t,this.bannerPoints=t.point[this.cafeCountryCode],this.bannerPoints||(this.bannerPoints=t.point["default"]),this.bannerPoints||(this.bannerPoints={}),[3,3];case 2:return e=n.sent(),w["b"].instance.error(e),[3,3];case 3:return[2]}}))}))},e.prototype.isEmptyObj=function(t){return Object(b["e"])(t)},Object.defineProperty(e.prototype,"today",{get:function(){return v()().format("YYYY-MM-DD")},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"priceInPoint",{get:function(){if(!this.noOfDays)return 0;var t=this.bannerPoints[this.banner.code];return""==this.banner.subcategory&&this.settings.globalBannerMultiplying&&(t*=this.settings.globalBannerMultiplying),t*this.noOfDays},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"endAtMin",{get:function(){var t=v()();return this.banner.beginDate&&(t=v()(this.banner.beginDate)),t.format("YYYY-MM-DD")},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"endAtMax",{get:function(){var t=v()();return this.banner.beginDate&&(t=v()(this.banner.beginDate)),this.settings.maximumAdvertisementDays>0?t.add(this.settings.maximumAdvertisementDays-1,"d").format("YYYY-MM-DD"):""},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"beginAtMax",{get:function(){return this.banner.endDate?v()(this.banner.endDate).format("YYYY-MM-DD"):""},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"noOfDays",{get:function(){if(v()(this.banner.beginDate).isSame(this.banner.endDate,"d"))return 1;var t=Object(b["b"])(this.banner.beginDate,this.banner.endDate);return t?t+1:0},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"servingDaysLeft",{get:function(){return this.isDue?0:this.isRefundable?Object(b["b"])(this.today,this.banner.endDate):this.noOfDays},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isPointInsufficient",{get:function(){return!this.api._user||(0==this.api._user.point||(!!this.isEmptyObj(this.bannerPoints)||this.api._user.point<this.priceInPoint))},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isRefundable",{get:function(){return!!v()().isSame(this.banner.beginDate,"day")||v()().isAfter(this.banner.beginDate,"day")},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isCancellable",{get:function(){return v()().isBefore(this.banner.beginDate,"day")},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"refundablePoints",{get:function(){return this.servingDaysLeft<0?0:this.servingDaysLeft*this.banner.pointPerDay},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"canStart",{get:function(){return!(!this.banner.beginDate||!this.banner.endDate)&&(!this.isPointInsufficient&&!this.isDue)},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"isDue",{get:function(){return v()().isAfter(this.banner.endDate,"d")},enumerable:!1,configurable:!0}),e.prototype.loadAdvertisement=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),t=this,[4,h["a"].instance.advertisementGet({idx:this.banner.idx})];case 1:return t.banner=n.sent(),[3,3];case 2:return e=n.sent(),this.s.error(e),[3,3];case 3:return[2]}}))}))},e.prototype.onSubmit=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(i["d"])(this,(function(s){switch(s.label){case 0:if(this.isSubmitted)return[2];this.isSubmitted=!0,t=!0,this.banner.idx&&(t=!1),s.label=1;case 1:return s.trys.push([1,3,,4]),[4,h["a"].instance.advertisementEdit(this.banner.toJson)];case 2:return e=s.sent(),Object.assign(this.banner,e),t?this.s.open("/advertisement/edit/"+this.banner.idx):this.s.toast({title:"Updated",message:"Advertisement successfully updated!"}),this.isSubmitted=!1,[3,4];case 3:return n=s.sent(),this.s.error(n),this.isSubmitted=!1,[3,4];case 4:return[2]}}))}))},e.prototype.onAdvertisementStart=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,h["a"].instance.advertisementStart(this.banner.toJson)];case 1:return t=n.sent(),this.banner=t,this.$emit("start"),[3,3];case 2:return e=n.sent(),this.s.error(e),[3,3];case 3:return[2]}}))}))},e.prototype.onAdvertisementStop=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(i["d"])(this,(function(s){switch(s.label){case 0:return[4,this.s.confirm("Title","Are you sure you want to cancel the advertisement?")];case 1:if(t=s.sent(),!t)return[2];s.label=2;case 2:return s.trys.push([2,4,,5]),e=this,[4,h["a"].instance.advertisementStop(this.banner.idx)];case 3:return e.banner=s.sent(),this.$emit("stop"),[3,5];case 4:return n=s.sent(),this.s.error(n),[3,5];case 5:return[2]}}))}))},e.prototype.advertisementDelete=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(i["d"])(this,(function(s){switch(s.label){case 0:return[4,this.s.confirm("Title","Are you sure you want to delete the advertisement?")];case 1:if(t=s.sent(),!t)return[2];s.label=2;case 2:return s.trys.push([2,4,,5]),e=this,[4,h["a"].instance.advertisementDelete(this.banner.idx)];case 3:return e.banner=s.sent(),this.s.open("/advertisement"),[3,5];case 4:return n=s.sent(),this.s.error(n),[3,5];case 5:return[2]}}))}))},e.prototype.onFileUpload=function(t){this.banner.fileIdxes=Object(b["a"])(this.banner.fileIdxes,t.idx),console.log("onFileUpload",this.banner.fileIdxes)},e.prototype.onFileDelete=function(t){this.banner.fileIdxes=Object(b["c"])(this.banner.fileIdxes,t),console.log("onFileDelete",this.banner.fileIdxes)},Object(i["b"])([Object(u["b"])()],e.prototype,"cafeCountryCode",void 0),e=Object(i["b"])([Object(u["a"])({components:{UploadImage:_["a"],LoginFirst:p["a"],BannerType:P}})],e),e}(r["default"]),A=I,S=A,M=Object(j["a"])(S,l,c,!1,null,null,null),k=M.exports,$=n("d68b"),Y=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=$["a"].instance,e}return Object(i["c"])(e,t),e.prototype.onStartOrStop=function(){this.app.refreshProfile()},e=Object(i["b"])([Object(o["b"])({components:{AdvertisementEdit:k}})],e),e}(r["default"]),U=Y,T=U,E=Object(j["a"])(T,s,a,!1,null,null,null);e["default"]=E.exports},6674:function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.api._user.notLoggedIn?n("div",{staticClass:"p-2 text-center rounded bg-secondary"},[n("h3",[t._v("Login First")])]):t._e()},a=[],i=n("9ab4"),r=n("9f3a"),o=n("2b0e"),l=n("2fe1"),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=r["a"].instance,e}return Object(i["c"])(e,t),e=Object(i["b"])([Object(l["b"])({})],e),e}(o["default"]),u=c,d=u,b=n("2877"),_=Object(b["a"])(d,s,a,!1,null,null,null);e["a"]=_.exports},"85bc":function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512"}},[n("path",{attrs:{d:"M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"}})])},a=[],i=n("2877"),r={},o=Object(i["a"])(r,s,a,!1,null,null,null);e["a"]=o.exports},c210:function(t,e,n){"use strict";var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",["linear"==t.ui?n("section",{staticClass:"upload-image-linear"},[n("div",{staticClass:"uploaded-image d-inline-block",staticStyle:{position:"relative"}},[t.file.url?n("img",{staticClass:"w-100",attrs:{src:t.file.url}}):t._e(),t.file.idx?n("div",{staticClass:"close-button",on:{click:t.onClickDeleteImage}},[n("div",[t._v("×")])]):t._e()]),n("div",{staticClass:"upload-button"},[n("input",{attrs:{type:"file"},on:{change:function(e){return t.onFileChangeImage(e,"banner")}}})])]):t._e(),"circle"==t.ui?n("section",{staticClass:"upload-image-circle"},[n("div",{staticClass:"base"},[0==t.loading?n("b-avatar",{attrs:{src:t.file.url,size:"8rem"}}):t._e(),n("CameraSvg",{staticClass:"camera"}),n("input",{attrs:{type:"file"},on:{change:function(e){return t.onFileChangeImage(e,"banner")}}})],1),t.file.idx?n("div",{staticClass:"trash",on:{click:t.onClickDeleteImage}},[n("TrashSvg",{staticClass:"trash-icon"})],1):t._e()]):t._e()])},a=[],i=(n("d3b7"),n("9ab4")),r=n("2b0e"),o=n("466c"),l=n("9f3a"),c=n("d661"),u=n("1b40"),d=n("11c8"),b=n("85bc"),_=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.percent=0,e.file=new o["d"],e.confirmDelete=Object(c["g"])("do_you_want_to_delete"),e.api=l["a"].instance,e.loading=!0,e}return Object(i["c"])(e,t),e.prototype.mounted=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(i["d"])(this,(function(s){switch(s.label){case 0:return s.trys.push([0,3,,4]),this.entity&&this.code||this.userIdx&&this.code?(t={taxonomy:this.taxonomy,entity:this.entity,code:this.code,userIdx:this.userIdx},e=this,[4,this.api.fileGet(t)]):[3,2];case 1:e.file=s.sent(),s.label=2;case 2:return[3,4];case 3:return n=s.sent(),"error_entity_not_found"!==n?this.$emit("error",n):this.file.url=this.defaultImageUrl,[3,4];case 4:return this.loading=!1,[2]}}))}))},e.prototype.deleteImage=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t;return Object(i["d"])(this,(function(e){switch(e.label){case 0:if(!this.file.idx)return[2];e.label=1;case 1:return e.trys.push([1,3,,4]),[4,this.api.fileDelete(this.file.idx)];case 2:return e.sent(),this.$emit("deleted",this.file.idx),this.file=new o["d"],this.defaultImageUrl&&(this.file.url=this.defaultImageUrl),[3,4];case 3:return t=e.sent(),this.$emit("error",t),[3,4];case 4:return[2]}}))}))},e.prototype.onClickDeleteImage=function(){var t=confirm(this.confirmDelete);t&&this.deleteImage()},e.prototype.onFileChangeImage=function(t){return Object(i["a"])(this,void 0,Promise,(function(){var e,n,s,a,r=this;return Object(i["d"])(this,(function(i){switch(i.label){case 0:if(e=t.target.files,0===e.length)return[2];n=e[0],this.deleteImage(),i.label=1;case 1:return i.trys.push([1,3,,4]),s=this,[4,this.api.fileUpload(n,{taxonomy:this.taxonomy,entity:this.entity,code:this.code},(function(t){r.percent=t,r.$emit("progress",t)}))];case 2:return s.file=i.sent(),this.$emit("uploaded",this.file),this.$emit("progress",0),[3,4];case 3:return a=i.sent(),this.$emit("error",a),[3,4];case 4:return[2]}}))}))},Object(i["b"])([Object(u["b"])({default:"linear"})],e.prototype,"ui",void 0),Object(i["b"])([Object(u["b"])()],e.prototype,"taxonomy",void 0),Object(i["b"])([Object(u["b"])()],e.prototype,"entity",void 0),Object(i["b"])([Object(u["b"])()],e.prototype,"code",void 0),Object(i["b"])([Object(u["b"])()],e.prototype,"userIdx",void 0),Object(i["b"])([Object(u["b"])({default:""})],e.prototype,"defaultImageUrl",void 0),e=Object(i["b"])([Object(u["a"])({components:{CameraSvg:d["a"],TrashSvg:b["a"]}})],e),e}(r["default"]),p=_,f=p,v=(n("def4"),n("2877")),m=Object(v["a"])(f,s,a,!1,null,"7857f2a4",null);e["a"]=m.exports},def4:function(t,e,n){"use strict";n("3d1d")}}]);
//# sourceMappingURL=chunk-10c02e58.2c4c2e1d.js.map