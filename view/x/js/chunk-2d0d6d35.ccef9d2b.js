(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0d6d35"],{"73cf":function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{attrs:{"data-cy":"register-form"}},[r("h1",[t._v("User Register")]),r("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[r("div",{staticClass:"form-group"},[t._v(" Email "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.email,expression:"form.email"}],attrs:{type:"text",name:"email"},domProps:{value:t.form.email},on:{input:function(e){e.target.composing||t.$set(t.form,"email",e.target.value)}}})]),r("div",{staticClass:"form-group"},[t._v(" Password "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password,expression:"form.password"}],attrs:{type:"password",name:"password"},domProps:{value:t.form.password},on:{input:function(e){e.target.composing||t.$set(t.form,"password",e.target.value)}}})]),r("div",{staticClass:"form-group"},[t._v(" Name "),r("input",{directives:[{name:"model",rawName:"v-model",value:t.form.name,expression:"form.name"}],attrs:{type:"text",name:"name"},domProps:{value:t.form.name},on:{input:function(e){e.target.composing||t.$set(t.form,"name",e.target.value)}}})]),r("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])])])},n=[],s=(r("d3b7"),r("9ab4")),o=r("2b0e"),i=r("2fe1"),u=r("d68b"),m=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=u["a"].instance,e.form={},e}return Object(s["c"])(e,t),e.prototype.onSubmit=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t;return Object(s["d"])(this,(function(e){switch(e.label){case 0:return e.trys.push([0,2,,3]),[4,this.app.api.register(this.form)];case 1:return e.sent(),this.$router.push("/").catch((function(){return null})),[3,3];case 2:return t=e.sent(),this.app.error(t),[3,3];case 3:return[2]}}))}))},e=Object(s["b"])([Object(i["a"])({})],e),e}(o["a"]),p=m,c=p,l=r("2877"),f=Object(l["a"])(c,a,n,!1,null,null,null);e["default"]=f.exports}}]);
//# sourceMappingURL=chunk-2d0d6d35.ccef9d2b.js.map