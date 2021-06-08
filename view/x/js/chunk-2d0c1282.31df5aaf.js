(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c1282"],{"459d":function(t,e,s){"use strict";s.r(e);var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h1",[t._v("Admin")]),s("div",[s("b-card",{attrs:{"no-body":""}},[s("b-tabs",{attrs:{pills:"",card:""}},[s("b-tab",{attrs:{title:"User",active:""}},[s("admin-user-list")],1),s("b-tab",{attrs:{title:"Category"}},[s("admin-category-list")],1),s("b-tab",{attrs:{title:"Posts"}},[s("admin-post-list")],1),s("b-tab",{attrs:{title:"Files"}},[s("admin-file-list")],1),s("b-tab",{attrs:{title:"Settings"}},[s("admin-settings")],1)],1)],1)],1)])},a=[],n=s("9ab4"),o=s("2b0e"),r=s("2fe1"),l=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h4",[t._v("Users")]),s("div",{staticClass:"d-flex justify-content-end mb-3"},[s("div",{staticClass:"mt-2 fw-700"},[t._v(t._s(t._f("t")("No·of·Users"))+":"+t._s(t.total))]),s("span",{staticClass:"flex-grow-1"}),s("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmitSearch.apply(null,arguments)}}},[s("div",{staticClass:"form-row align-items-center"},[s("div",{staticClass:"col-auto"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.searchKey,expression:"searchKey"}],staticClass:"form-control mb-2",attrs:{type:"text",name:"key",placeholder:"사용자 메일 주소, 이름을 입력해주세요."},domProps:{value:t.searchKey},on:{input:function(e){e.target.composing||(t.searchKey=e.target.value)}}})]),s("div",{staticClass:"col-auto"},[s("button",{staticClass:"btn btn-primary mb-2",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])])])])]),t.users?s("div",[s("div",{staticClass:"p-1 mb-3 border-radius-sm",staticStyle:{border:"1px solid #e8e8e8"}},[s("div",{staticClass:"m-2"},[t._v(t._s(t._f("t")("Fields")))]),t._l(t.options,(function(e,i){return s("div",{key:i,staticClass:"\n          custom-control custom-checkbox custom-control-inline\n          m-2\n          fs-sm\n          align-middle\n        "},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.options[i],expression:"options[key]"}],staticClass:"custom-control-input",attrs:{"data-cy":i+"-option",type:"checkbox",id:i+"-option"},domProps:{checked:Array.isArray(t.options[i])?t._i(t.options[i],null)>-1:t.options[i]},on:{change:function(e){var s=t.options[i],a=e.target,n=!!a.checked;if(Array.isArray(s)){var o=null,r=t._i(s,o);a.checked?r<0&&t.$set(t.options,i,s.concat([o])):r>-1&&t.$set(t.options,i,s.slice(0,r).concat(s.slice(r+1)))}else t.$set(t.options,i,n)}}}),s("label",{staticClass:"custom-control-label text-capitalize",attrs:{for:i+"-option"}},[t._v(t._s(i))])])}))],2),s("section",{staticClass:"overflow-auto"},[s("table",{staticClass:"table table-striped fs-sm"},[s("thead",{staticClass:"thead-dark"},[s("tr",[s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v("#")]),t.options.email?s("th",{staticClass:"align-middle",attrs:{"data-cy":"firebaseUid-col-header",scope:"col"}},[t._v(" "+t._s(t._f("t")("email"))+" ")]):t._e(),t.options.firebaseUid?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("firebase_uid"))+" ")]):t._e(),t.options.name?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("name"))+" ")]):t._e(),t.options.nickname?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("nickname"))+" ")]):t._e(),t.options.point?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("point"))+" ")]):t._e(),t.options.phoneNo?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("phone_no"))+" ")]):t._e(),t.options.gender?s("th",{staticClass:"align-middle",attrs:{"data-cy":"gender-col-header",scope:"col"}},[t._v(" "+t._s(t._f("t")("gender"))+" ")]):t._e(),t.options.birthdate?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("birthdate"))+" ")]):t._e(),t.options.countryCode?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("country_code"))+" ")]):t._e(),t.options.province?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("province"))+" ")]):t._e(),t.options.city?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("city"))+" ")]):t._e(),t.options.address?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("address"))+" ")]):t._e(),t.options.zipcode?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("zipcode"))+" ")]):t._e(),t.options.createdAt?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("created_at"))+" ")]):t._e(),t.options.updatedAt?s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(" "+t._s(t._f("t")("updated_at"))+" ")]):t._e(),s("th",{staticClass:"align-middle",attrs:{scope:"col"}},[t._v(t._s(t._f("t")("edit")))])])]),s("tbody",t._l(t.users,(function(e){return s("tr",{key:e.idx},[s("th",{attrs:{scope:"row"}},[t._v(t._s(e.idx))]),t.options.email?s("td",[t._v(t._s(e.email))]):t._e(),t.options.firebaseUid?s("td",[t._v(t._s(e.firebaseUid))]):t._e(),t.options.name?s("td",[t._v(t._s(e.name))]):t._e(),t.options.nickname?s("td",[t._v(t._s(e.nickname))]):t._e(),t.options.point?s("td",[t._v(t._s(e.point))]):t._e(),t.options.phoneNo?s("td",[t._v(t._s(e.phoneNo))]):t._e(),t.options.gender?s("td",[t._v(t._s(e.gender))]):t._e(),t.options.birthdate?s("td",[t._v(t._s(e.birthdate))]):t._e(),t.options.countryCode?s("td",[t._v(t._s(e.countryCode))]):t._e(),t.options.province?s("td",[t._v(t._s(e.province))]):t._e(),t.options.city?s("td",[t._v(t._s(e.city))]):t._e(),t.options.address?s("td",[t._v(t._s(e.address))]):t._e(),t.options.zipcode?s("td",[t._v(t._s(e.zipcode))]):t._e(),t.options.createdAt?s("td",[t._v(t._s(e.createdAt))]):t._e(),t.options.updatedAt?s("td",[t._v(t._s(e.updatedAt))]):t._e(),s("td",[s("router-link",{staticClass:"btn btn-sm btn-outline-primary",attrs:{"data-cy":"user-info-edit-button",to:"admin/user/edit/"+e.idx}},[t._v("edit")])],1)])})),0)])])]):t._e(),s("div",{staticClass:"overflow-auto"},[s("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])},c=[],d=(s("d3b7"),s("d68b")),p=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.users=[],e.total=0,e.limit=3,e.searchKey="",e.noOfPages=10,e.currentPage="1",e.options={email:!0,firebaseUid:!1,name:!0,nickname:!0,point:!0,phoneNo:!0,gender:!1,birthdate:!1,countryCode:!1,province:!1,city:!1,address:!1,zipcode:!1,createdAt:!1,updatedAt:!1},e}return Object(n["c"])(e,t),e.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},e.prototype.onPageChanged=function(t){console.log("page; ",t),this.onSubmitSearch()},e.prototype.mounted=function(){this.currentPage=this.$route.query.page,this.onSubmitSearch()},e.prototype.onSubmitSearch=function(){var t;return Object(n["a"])(this,void 0,Promise,(function(){var e,s,i;return Object(n["d"])(this,(function(a){switch(a.label){case 0:console.log("page changed",this.currentPage),a.label=1;case 1:return a.trys.push([1,4,,5]),e=this,[4,this.app.api.userSearch({searchKey:this.searchKey,limit:this.limit,page:null!==(t=this.currentPage)&&void 0!==t?t:"1",full:!0})];case 2:return e.users=a.sent(),console.log(this.users),s=this,[4,this.app.api.userCount({searchKey:this.searchKey})];case 3:return s.total=a.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,5];case 4:return i=a.sent(),this.app.error(i),[3,5];case 5:return[2]}}))}))},e=Object(n["b"])([Object(r["a"])({})],e),e}(o["a"]),u=p,_=u,m=s("2877"),h=Object(m["a"])(_,l,c,!1,null,null,null),b=h.exports,v=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("h4",[t._v("Category list")])},f=[],g=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(r["a"])({})],e),e}(o["a"]),y=g,C=y,O=Object(m["a"])(C,v,f,!1,null,null,null),j=O.exports,k=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("h4",[t._v("Post list")])},x=[],A=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(r["a"])({})],e),e}(o["a"]),P=A,w=P,S=Object(m["a"])(w,k,x,!1,null,null,null),$=S.exports,E=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("h4",[t._v("File list")])},K=[],U=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(r["a"])({})],e),e}(o["a"]),N=U,z=N,F=Object(m["a"])(z,E,K,!1,null,null,null),L=F.exports,I=function(){var t=this,e=t.$createElement;t._self._c;return t._m(0)},G=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h4",[t._v("Admin Settings")]),s("form",[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"exampleInputEmail1"}},[t._v("Admin email addresses")]),s("input",{staticClass:"form-control",attrs:{type:"email",id:"exampleInputEmail1","aria-describedby":"emailHelp"}}),s("small",{staticClass:"form-text text-muted",attrs:{id:"emailHelp"}},[t._v(" Input multip admin email addresses separating by comma(,). ")])])])])}],H=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form={},e}return Object(n["c"])(e,t),e=Object(n["b"])([Object(r["a"])({})],e),e}(o["a"]),J=H,q=J,D=Object(m["a"])(q,I,G,!1,null,null,null),M=D.exports,B=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(r["a"])({components:{AdminUserList:b,AdminCategoryList:j,AdminPostList:$,AdminFileList:L,AdminSettings:M}})],e),e}(o["a"]),Q=B,R=Q,T=Object(m["a"])(R,i,a,!1,null,null,null);e["default"]=T.exports}}]);
//# sourceMappingURL=chunk-2d0c1282.31df5aaf.js.map