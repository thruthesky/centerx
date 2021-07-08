(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0ab7fd"],{1613:function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h4",[t._v(t._s(t._f("t")("Users")))]),s("div",{staticClass:"d-flex justify-content-end mb-3"},[s("div",{staticClass:"mt-2 fw-700"},[t._v(t._s(t._f("t")("no_of_users"))+": "+t._s(t.total))]),s("span",{staticClass:"flex-grow-1"}),s("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmitSearch.apply(null,arguments)}}},[s("div",{staticClass:"form-row align-items-center"},[s("div",{staticClass:"col-auto"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.searchKey,expression:"searchKey"}],staticClass:"form-control mb-2",attrs:{type:"text",name:"searchKey",placeholder:t._f("t")("enter_email_address_or_name")},domProps:{value:t.searchKey},on:{input:function(e){e.target.composing||(t.searchKey=e.target.value)}}})]),s("div",{staticClass:"col-auto"},[s("button",{staticClass:"btn btn-primary mb-2",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])])])])]),t.users?s("div",[s("div",{staticClass:"p-1 mb-3 border-radius-sm",staticStyle:{border:"1px solid #e8e8e8"}},[s("div",{staticClass:"m-2"},[t._v(t._s(t._f("t")("Fields")))]),t._l(t.options,(function(e,a){return s("div",{key:a,staticClass:"custom-control custom-checkbox custom-control-inline m-2 fs-sm align-middle"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.options[a],expression:"options[key]"}],staticClass:"custom-control-input",attrs:{"data-cy":a+"-option",type:"checkbox",id:a+"-option"},domProps:{checked:Array.isArray(t.options[a])?t._i(t.options[a],null)>-1:t.options[a]},on:{change:function(e){var s=t.options[a],i=e.target,o=!!i.checked;if(Array.isArray(s)){var n=null,c=t._i(s,n);i.checked?c<0&&t.$set(t.options,a,s.concat([n])):c>-1&&t.$set(t.options,a,s.slice(0,c).concat(s.slice(c+1)))}else t.$set(t.options,a,o)}}}),s("label",{staticClass:"custom-control-label text-capitalize",attrs:{for:a+"-option"}},[t._v(t._s(a))])])}))],2),s("section",{staticClass:"overflow-auto"},[s("table",{staticClass:"table table-striped fs-sm"},[s("thead",{staticClass:"thead-dark"},[s("tr",[s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v("#")]),t.options.email?s("th",{staticClass:"align-middle",attrs:{"data-cy":"firebaseUid-col-header",scope:"col"}},[t._v(" "+t._s(t._f("t")("email"))+" ")]):t._e(),t.options.firebaseUid?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("firebase_uid"))+" ")]):t._e(),t.options.name?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("name"))+" ")]):t._e(),t.options.nickname?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("nickname"))+" ")]):t._e(),t.options.point?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("point"))+" ")]):t._e(),t.options.phoneNo?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("phone_no"))+" ")]):t._e(),t.options.gender?s("th",{staticClass:"align-middle",attrs:{"data-cy":"gender-col-header",scope:"col"}},[t._v(" "+t._s(t._f("t")("gender"))+" ")]):t._e(),t.options.birthdate?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("birthdate"))+" ")]):t._e(),t.options.countryCode?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("country_code"))+" ")]):t._e(),t.options.province?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("province"))+" ")]):t._e(),t.options.city?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("city"))+" ")]):t._e(),t.options.address?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("address"))+" ")]):t._e(),t.options.zipcode?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("zipcode"))+" ")]):t._e(),t.options.createdAt?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("created_at"))+" ")]):t._e(),t.options.updatedAt?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("updated_at"))+" ")]):t._e(),s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(t._s(t._f("t")("edit")))])])]),s("tbody",t._l(t.users,(function(e){return s("tr",{key:e.idx},[s("th",{attrs:{scope:"row"}},[t._v(t._s(e.idx))]),t.options.email?s("td",[t._v(t._s(e.email))]):t._e(),t.options.firebaseUid?s("td",[t._v(t._s(e.firebaseUid))]):t._e(),t.options.name?s("td",[t._v(t._s(e.name))]):t._e(),t.options.nickname?s("td",[t._v(t._s(e.nickname))]):t._e(),t.options.point?s("td",[t._v(t._s(e.point))]):t._e(),t.options.phoneNo?s("td",[t._v(t._s(e.phoneNo))]):t._e(),t.options.gender?s("td",[t._v(t._s(e.gender))]):t._e(),t.options.birthdate?s("td",[t._v(t._s(e.birthdate))]):t._e(),t.options.countryCode?s("td",[t._v(t._s(e.countryCode))]):t._e(),t.options.province?s("td",[t._v(t._s(e.province))]):t._e(),t.options.city?s("td",[t._v(t._s(e.city))]):t._e(),t.options.address?s("td",[t._v(t._s(e.address))]):t._e(),t.options.zipcode?s("td",[t._v(t._s(e.zipcode))]):t._e(),t.options.createdAt?s("td",[t._v(t._s(e.createdAt))]):t._e(),t.options.updatedAt?s("td",[t._v(t._s(e.updatedAt))]):t._e(),s("td",[s("router-link",{staticClass:"btn btn-sm btn-outline-primary",attrs:{"data-cy":"user-info-edit-button",to:t.editLink(e)}},[t._v(" "+t._s(t._f("t")("edit"))+" ")])],1)])})),0)])])]):t._e(),s("div",{staticClass:"overflow-auto"},[s("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])},i=[],o=s("1da1"),n=s("d4ec"),c=s("bee2"),r=s("262e"),l=s("2caf"),d=(s("96cf"),s("ac1f"),s("841c"),s("9ab4")),_=s("9f3a"),p=s("2b0e"),u=s("2fe1"),m=s("f6b1"),h=function(t){Object(r["a"])(s,t);var e=Object(l["a"])(s);function s(){var t;return Object(n["a"])(this,s),t=e.apply(this,arguments),t.s=m["a"].instance,t.users=[],t.total=0,t.limit=5,t.searchKey="",t.noOfPages=10,t.currentPage="1",t.options={email:!0,firebaseUid:!1,name:!0,nickname:!0,point:!0,phoneNo:!0,gender:!1,birthdate:!1,countryCode:!1,province:!1,city:!1,address:!1,zipcode:!1,createdAt:!1,updatedAt:!1},t}return Object(c["a"])(s,[{key:"editLink",value:function(t){return"/admin/user/edit/"+t.idx+window.location.search}},{key:"linkGen",value:function(t){return 1===t?"?":"?page=".concat(t)}},{key:"onPageChanged",value:function(t){this.currentPage=""+t,this.onSubmitSearch()}},{key:"mounted",value:function(){this.currentPage=this.$route.query.page?this.$route.query.page:"1",this.onSubmitSearch()}},{key:"onSubmitSearch",value:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,_["a"].instance.userSearch({searchKey:this.searchKey,limit:this.limit,page:this.currentPage,full:!0});case 3:return this.users=t.sent,t.next=6,_["a"].instance.userCount({searchKey:this.searchKey});case 6:this.total=t.sent,this.noOfPages=Math.ceil(this.total/this.limit),t.next=13;break;case 10:t.prev=10,t.t0=t["catch"](0),this.s.error(t.t0);case 13:case"end":return t.stop()}}),t,this,[[0,10]])})));function e(){return t.apply(this,arguments)}return e}()}]),s}(p["default"]);h=Object(d["a"])([Object(u["b"])({})],h);var v=h,f=v,b=s("2877"),g=Object(b["a"])(f,a,i,!1,null,null,null);e["default"]=g.exports}}]);
//# sourceMappingURL=chunk-2d0ab7fd.d6efe561.js.map