(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-6c36131c"],{"0e81":function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("b-tabs",{attrs:{"content-class":"mt-3"}},[s("b-tab",{attrs:{title:"Advertisement Settings",active:""}},[s("AdminAdvertisementSettings")],1),s("b-tab",{attrs:{title:"Advertisement List"}},[s("AdminAdvertisementList")],1)],1)],1)},a=[],i=s("9ab4"),r=s("2b0e"),o=s("2fe1"),l=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h1",[t._v("Admin Advertisement Settings")]),s("form",{staticClass:"mb-3",on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"maximum-advertisement-days"}},[t._v("Maximum Advertisement Days")]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.maximumAdvertisementDays,expression:"maximumAdvertisementDays"}],staticClass:"form-control",attrs:{type:"number",id:"maximum-advertisement-days"},domProps:{value:t.maximumAdvertisementDays},on:{input:function(e){e.target.composing||(t.maximumAdvertisementDays=e.target.value)}}}),s("small",{staticClass:"form-text text-muted"},[t._v(" Users cannot set advertisement end-date later than this day. For instance, if it is set to 5 days, user can set his advertisement only for 5 days from today. ")])]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"advertisementCategories"}},[t._v("Categories")]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.advertisementCategories,expression:"advertisementCategories"}],staticClass:"form-control",attrs:{type:"text",id:"advertisementCategories"},domProps:{value:t.advertisementCategories},on:{input:function(e){e.target.composing||(t.advertisementCategories=e.target.value)}}}),s("small",{staticClass:"form-text text-muted"},[t._v(' Categories to display banners on. These categories will appear on banner edit form. You can input many categories separating by comma(,). For instance, "qna,discussion,job" ')])]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"globalBannerMultiplying"}},[t._v("Global banner price by multiplying")]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.globalBannerMultiplying,expression:"globalBannerMultiplying"}],staticClass:"form-control",attrs:{type:"number",id:"globalBannerMultiplying"},domProps:{value:t.globalBannerMultiplying},on:{input:function(e){e.target.composing||(t.globalBannerMultiplying=e.target.value)}}}),s("small",{staticClass:"form-text text-muted"},[t._v(" Global banner has more change to be displayed on many subcategories. So, it should be expansive than categories banners. Input how many times to multiply on each banner price. @see README.md for details. ")]),t._m(0)]),s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])]),s("hr"),s("h3",[t._v("Add banner points for a country")]),s("form",{on:{submit:function(e){return e.preventDefault(),t.onEdit(t.add)}}},[s("div",{staticClass:"row no-gutters w-100"},[s("div",{staticClass:"col-3 pl-0 pr-1"},[t._v(" "+t._s(t._f("t")("country"))+" "),s("select",{directives:[{name:"model",rawName:"v-model",value:t.add.countryCode,expression:"add.countryCode"}],staticClass:"form-control",on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.add,"countryCode",e.target.multiple?s:s[0])}}},[s("option",{attrs:{value:"",selected:""}},[t._v(t._s(t._f("t")("default")))]),t._l(t.countries,(function(e,n){return s("option",{key:n,domProps:{value:n}},[t._v(" "+t._s(e)+" ")])}))],2)]),s("div",{staticClass:"col-2 px-1"},[t._v(" "+t._s(t._f("t")("top"))+" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.add.top,expression:"add.top"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.add.top},on:{input:function(e){e.target.composing||t.$set(t.add,"top",e.target.value)}}})]),s("div",{staticClass:"col-2 px-1"},[t._v(" "+t._s(t._f("t")("sidebar"))+" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.add.sidebar,expression:"add.sidebar"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.add.sidebar},on:{input:function(e){e.target.composing||t.$set(t.add,"sidebar",e.target.value)}}})]),s("div",{staticClass:"col-2 px-1"},[t._v(" "+t._s(t._f("t")("square"))+" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.add.square,expression:"add.square"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.add.square},on:{input:function(e){e.target.composing||t.$set(t.add,"square",e.target.value)}}})]),s("div",{staticClass:"col-2 px-1"},[t._v(" "+t._s(t._f("t")("line"))+" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.add.line,expression:"add.line"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.add.line},on:{input:function(e){e.target.composing||t.$set(t.add,"line",e.target.value)}}})]),s("div",{staticClass:"col-1 pl-1 pr-0"},[s("button",{staticClass:"btn btn-primary mt-4"},[t._v(" "+t._s(t._f("t")("add"))+" ")])])]),s("div",{staticClass:"mt-2 alert alert-info"},[t._v(" Don't input countryCode for default banner point. countryCode 에 빈 문자열을 입력하면 default setting 이 됨. ")])]),t.points.length?s("table",{staticClass:"mt-3 w-100 table"},[t._m(1),s("tbody",t._l(t.points.length,(function(e){return s("tr",{key:e},[s("th",{staticClass:"p-1",attrs:{scope:"row"}},[t._v(" "+t._s(t._f("t")(t.points[e-1].countryCode?t.points[e-1].countryCode:"default_banner_point_setting"))+" ")]),s("td",{staticClass:"p-1"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.points[e-1].top,expression:"points[n - 1].top"}],staticClass:"form-control px-1",attrs:{type:"number"},domProps:{value:t.points[e-1].top},on:{input:function(s){s.target.composing||t.$set(t.points[e-1],"top",s.target.value)}}})]),s("td",{staticClass:"p-1"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.points[e-1].sidebar,expression:"points[n - 1].sidebar"}],staticClass:"form-control px-1",attrs:{type:"number"},domProps:{value:t.points[e-1].sidebar},on:{input:function(s){s.target.composing||t.$set(t.points[e-1],"sidebar",s.target.value)}}})]),s("td",{staticClass:"p-1"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.points[e-1].square,expression:"points[n - 1].square"}],staticClass:"form-control px-1",attrs:{type:"number"},domProps:{value:t.points[e-1].square},on:{input:function(s){s.target.composing||t.$set(t.points[e-1],"square",s.target.value)}}})]),s("td",{staticClass:"p-1"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.points[e-1].line,expression:"points[n - 1].line"}],staticClass:"form-control px-1",attrs:{type:"number"},domProps:{value:t.points[e-1].line},on:{input:function(s){s.target.composing||t.$set(t.points[e-1],"line",s.target.value)}}})]),s("td",{staticClass:"p-1 d-flex"},[s("button",{staticClass:"w-100 btn btn-primary btn-sm mr-1",on:{click:function(s){return t.onEdit(t.points[e-1])}}},[t._v("Update")]),s("button",{staticClass:"w-100 btn btn-warning btn-sm",on:{click:function(s){return t.onDelete(t.points[e-1])}}},[t._v("Delete")])])])})),0)]):t._e(),t._m(2)])},c=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("small",{staticClass:"form-text text-muted"},[t._v("Recommend value for global banner multiplying is: "),s("b",[t._v("4")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",[s("th",{attrs:{scope:"col"}},[t._v("CountryCode")]),s("th",{attrs:{scope:"col"}},[t._v("Top")]),s("th",{attrs:{scope:"col"}},[t._v("Sidebar")]),s("th",{attrs:{scope:"col"}},[t._v("Square")]),s("th",{attrs:{scope:"col"}},[t._v("Line")]),s("th",{attrs:{scope:"col"}},[t._v("Actions")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",[s("li",[t._v(" Default is the default point that will apply all the countries by default unless country are set above. @see readme. ")])])}],u=(s("d3b7"),s("a15b"),s("9f3a")),d=s("190e"),m=s("5709"),p=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=u["a"].instance,e.s=d["b"].instance,e.maximumAdvertisementDays=0,e.advertisementCategories="",e.globalBannerMultiplying=0,e.points=[],e.add={},e.countries={},e}return Object(i["c"])(e,t),e.prototype.mounted=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,s,n;return Object(i["d"])(this,(function(a){switch(a.label){case 0:return a.trys.push([0,4,,5]),[4,m["a"].instance.advertisementSettings()];case 1:return t=a.sent(),this.maximumAdvertisementDays=t.maximumAdvertisementDays,this.advertisementCategories=t.categoryArray.join(","),this.globalBannerMultiplying=t.globalBannerMultiplying,e=this,[4,m["a"].instance.advertisementGetBannerPoints()];case 2:return e.points=a.sent(),s=this,[4,this.api.countryAll()];case 3:return s.countries=a.sent(),[3,5];case 4:return n=a.sent(),this.s.error(n),[3,5];case 5:return[2]}}))}))},e.prototype.onEdit=function(t){return Object(i["a"])(this,void 0,Promise,(function(){var e,s;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,3,,4]),[4,m["a"].instance.advertisementSetBannerPoint(t)];case 1:return n.sent(),e=this,[4,m["a"].instance.advertisementGetBannerPoints()];case 2:return e.points=n.sent(),this.add={},this.s.alert("Success","Point setting updated!"),[3,4];case 3:return s=n.sent(),this.s.error(s),[3,4];case 4:return[2]}}))}))},e.prototype.onDelete=function(t){return Object(i["a"])(this,void 0,Promise,(function(){var e,s,n;return Object(i["d"])(this,(function(a){switch(a.label){case 0:return console.log("onDelete::data",t),[4,this.s.confirm("Confirm","Delete point settings for "+t.countryCode+"?")];case 1:if(e=a.sent(),!e)return[2];a.label=2;case 2:return a.trys.push([2,5,,6]),[4,m["a"].instance.advertisementDeleteBannerPoint(t.idx)];case 3:return a.sent(),s=this,[4,m["a"].instance.advertisementGetBannerPoints()];case 4:return s.points=a.sent(),[3,6];case 5:return n=a.sent(),this.s.error(n),[3,6];case 6:return[2]}}))}))},e.prototype.onSubmit=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t;return Object(i["d"])(this,(function(e){switch(e.label){case 0:return e.trys.push([0,4,,5]),[4,this.api.setConfig("maximumAdvertisementDays",this.maximumAdvertisementDays)];case 1:return e.sent(),[4,this.api.setConfig("advertisementCategories",this.advertisementCategories)];case 2:return e.sent(),[4,this.api.setConfig("globalBannerMultiplying",this.globalBannerMultiplying)];case 3:return e.sent(),this.s.alert("Settings","Saved!"),[3,5];case 4:return t=e.sent(),this.s.error(t),[3,5];case 5:return[2]}}))}))},e=Object(i["b"])([Object(o["b"])({components:{}})],e),e}(r["default"]),v=p,b=v,f=s("2877"),g=Object(f["a"])(b,l,c,!1,null,null,null),h=g.exports,y=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"admin-advertisement-list w-100"},[t.advertisements.length?s("div",[s("div",{staticClass:"mt-3 w-100"},t._l(t.advertisements,(function(e){return s("div",{key:e.idx,staticClass:"box d-flex p-2 mb-2"},[s("div",{staticClass:"col-10 p-0"},[s("router-link",{attrs:{to:"/advertisement/view/"+e.idx}},[s("advertisement-preview",{attrs:{advertisement:e}})],1)],1),s("div",{staticClass:"ml-1 px-2 py-0 text-center border-left col-2"},[s("b-avatar",{staticClass:"center",attrs:{tabindex:"0",src:e.user.src,size:"4em"}}),s("div",{staticClass:"w-100 text-truncate"},[t._v(" "+t._s(e.user.displayName)+" ")])],1)])})),0),s("div",{staticClass:"d-flex overflow-auto justify-content-center"},[s("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.options.page,callback:function(e){t.$set(t.options,"page",e)},expression:"options.page"}})],1)]):t._e(),t.loading?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Loading Advertisements ... ")],1):t._e(),t.advertisements.length||t.loading?t._e():s("div",{staticClass:"box text-center mb-2"},[t._v(" "+t._s(t._f("t")("no_advertisements"))+" ")])])},_=[],C=s("e18f"),x=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=u["a"].instance,e.loading=!1,e.advertisements=[],e.total=0,e.limit=10,e.noOfPages=10,e.options={},e}return Object(i["c"])(e,t),e.prototype.mounted=function(){var t;return Object(i["a"])(this,void 0,Promise,(function(){var e,s;return Object(i["d"])(this,(function(n){switch(n.label){case 0:this.loading=!0,this.options.limit=this.limit,this.options.categoryId="advertisement",this.options.page=null!==(t=this.$route.query.page)&&void 0!==t?t:"1",n.label=1;case 1:return n.trys.push([1,4,,5]),[4,this.loadAdvertisements()];case 2:return n.sent(),e=this,[4,this.api.postCount(this.options)];case 3:return e.total=n.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,5];case 4:return s=n.sent(),d["b"].instance.error(s),[3,5];case 5:return[2]}}))}))},e.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},e.prototype.onPageChanged=function(t){this.options.page=t,this.loadAdvertisements()},e.prototype.loadAdvertisements=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(s){switch(s.label){case 0:this.loading=!0,s.label=1;case 1:return s.trys.push([1,3,,4]),t=this,[4,m["a"].instance.advertisementSearch(this.options)];case 2:return t.advertisements=s.sent(),this.loading=!1,[3,4];case 3:return e=s.sent(),this.loading=!1,d["b"].instance.error(e),[3,4];case 4:return[2]}}))}))},e=Object(i["b"])([Object(o["b"])({components:{AdvertisementPreview:C["a"]}})],e),e}(r["default"]),w=x,A=w,j=Object(f["a"])(A,y,_,!1,null,null,null),O=j.exports,P=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),e=Object(i["b"])([Object(o["b"])({components:{AdminAdvertisementSettings:h,AdminAdvertisementList:O}})],e),e}(r["default"]),D=P,B=D,S=Object(f["a"])(B,n,a,!1,null,null,null);e["default"]=S.exports},"1c0b1":function(t,e,s){"use strict";s("e00f")},"812b":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("svg",{staticClass:"bi bi-box-arrow-in-up-right",attrs:{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",viewBox:"0 0 16 16"}},[s("path",{attrs:{"fill-rule":"evenodd",d:"M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z"}}),s("path",{attrs:{"fill-rule":"evenodd",d:"M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z"}})])},a=[],i=s("2877"),r={},o=Object(i["a"])(r,n,a,!1,null,null,null);e["a"]=o.exports},e00f:function(t,e,s){},e18f:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"d-flex"},[s("div",{staticClass:"overflow-hidden mr-2"},[s("div",[s("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.advertisement.idx))]),t._v(" • "),t.advertisement.isActive?s("span",{staticClass:"badge badge-success ml-2"},[t._v(" Active ")]):t._e(),t.advertisement.isInactive?s("span",{staticClass:"badge badge-warning ml-2"},[t._v(" Inactive ")]):t._e(),t.advertisement.isWaiting?s("span",{staticClass:"badge badge-info ml-2"},[t._v(" Waiting ")]):t._e(),t.advertisement.code?s("span",{staticClass:"badge badge-secondary ml-2"},[t._v(" "+t._s(t.advertisement.code)+" ")]):t._e(),s("span",{staticClass:"badge badge-primary ml-2"},[t._v(" "+t._s(t.advertisement.subcategory?t.advertisement.subcategory:"global")+" ")])]),s("div",{staticClass:"title text-truncate font-weight-bold"},[t._v(" "+t._s(t.advertisement.title?t.advertisement.title:"No title ..")+" ")]),s("div",{staticClass:"content"},[t._v(" "+t._s(t.advertisement.content?t.advertisement.content:"No content ..")+" ")])]),s("span",{staticClass:"flex-grow-1"}),t._l(t.advertisement.files,(function(t){return s("div",{key:t.idx,staticClass:"p-1"},[s("img",{staticStyle:{height:"90px",width:"90px"},attrs:{src:t.url,alt:t.name}})])}))],2),s("span",{on:{click:function(e){return e.preventDefault(),t.as.openAdvertisement({idx:t.advertisement.idx})}}},[t._v(" "+t._s(t._f("t")("view"))+" "),s("BoxArrowUpRightSvg")],1)])},a=[],i=s("9ab4"),r=s("2b0e"),o=s("1b40"),l=s("812b"),c=s("5709"),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.as=c["a"].instance,e}return Object(i["c"])(e,t),Object(i["b"])([Object(o["b"])()],e.prototype,"advertisement",void 0),e=Object(i["b"])([Object(o["a"])({components:{BoxArrowUpRightSvg:l["a"]}})],e),e}(r["default"]),d=u,m=d,p=(s("1c0b1"),s("2877")),v=Object(p["a"])(m,n,a,!1,null,"1f0a91c0",null);e["a"]=v.exports}}]);
//# sourceMappingURL=chunk-6c36131c.e279a9b1.js.map