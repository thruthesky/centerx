(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-ad3f4302","chunk-28634792"],{"0a58":function(t,e,a){"use strict";a("c47a")},"73cf":function(t,e,a){"use strict";a.r(e);var r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{},[a("Login"),a("register",{on:{submit:t.onSubmit}})],1)},n=[],o=(a("d3b7"),a("9ab4")),s=a("2b0e"),i=a("2fe1"),l=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{"data-cy":"register-form"}},[a("h1",[t._v(t._s(t._f("t")("user_register")))]),a("form",{on:{submit:function(e){return e.preventDefault(),t.$emit("submit",e,t.form)}}},[a("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("email"),"label-for":"email"}},[a("b-form-input",{attrs:{id:"email",type:"email",placeholder:t._f("t")("enter_email"),required:""},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}})],1),a("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("password"),"label-for":"password"}},[a("b-form-input",{attrs:{id:"password",type:"password",placeholder:t._f("t")("enter_password"),required:""},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}})],1),a("b-form-group",{staticClass:"mb-2",attrs:{label:t._f("t")("name"),"label-for":"name"}},[a("b-form-input",{attrs:{id:"name",type:"text",placeholder:t._f("t")("enter_name"),required:""},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),a("button",{staticClass:"btn btn-primary px-5",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])],1)])},c=[],u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form={},e}return Object(o["c"])(e,t),e=Object(o["b"])([Object(i["b"])({})],e),e}(s["default"]),p=u,f=p,m=a("2877"),b=Object(m["a"])(f,l,c,!1,null,null,null),d=b.exports,g=a("a55b"),h=a("9f3a"),v=a("d68b"),w=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e.prototype.onSubmit=function(t,e){return Object(o["a"])(this,void 0,Promise,(function(){var t;return Object(o["d"])(this,(function(a){switch(a.label){case 0:return a.trys.push([0,3,,4]),[4,h["a"].instance.register(e)];case 1:return a.sent(),[4,v["a"].instance.loginOrRegisterIntoFirebase()];case 2:return a.sent(),this.$router.push("/"),[3,4];case 3:return t=a.sent(),this.$app.error(t),[3,4];case 4:return[2]}}))}))},e=Object(o["b"])([Object(i["b"])({components:{Register:d,Login:g["default"]}})],e),e}(s["default"]),k=w,_=k,x=Object(m["a"])(_,r,n,!1,null,null,null);e["default"]=x.exports},a55b:function(t,e,a){"use strict";a.r(e);var r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"box p-3",attrs:{"data-cy":"login-form"}},[a("script",{attrs:{type:"application/javascript",defer:"",src:"/js/kakao.min.js"}}),a("h1",[t._v("로그인")]),a("p",[t._v("카카오, 구글 또는 페이스북으로 로그인을 해 주세요.")]),a("div",{staticClass:"p-5"},[a("div",{staticClass:"login-box bg-kakao d-flex align-items-center",on:{click:function(e){return t.loginWithKakao()}}},[a("ChatBubbleSvg"),a("div",{staticClass:"flex-grow-1 text-center"},[t._v("카카오 로그인")])],1),a("div",{staticClass:"login-box mt-2 border d-flex align-items-center",on:{click:function(e){return t.loginWithGoogle()}}},[a("GoogleLogoSvg"),a("div",{staticClass:"flex-grow-1 text-center"},[t._v("구글 로그인")])],1),a("div",{staticClass:"login-box mt-2 bg-facebook white d-flex align-items-center",on:{click:function(e){return t.loginWithFacebook()}}},[a("FacebookLogoSvg",{staticClass:"bg-white pt-2 px-1 round content-box"}),a("div",{staticClass:"flex-grow-1 text-center"},[t._v("페이스북 로그인")])],1)]),a("h1",{staticClass:"mt-5 pt-5"},[t._v("User Login")]),a("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[a("div",{staticClass:"form-group"},[t._v(" Email "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.email,expression:"form.email"}],attrs:{type:"text",name:"email"},domProps:{value:t.form.email},on:{input:function(e){e.target.composing||t.$set(t.form,"email",e.target.value)}}})]),a("div",{staticClass:"form-group"},[t._v(" Password "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password,expression:"form.password"}],attrs:{type:"password",name:"password"},domProps:{value:t.form.password},on:{input:function(e){e.target.composing||t.$set(t.form,"password",e.target.value)}}})]),a("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])])])},n=[],o=(a("d3b7"),a("9ab4")),s=a("c401"),i=a("9f3a"),l=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("svg",{attrs:{id:"Capa_1","enable-background":"new 0 0 465.882 465.882",height:"512",viewBox:"0 0 465.882 465.882",width:"512",xmlns:"http://www.w3.org/2000/svg"}},[a("path",{attrs:{d:"m232.941 0c-128.649 0-232.941 104.292-232.941 232.941 0 36.34 8.563 70.601 23.404 101.253l-23.404 131.688 131.689-23.404c30.651 14.841 64.912 23.404 101.253 23.404 128.65 0 232.941-104.292 232.941-232.941s-104.292-232.941-232.942-232.941z"}})])},c=[],u=a("2877"),p={},f=Object(u["a"])(p,l,c,!1,null,null,null),m=f.exports,b=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("svg",{staticStyle:{"enable-background":"new 0 0 512 512"},attrs:{version:"1.1",id:"Layer_1",xmlns:"http://www.w3.org/2000/svg","xmlns:xlink":"http://www.w3.org/1999/xlink",x:"0px",y:"0px",viewBox:"0 0 512 512","xml:space":"preserve"}},[a("path",{staticStyle:{fill:"#fbbb00"},attrs:{d:"M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256\n\tc0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456\n\tC103.821,274.792,107.225,292.797,113.47,309.408z"}}),a("path",{staticStyle:{fill:"#518ef8"},attrs:{d:"M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451\n\tc-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535\n\tc29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"}}),a("path",{staticStyle:{fill:"#28b446"},attrs:{d:"M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512\n\tc-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771\n\tc28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"}}),a("path",{staticStyle:{fill:"#f14336"},attrs:{d:"M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012\n\tc-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0\n\tC318.115,0,375.068,22.126,419.404,58.936z"}}),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g"),a("g")])},d=[],g={},h=Object(u["a"])(g,b,d,!1,null,null,null),v=h.exports,w=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("svg",{attrs:{"enable-background":"new 0 0 24 24",height:"512",viewBox:"0 0 24 24",width:"512",xmlns:"http://www.w3.org/2000/svg"}},[a("path",{attrs:{d:"m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-6.932 0-5.046 7.85-5.322 9h-3.487v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877c.188-2.824-.761-5.016 2.051-5.016z",fill:"#3b5999"}})])},k=[],_={},x=Object(u["a"])(_,w,k,!1,null,null,null),y=x.exports,O=a("2b0e"),j=a("2fe1"),C=a("260b"),L=(a("ea7b"),a("d68b")),S=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=L["a"].instance,e.api=i["a"].instance,e.form={},e.initKakao=!1,e}return Object(o["c"])(e,t),e.prototype.onSubmit=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t;return Object(o["d"])(this,(function(e){switch(e.label){case 0:console.log("Login::form",this.form),e.label=1;case 1:return e.trys.push([1,4,,5]),[4,this.app.login(this.form)];case 2:return e.sent(),[4,L["a"].instance.loginOrRegisterIntoFirebase()];case 3:return e.sent(),[3,5];case 4:return t=e.sent(),console.log(t),this.app.error(t),[3,5];case 5:return[2]}}))}))},e.prototype.loginWithKakao=function(){var t=this,e=window.Kakao;!1===this.initKakao&&(e.init(s["a"].kakaoJavascriptKey),this.initKakao=!0),e.Auth.login({success:function(a){console.log(a),e.API.request({url:"/v2/user/me",data:{secure_resource:!0},success:function(e){return Object(o["a"])(t,void 0,void 0,(function(){var t,a,r,n,s,i,l,c;return Object(o["d"])(this,(function(o){switch(o.label){case 0:return t={id:e.id,nickname:null!==(s=null===(n=null===(r=e.kakao_account)||void 0===r?void 0:r.profile)||void 0===n?void 0:n.nickname)&&void 0!==s?s:"",photoUrl:null!==(c=null===(l=null===(i=e.kakao_account)||void 0===i?void 0:i.profile)||void 0===l?void 0:l.profile_image_url)&&void 0!==c?c:"",domain:location.hostname},console.log("kakaoLogin request data;",t),[4,this.api.kakaoLogin(t)];case 1:return a=o.sent(),console.log("kakaoLogin response data; ",a),[4,L["a"].instance.loginOrRegisterIntoFirebase()];case 2:return o.sent(),[2]}}))}))},fail:function(t){alert(t)}})},fail:function(t){alert(JSON.stringify(t))}})},e.prototype.loginWithGoogle=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e,a,r,n,s,i;return Object(o["d"])(this,(function(o){switch(o.label){case 0:return o.trys.push([0,5,,6]),t=new C["a"].auth.GoogleAuthProvider,e=C["a"].auth(),e.languageCode="ko",[4,e.signInWithPopup(t)];case 1:return a=o.sent(),a.user?(r=a.user,n={firebaseUid:r.uid,email:r.email,nickname:r.displayName,photoUrl:r.photoURL,domain:location.hostname,provider:"google"},[4,this.api.firebaseLogin(n)]):[3,3];case 2:return s=o.sent(),console.log("backend user",s),[3,4];case 3:this.app.error("error_google_login_user_empty"),o.label=4;case 4:return[3,6];case 5:return i=o.sent(),this.app.error(i.message),[3,6];case 6:return[2]}}))}))},e.prototype.loginWithFacebook=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e,a,r,n,s,i;return Object(o["d"])(this,(function(o){switch(o.label){case 0:return o.trys.push([0,5,,6]),t=new C["a"].auth.FacebookAuthProvider,e=C["a"].auth(),e.languageCode="ko",[4,e.signInWithPopup(t)];case 1:return a=o.sent(),a.user?(r=a.user,n={firebaseUid:r.uid,email:r.email,nickname:r.displayName,photoUrl:r.photoURL,domain:location.hostname,provider:"facebook"},[4,this.api.firebaseLogin(n)]):[3,3];case 2:return s=o.sent(),console.log("backend user",s),[3,4];case 3:this.app.error("error_facebook_login_user_empty"),o.label=4;case 4:return[3,6];case 5:return i=o.sent(),console.log("e;",i),this.app.error(i),[3,6];case 6:return[2]}}))}))},e=Object(o["b"])([Object(j["b"])({components:{ChatBubbleSvg:m,GoogleLogoSvg:v,FacebookLogoSvg:y}})],e),e}(O["default"]),$=S,P=$,F=(a("0a58"),Object(u["a"])(P,r,n,!1,null,"6056ae6e",null));e["default"]=F.exports},c47a:function(t,e,a){}}]);
//# sourceMappingURL=chunk-ad3f4302.cb3dd14f.js.map