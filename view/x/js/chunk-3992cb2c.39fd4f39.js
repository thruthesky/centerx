(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-3992cb2c"],{"6d4a":function(t,e,r){"use strict";var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("svg",{staticStyle:{"enable-background":"new 0 0 512 512"},attrs:{version:"1.1",id:"Layer_1",xmlns:"http://www.w3.org/2000/svg","xmlns:xlink":"http://www.w3.org/1999/xlink",x:"0px",y:"0px",viewBox:"0 0 512 512","xml:space":"preserve"}},[r("path",{staticStyle:{fill:"#fbbb00"},attrs:{d:"M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256\n\tc0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456\n\tC103.821,274.792,107.225,292.797,113.47,309.408z"}}),r("path",{staticStyle:{fill:"#518ef8"},attrs:{d:"M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451\n\tc-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535\n\tc29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"}}),r("path",{staticStyle:{fill:"#28b446"},attrs:{d:"M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512\n\tc-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771\n\tc28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"}}),r("path",{staticStyle:{fill:"#f14336"},attrs:{d:"M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012\n\tc-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0\n\tC318.115,0,375.068,22.126,419.404,58.936z"}}),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g"),r("g")])},s=[],n=r("2877"),o={},i=Object(n["a"])(o,a,s,!1,null,null,null);e["a"]=i.exports},"78c1":function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("h1",{staticClass:"mt-5 pt-5"},[t._v("User Login")]),r("form",{on:{submit:function(e){return e.preventDefault(),t.onLogin.apply(null,arguments)}}},[r("div",{staticClass:"form-group"},[t._v(" Email "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.email,expression:"form.email"}],attrs:{type:"text",name:"email"},domProps:{value:t.form.email},on:{input:function(e){e.target.composing||t.$set(t.form,"email",e.target.value)}}})]),r("div",{staticClass:"form-group"},[t._v(" Password "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password,expression:"form.password"}],attrs:{type:"password",name:"password"},domProps:{value:t.form.password},on:{input:function(e){e.target.composing||t.$set(t.form,"password",e.target.value)}}})]),r("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])]),r("Register",{on:{submit:t.onRegister}})],1)},s=[],n=(r("d3b7"),r("9ab4")),o=r("9f3a"),i=r("7bc8"),l=r("6d4a"),c=r("edb9"),u=r("2b0e"),m=r("2fe1"),p=r("d68b"),f=r("c23d"),b=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=p["a"].instance,e.api=o["a"].instance,e.form={},e.initKakao=!1,e}return Object(n["c"])(e,t),e.prototype.onLogin=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t;return Object(n["d"])(this,(function(e){switch(e.label){case 0:console.log("Login::form",this.form),e.label=1;case 1:return e.trys.push([1,4,,5]),[4,this.app.login(this.form)];case 2:return e.sent(),[4,p["a"].instance.loginOrRegisterIntoFirebase()];case 3:return e.sent(),[3,5];case 4:return t=e.sent(),console.log(t),this.app.error(t),[3,5];case 5:return[2]}}))}))},e.prototype.onRegister=function(t,e){return Object(n["a"])(this,void 0,Promise,(function(){var t;return Object(n["d"])(this,(function(r){switch(r.label){case 0:return r.trys.push([0,3,,4]),[4,o["a"].instance.register(e)];case 1:return r.sent(),[4,p["a"].instance.loginOrRegisterIntoFirebase()];case 2:return r.sent(),this.$router.push("/"),[3,4];case 3:return t=r.sent(),this.$app.error(t),[3,4];case 4:return[2]}}))}))},e=Object(n["b"])([Object(m["b"])({components:{ChatBubbleSvg:i["a"],GoogleLogoSvg:l["a"],FacebookLogoSvg:c["a"],Register:f["a"]}})],e),e}(u["default"]),d=b,g=d,v=r("2877"),h=Object(v["a"])(g,a,s,!1,null,null,null);e["default"]=h.exports},"7bc8":function(t,e,r){"use strict";var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("svg",{attrs:{id:"Capa_1","enable-background":"new 0 0 465.882 465.882",height:"512",viewBox:"0 0 465.882 465.882",width:"512",xmlns:"http://www.w3.org/2000/svg"}},[r("path",{attrs:{d:"m232.941 0c-128.649 0-232.941 104.292-232.941 232.941 0 36.34 8.563 70.601 23.404 101.253l-23.404 131.688 131.689-23.404c30.651 14.841 64.912 23.404 101.253 23.404 128.65 0 232.941-104.292 232.941-232.941s-104.292-232.941-232.942-232.941z"}})])},s=[],n=r("2877"),o={},i=Object(n["a"])(o,a,s,!1,null,null,null);e["a"]=i.exports},c23d:function(t,e,r){"use strict";var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{attrs:{"data-cy":"register-form"}},[r("h1",[t._v(t._s(t._f("t")("user_register")))]),r("form",{on:{submit:function(e){return e.preventDefault(),t.$emit("submit",e,t.form)}}},[r("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("email"),"label-for":"email"}},[r("b-form-input",{attrs:{id:"email",type:"email",placeholder:t._f("t")("enter_email"),required:""},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}})],1),r("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("password"),"label-for":"password"}},[r("b-form-input",{attrs:{id:"password",type:"password",placeholder:t._f("t")("enter_password"),required:""},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}})],1),r("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("name"),"label-for":"name"}},[r("b-form-input",{attrs:{id:"name",type:"text",placeholder:t._f("t")("enter_name"),required:""},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),r("button",{staticClass:"btn btn-primary px-5",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])],1)])},s=[],n=r("9ab4"),o=r("2b0e"),i=r("2fe1"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form={},e}return Object(n["c"])(e,t),e=Object(n["b"])([Object(i["b"])({})],e),e}(o["default"]),c=l,u=c,m=r("2877"),p=Object(m["a"])(u,a,s,!1,null,null,null);e["a"]=p.exports},edb9:function(t,e,r){"use strict";var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("svg",{attrs:{"enable-background":"new 0 0 24 24",height:"512",viewBox:"0 0 24 24",width:"512",xmlns:"http://www.w3.org/2000/svg"}},[r("path",{attrs:{d:"m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-6.932 0-5.046 7.85-5.322 9h-3.487v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877c.188-2.824-.761-5.016 2.051-5.016z",fill:"#3b5999"}})])},s=[],n=r("2877"),o={},i=Object(n["a"])(o,a,s,!1,null,null,null);e["a"]=i.exports}}]);
//# sourceMappingURL=chunk-3992cb2c.39fd4f39.js.map