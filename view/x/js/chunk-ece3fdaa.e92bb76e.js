(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-ece3fdaa"],{"4cb2":function(e,t,a){"use strict";a.r(t);var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return e.api.loggedIn?a("section",{staticClass:"box"},[a("div",{staticClass:"d-flex justify-content-center"},[a("b-avatar",{attrs:{src:e.api.user.photuUrl,size:"8rem"}})],1),a("form",{on:{submit:function(t){return t.preventDefault(),e.onSubmit.apply(null,arguments)}}},[a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"point"}},[e._v(e._s(e._f("t")("point")))]),a("b-form-input",{attrs:{disabled:"",id:"point",placeholder:e._f("t")("point")},model:{value:e.api.user.point,callback:function(t){e.$set(e.api.user,"point",t)},expression:"api.user.point"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"email"}},[e._v(e._s(e._f("t")("email")))]),a("b-form-input",{attrs:{disabled:"",id:"email",placeholder:e._f("t")("email")},model:{value:e.api.user.email,callback:function(t){e.$set(e.api.user,"email",t)},expression:"api.user.email"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"displayName"}},[e._v(e._s(e._f("t")("display_name")))]),a("b-form-input",{attrs:{disabled:"",id:"displayName",placeholder:e._f("t")("display_name")},model:{value:e.api.user.displayName,callback:function(t){e.$set(e.api.user,"displayName",t)},expression:"api.user.displayName"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"name"}},[e._v(e._s(e._f("t")("name")))]),a("b-form-input",{attrs:{id:"name",placeholder:e._f("t")("name")},model:{value:e.api.user.name,callback:function(t){e.$set(e.api.user,"name",t)},expression:"api.user.name"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"nickname"}},[e._v(e._s(e._f("t")("nickname")))]),a("b-form-input",{attrs:{id:"nickname",placeholder:e._f("t")("nickname")},model:{value:e.api.user.nickname,callback:function(t){e.$set(e.api.user,"nickname",t)},expression:"api.user.nickname"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"phoneNo"}},[e._v(e._s(e._f("t")("phone_number")))]),a("b-form-input",{attrs:{id:"phoneNo",placeholder:e._f("t")("phone_number")},model:{value:e.api.user.phoneNo,callback:function(t){e.$set(e.api.user,"phoneNo",t)},expression:"api.user.phoneNo"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"gender"}},[e._v(e._s(e._f("t")("gender")))]),a("select",{staticClass:"custom-select",attrs:{id:"gender",name:"gender"}},[a("option",{attrs:{value:""}},[e._v(e._s(e._f("t")("select_gender")))]),a("option",{attrs:{value:"M"}},[e._v(e._s(e._f("t")("male")))]),a("option",{attrs:{value:"F"}},[e._v(e._s(e._f("t")("female")))])])]),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"birthdate"}},[e._v(e._s(e._f("t")("birthdate")))]),a("b-form-input",{attrs:{placeholder:"YYMMDD",id:"birthdate"},model:{value:e.api.user.birthdate,callback:function(t){e.$set(e.api.user,"birthdate",t)},expression:"api.user.birthdate"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"countryCode"}},[e._v(e._s(e._f("t")("country_code")))]),a("b-form-input",{attrs:{placeholder:e._f("t")("country_code"),id:"countryCode"},model:{value:e.api.user.countryCode,callback:function(t){e.$set(e.api.user,"countryCode",t)},expression:"api.user.countryCode"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"province"}},[e._v(e._s(e._f("t")("province")))]),a("b-form-input",{attrs:{placeholder:e._f("t")("province"),id:"province"},model:{value:e.api.user.province,callback:function(t){e.$set(e.api.user,"province",t)},expression:"api.user.province"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"city"}},[e._v(e._s(e._f("t")("city")))]),a("b-form-input",{attrs:{placeholder:e._f("t")("city"),id:"city"},model:{value:e.api.user.city,callback:function(t){e.$set(e.api.user,"city",t)},expression:"api.user.city"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"address"}},[e._v(e._s(e._f("t")("address")))]),a("b-form-input",{attrs:{placeholder:e._f("t")("address"),id:"address"},model:{value:e.api.user.address,callback:function(t){e.$set(e.api.user,"address",t)},expression:"api.user.address"}})],1),a("div",{attrs:{role:"group"}},[a("label",{attrs:{for:"zipcode"}},[e._v(e._s(e._f("t")("zipcode")))]),a("b-form-input",{attrs:{placeholder:e._f("t")("zipcode"),id:"zipcode"},model:{value:e.api.user.zipcode,callback:function(t){e.$set(e.api.user,"zipcode",t)},expression:"api.user.zipcode"}})],1),a("div",{staticClass:"mt-2"},[a("button",{staticClass:"btn btn-primary col-3",attrs:{type:"submit"}},[e._v(" "+e._s(e._f("t")("save"))+" ")])])]),a("login-first")],1):e._e()},i=[],s=(a("d3b7"),a("b0c0"),a("9ab4")),o=a("2b0e"),n=a("2fe1"),l=a("6674"),p=a("9f3a"),u=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return t.api=p["a"].instance,t}return Object(s["c"])(t,e),t.prototype.onSubmit=function(){return Object(s["a"])(this,void 0,Promise,(function(){var e,t;return Object(s["d"])(this,(function(a){switch(a.label){case 0:e={idx:this.api.user.idx,point:this.api.user.point,email:this.api.user.email,firebaseUid:this.api.user.firebaseUid,name:this.api.user.name,nickname:this.api.user.nickname,phoneNo:this.api.user.phoneNo,gender:this.api.user.gender,birthdate:this.api.user.birthdate,countryCode:this.api.user.countryCode,province:this.api.user.province,city:this.api.user.city,address:this.api.user.address,zipcode:this.api.user.zipcode},a.label=1;case 1:return a.trys.push([1,3,,4]),[4,this.api.profileUpdate(e)];case 2:return a.sent(),this.api.alert("User Update","Update Success"),[3,4];case 3:return t=a.sent(),this.api.error(t),[3,4];case 4:return[2]}}))}))},t=Object(s["b"])([Object(n["b"])({components:{LoginFirst:l["a"]}})],t),t}(o["default"]),c=u,d=c,f=a("2877"),b=Object(f["a"])(d,r,i,!1,null,null,null);t["default"]=b.exports},6674:function(e,t,a){"use strict";var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return e.api.notLoggedIn?a("div",{staticClass:"p-2 text-center rounded bg-secondary"},[a("h3",[e._v("Login First")])]):e._e()},i=[],s=a("9ab4"),o=a("9f3a"),n=a("2b0e"),l=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return t.api=o["a"].instance,t}return Object(s["c"])(t,e),t}(n["default"]),p=l,u=p,c=a("2877"),d=Object(c["a"])(u,r,i,!1,null,null,null);t["a"]=d.exports}}]);
//# sourceMappingURL=chunk-ece3fdaa.e92bb76e.js.map