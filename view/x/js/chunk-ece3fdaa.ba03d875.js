(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-ece3fdaa"],{"4cb2":function(e,t,r){"use strict";r.r(t);var s=function(){var e=this,t=e.$createElement,r=e._self._c||t;return e.user.loggedIn?r("section",{staticClass:"box"},[r("div",{staticClass:"d-flex justify-content-center"},[r("b-avatar",{attrs:{src:e.user.photuUrl,size:"8rem"}})],1),r("form",{on:{submit:function(t){return t.preventDefault(),e.onSubmit(t)}}},[r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"point"}},[e._v(e._s(e._f("t")("point")))]),r("b-form-input",{attrs:{disabled:"",id:"point",placeholder:e._f("t")("point")},model:{value:e.user.point,callback:function(t){e.$set(e.user,"point",t)},expression:"user.point"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"email"}},[e._v(e._s(e._f("t")("email")))]),r("b-form-input",{attrs:{disabled:"",id:"email",placeholder:e._f("t")("email")},model:{value:e.user.email,callback:function(t){e.$set(e.user,"email",t)},expression:"user.email"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"displayName"}},[e._v(e._s(e._f("t")("display_name")))]),r("b-form-input",{attrs:{disabled:"",id:"displayName",placeholder:e._f("t")("display_name")},model:{value:e.user.displayName,callback:function(t){e.$set(e.user,"displayName",t)},expression:"user.displayName"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"name"}},[e._v(e._s(e._f("t")("name")))]),r("b-form-input",{attrs:{id:"name",placeholder:e._f("t")("name")},model:{value:e.user.name,callback:function(t){e.$set(e.user,"name",t)},expression:"user.name"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"nickname"}},[e._v(e._s(e._f("t")("nickname")))]),r("b-form-input",{attrs:{id:"nickname",placeholder:e._f("t")("nickname")},model:{value:e.user.nickname,callback:function(t){e.$set(e.user,"nickname",t)},expression:"user.nickname"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"phoneNo"}},[e._v(e._s(e._f("t")("phone_number")))]),r("b-form-input",{attrs:{id:"phoneNo",placeholder:e._f("t")("phone_number")},model:{value:e.user.phoneNo,callback:function(t){e.$set(e.user,"phoneNo",t)},expression:"user.phoneNo"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"gender"}},[e._v(e._s(e._f("t")("gender")))]),r("select",{directives:[{name:"model",rawName:"v-model",value:e.user.gender,expression:"user.gender"}],staticClass:"custom-select",attrs:{id:"gender",name:"gender"},on:{change:function(t){var r=Array.prototype.filter.call(t.target.options,(function(e){return e.selected})).map((function(e){var t="_value"in e?e._value:e.value;return t}));e.$set(e.user,"gender",t.target.multiple?r:r[0])}}},[r("option",{attrs:{value:""}},[e._v(e._s(e._f("t")("select_gender")))]),r("option",{attrs:{value:"M"}},[e._v(e._s(e._f("t")("male")))]),r("option",{attrs:{value:"F"}},[e._v(e._s(e._f("t")("female")))])])]),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"birthdate"}},[e._v(e._s(e._f("t")("birthdate")))]),r("b-form-input",{attrs:{placeholder:"YYMMDD",id:"birthdate"},model:{value:e.user.birthdate,callback:function(t){e.$set(e.user,"birthdate",t)},expression:"user.birthdate"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"countryCode"}},[e._v(e._s(e._f("t")("country_code")))]),r("b-form-input",{attrs:{placeholder:e._f("t")("country_code"),id:"countryCode"},model:{value:e.user.countryCode,callback:function(t){e.$set(e.user,"countryCode",t)},expression:"user.countryCode"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"province"}},[e._v(e._s(e._f("t")("province")))]),r("b-form-input",{attrs:{placeholder:e._f("t")("province"),id:"province"},model:{value:e.user.province,callback:function(t){e.$set(e.user,"province",t)},expression:"user.province"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"city"}},[e._v(e._s(e._f("t")("city")))]),r("b-form-input",{attrs:{placeholder:e._f("t")("city"),id:"city"},model:{value:e.user.city,callback:function(t){e.$set(e.user,"city",t)},expression:"user.city"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"address"}},[e._v(e._s(e._f("t")("address")))]),r("b-form-input",{attrs:{placeholder:e._f("t")("address"),id:"address"},model:{value:e.user.address,callback:function(t){e.$set(e.user,"address",t)},expression:"user.address"}})],1),r("div",{attrs:{role:"group"}},[r("label",{attrs:{for:"zipcode"}},[e._v(e._s(e._f("t")("zipcode")))]),r("b-form-input",{attrs:{placeholder:e._f("t")("zipcode"),id:"zipcode"},model:{value:e.user.zipcode,callback:function(t){e.$set(e.user,"zipcode",t)},expression:"user.zipcode"}})],1),r("div",{staticClass:"mt-2"},[r("button",{staticClass:"btn btn-primary col-3",attrs:{type:"submit"}},[e._v(" "+e._s(e._f("t")("save"))+" ")])])]),r("login-first")],1):e._e()},a=[],i=(r("d3b7"),r("b0c0"),r("9ab4")),n=r("2b0e"),o=r("2fe1"),l=r("6674"),u=r("9f3a"),c=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return t.user={},t}return Object(i["c"])(t,e),t.prototype.mounted=function(){return Object(i["a"])(this,void 0,Promise,(function(){var e,t;return Object(i["d"])(this,(function(r){switch(r.label){case 0:return r.trys.push([0,2,,3]),e=this,[4,u["a"].instance.userProfile()];case 1:return e.user=r.sent(),[3,3];case 2:return t=r.sent(),this.$emit("error",t),[3,3];case 3:return[2]}}))}))},t.prototype.onSubmit=function(e){var t={idx:this.user.idx,email:this.user.email,firebaseUid:this.user.firebaseUid,name:this.user.name,nickname:this.user.nickname,phoneNo:this.user.phoneNo,gender:this.user.gender,birthdate:this.user.birthdate,countryCode:this.user.countryCode,province:this.user.province,city:this.user.city,address:this.user.address,zipcode:this.user.zipcode};this.$emit("submit",e,t)},t=Object(i["b"])([Object(o["b"])({components:{LoginFirst:l["a"]}})],t),t}(n["default"]),d=c,p=d,f=r("2877"),m=Object(f["a"])(p,s,a,!1,null,null,null);t["default"]=m.exports},6674:function(e,t,r){"use strict";var s=function(){var e=this,t=e.$createElement,r=e._self._c||t;return e.api._user.notLoggedIn?r("div",{staticClass:"p-2 text-center rounded bg-secondary"},[r("h3",[e._v("Login First")])]):e._e()},a=[],i=r("9ab4"),n=r("9f3a"),o=r("2b0e"),l=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return t.api=n["a"].instance,t}return Object(i["c"])(t,e),t}(o["default"]),u=l,c=u,d=r("2877"),p=Object(d["a"])(c,s,a,!1,null,null,null);t["a"]=p.exports}}]);
//# sourceMappingURL=chunk-ece3fdaa.ba03d875.js.map