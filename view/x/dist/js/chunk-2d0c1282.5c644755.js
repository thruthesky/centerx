(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c1282"],{"459d":function(t,e,n){"use strict";n.r(e);var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("h1",[t._v("Admin")]),n("div",[n("b-card",{attrs:{"no-body":""}},[n("b-tabs",{attrs:{pills:"",card:""}},[n("b-tab",{attrs:{title:"User",active:""}},[n("admin-user-list")],1),n("b-tab",{attrs:{title:"Category"}},[n("admin-category-list")],1),n("b-tab",{attrs:{title:"Posts"}},[n("admin-post-list")],1),n("b-tab",{attrs:{title:"Files"}},[n("admin-file-list")],1)],1)],1)],1)])},s=[],i=n("9ab4"),l=n("2b0e"),u=n("2fe1"),c=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("h4",[t._v("Users")]),t.users?n("div",t._l(t.users,(function(e){return n("div",{key:e.idx},[t._v(" "+t._s(e.idx)+" ")])})),0):t._e()])},a=[],o=n("d68b"),b=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=o["a"].instance,e.users=[],e}return Object(i["c"])(e,t),e.prototype.mounted=function(){return Object(i["a"])(this,void 0,void 0,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),t=this,[4,this.app.api.userList({})];case 1:return t.users=n.sent(),console.log(this.users),[3,3];case 2:return e=n.sent(),this.app.error(e),[3,3];case 3:return[2]}}))}))},e=Object(i["b"])([Object(u["a"])({})],e),e}(l["a"]),p=b,h=p,d=n("2877"),f=Object(d["a"])(h,c,a,!1,null,null,null),j=f.exports,v=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("h4",[t._v("Category list")])},O=[],_=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),e=Object(i["b"])([Object(u["a"])({})],e),e}(l["a"]),m=_,y=m,w=Object(d["a"])(y,v,O,!1,null,null,null),x=w.exports,g=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("h4",[t._v("Post list")])},A=[],E=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),e=Object(i["b"])([Object(u["a"])({})],e),e}(l["a"]),L=E,$=L,k=Object(d["a"])($,g,A,!1,null,null,null),C=k.exports,F=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("h4",[t._v("File list")])},P=[],U=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),e=Object(i["b"])([Object(u["a"])({})],e),e}(l["a"]),J=U,q=J,z=Object(d["a"])(q,F,P,!1,null,null,null),B=z.exports,D=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(i["c"])(e,t),e=Object(i["b"])([Object(u["a"])({components:{AdminUserList:j,AdminCategoryList:x,AdminPostList:C,AdminFileList:B}})],e),e}(l["a"]),G=D,H=G,I=Object(d["a"])(H,r,s,!1,null,null,null);e["default"]=I.exports}}]);
//# sourceMappingURL=chunk-2d0c1282.5c644755.js.map