(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-241b90b0"],{a55b:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("h1",[t._v("User Login")]),n("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[n("div",{staticClass:"form-group"},[t._v(" Email "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.email,expression:"form.email"}],attrs:{type:"text",name:"email"},domProps:{value:t.form.email},on:{input:function(e){e.target.composing||t.$set(t.form,"email",e.target.value)}}})]),n("div",{staticClass:"form-group"},[t._v(" Password "),n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password,expression:"form.password"}],attrs:{type:"password",name:"password"},domProps:{value:t.form.password},on:{input:function(e){e.target.composing||t.$set(t.form,"password",e.target.value)}}})]),n("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])]),n("img",{staticClass:"w-100",attrs:{src:a("b8f0")},on:{click:function(e){return t.loginWithKakao()}}}),n("script",{attrs:{type:"application/javascript",defer:"",src:"/js/kakao.min.js"}})])},r=[],i=a("1da1"),o=a("d4ec"),s=a("bee2"),c=a("262e"),u=a("2caf"),p=(a("96cf"),a("9ab4")),l=a("2b0e"),f=a("2fe1"),m=a("d68b"),b=function(t){Object(c["a"])(a,t);var e=Object(u["a"])(a);function a(){var t;return Object(o["a"])(this,a),t=e.apply(this,arguments),t.form={},t.app=m["a"].instance,t.init=!1,t}return Object(s["a"])(a,[{key:"onSubmit",value:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,this.app.api.login(this.form);case 3:t.sent,this.$router.push("/").catch((function(t){return null})),t.next=10;break;case 7:t.prev=7,t.t0=t["catch"](0),this.app.error(t.t0);case 10:case"end":return t.stop()}}),t,this,[[0,7]])})));function e(){return t.apply(this,arguments)}return e}()},{key:"loginWithKakao",value:function(){!1===this.init&&(window.Kakao.init("937af10cf8688bd9a7554cf088b2ac3e"),this.init=!0),window.Kakao.Auth.login({success:function(t){alert(JSON.stringify(t))},fail:function(t){alert(JSON.stringify(t))}})}}]),a}(l["a"]);b=Object(p["a"])([Object(f["a"])({})],b);var d=b,v=d,w=a("2877"),g=Object(w["a"])(v,n,r,!1,null,null,null);e["default"]=g.exports},b8f0:function(t,e,a){t.exports=a.p+"img/kakao_login_large_wide.b2df8abc.png"}}]);
//# sourceMappingURL=chunk-241b90b0.6939006a.js.map