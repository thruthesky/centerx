(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c22ca"],{"48d4":function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",{staticClass:"post-edit-page"},[t.app.loggedIn?n("div",[t.form.categoryId?n("div",[t._v(" Category: "),n("span",{staticClass:"text-uppercase"},[t._v(" "+t._s(t.form.categoryId)+" ")])]):t._e(),n("form",{staticClass:"mt-3",on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[t._v(" Title "),n("div",{staticClass:"form-group"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.title,expression:"form.title"}],staticClass:"w-100",attrs:{type:"text",name:"title"},domProps:{value:t.form.title},on:{input:function(e){e.target.composing||t.$set(t.form,"title",e.target.value)}}})]),t._v(" Content "),n("div",{staticClass:"form-group"},[n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.content,expression:"form.content"}],staticClass:"w-100",attrs:{type:"text",name:"content"},domProps:{value:t.form.content},on:{input:function(e){e.target.composing||t.$set(t.form,"content",e.target.value)}}})]),n("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])])]):t._e(),t.app.notLoggedIn?n("div",{staticClass:"p-2 text-center rounded bg-secondary"},[n("h3",[t._v("Login First")])]):t._e()])},r=[],o=n("1da1"),i=n("d4ec"),s=n("bee2"),c=n("262e"),u=n("2caf"),p=(n("96cf"),n("9ab4")),l=n("2b0e"),m=n("2fe1"),f=n("d68b"),d=n("aeda"),v=function(t){Object(c["a"])(n,t);var e=Object(u["a"])(n);function n(){var t;return Object(i["a"])(this,n),t=e.apply(this,arguments),t.form=new d["c"],t.app=f["a"].instance,t}return Object(s["a"])(n,[{key:"loadPost",value:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.app.api.postGet({idx:this.form.idx});case 2:e=t.sent,this.form.idx=e.idx,this.form.title=e.title,this.form.content=e.content;case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},{key:"mounted",value:function(){var t=this.$route.params.idOrCategory;isNaN(parseInt(t))?this.form.categoryId=t:(this.form.idx=t,this.loadPost())}},{key:"onSubmit",value:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,this.app.api.postEdit(this.form);case 3:e=t.sent,this.$router.push("/".concat(e.path)).catch((function(){return null})),t.next=10;break;case 7:t.prev=7,t.t0=t["catch"](0),this.app.error(t.t0);case 10:case"end":return t.stop()}}),t,this,[[0,7]])})));function e(){return t.apply(this,arguments)}return e}()}]),n}(l["a"]);v=Object(p["a"])([Object(m["a"])({})],v);var h=v,b=h,g=n("2877"),x=Object(g["a"])(b,a,r,!1,null,null,null);e["default"]=x.exports}}]);
//# sourceMappingURL=chunk-2d0c22ca.cbb8eef4.js.map