(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0e585f"],{"959f":function(t,s,e){"use strict";e.r(s);var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("section",{staticClass:"box"},[0==t.loaded?e("div",{staticClass:"p-3 text-center rounded"},[e("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" "+t._s(t._f("t")("loading_profile"))+" ")],1):e("div",{staticClass:"p-3"},[0==t.user.verified?e("div",{staticClass:"mb-5 fs-sm"},[e("div",[t._v("본인인증을 하지 않은 사용자입니다.")])]):e("div",{staticClass:"fs-xs"},[t._v("본인 인증을 한 사용자입니다.")]),e("div",{staticClass:"d-flex justify-content-center mt-4"},[e("UserAvatar",{attrs:{user:t.user}})],1),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-5 fs-xs",attrs:{for:"point"}},[t._v(t._s(t._f("t")("point")))]),e("div",[t._v(t._s(t.app.numberWithCommas(t.user.point)))])]),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-4 fs-xs",attrs:{for:"name"}},[t._v(t._s(t._f("t")("name")))]),e("div",{staticClass:"fs-md"},[t._v(t._s(t.user.name||"?"))])]),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-4 fs-xs",attrs:{for:"phoneNo"}},[t._v(t._s(t._f("t")("phone_number")))]),e("div",[t._v(t._s(t.user.phoneNo||"?"))])]),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-4 fs-xs",attrs:{for:"gender"}},[t._v(t._s(t._f("t")("gender")))]),e("div",[t._v(t._s(t._f("t")(t.user.gender||"?")))])]),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-4 fs-xs",attrs:{for:"birthdate"}},[t._v(t._s(t._f("t")("birthdate")))]),e("div",[t._v(t._s(t.user.birthdate||"?"))])]),e("div",{attrs:{role:"group"}},[e("label",{staticClass:"mt-4 fs-xs",attrs:{for:"nickname"}},[t._v(t._s(t._f("t")("nickname")))]),e("div",{staticClass:"bold"},[t._v(t._s(t.user.nickname))]),e("small",[t._v("닉네임은 변경 할 수 없습니다.")])]),e("small",{staticClass:"d-block mt-5 grey"},[t._v("본인 인증을 통해서 이름, 성별, 생년월일 등은 자동으로 지정되며, 변경 할 수 없습니다.")]),e("small",{staticClass:"d-block grey"},[t._v("본인 인증을 하지 않으면, 홈페이지 이용에 제한이 있을 수 있습니다.")])])])},r=[],i=(e("d3b7"),e("9ab4")),n=e("2b0e"),l=e("2fe1"),o=e("9f3a"),c=e("d68b"),d=e("5803"),u=function(t){function s(){var s=null!==t&&t.apply(this,arguments)||this;return s.app=c["a"].instance,s.api=o["a"].instance,s.loaded=!1,s}return Object(i["c"])(s,t),s.prototype.mounted=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,s;return Object(i["d"])(this,(function(e){switch(e.label){case 0:return e.trys.push([0,2,,3]),t=this,[4,this.api.otherUserProfile(this.$route.params.idx)];case 1:return t.user=e.sent(),console.log("this.user; ",this.user),this.loaded=!0,[3,3];case 2:return s=e.sent(),this.app.error(s),[3,3];case 3:return[2]}}))}))},s=Object(i["b"])([Object(l["b"])({components:{UserAvatar:d["a"]}})],s),s}(n["default"]),v=u,f=v,_=e("2877"),p=Object(_["a"])(f,a,r,!1,null,null,null);s["default"]=p.exports}}]);
//# sourceMappingURL=chunk-2d0e585f.b41c5bcd.js.map