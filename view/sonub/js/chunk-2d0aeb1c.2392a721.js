(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0aeb1c"],{"0ac8":function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("h1",[t._v("My Chats")]),n("div",[t._v("Input user Idx or email to begin chat.")]),n("input",{directives:[{name:"model",rawName:"v-model",value:t.idxOrEmail,expression:"idxOrEmail"}],staticClass:"mb-2",domProps:{value:t.idxOrEmail},on:{input:function(e){e.target.composing||(t.idxOrEmail=e.target.value)}}}),n("div",[n("button",{staticClass:"btn btn-sm btn-primary mr-3",on:{click:function(e){return e.preventDefault(),t.onBeginChat.apply(null,arguments)}}},[t._v("Begin chat")]),n("button",{staticClass:"btn btn-sm btn-secondary",on:{click:function(e){return e.preventDefault(),t.onSameRoomChat.apply(null,arguments)}}},[t._v("Same Room chat")])]),n("hr"),n("h1",[t._v("Chat Room list")]),n("ChatRoomList"),n("hr")],1)},i=[],r=(n("d3b7"),n("9ab4")),o=n("2b0e"),a=n("1b40"),c=n("0dc0"),u=n("9f3a"),l=n("d68b"),h=n("e982"),p=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",t._l(t.chat.userRoomList.rooms,(function(e){return n("div",{key:e.id},[n("router-link",{attrs:{to:{path:"chat-message",query:{id:e.id}}}},[t._v(t._s(e.id))])],1)})),0)},b=[],m=n("0298"),d=n("a6e8"),f=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.chat=c["a"].instance,e.chatUserRoomListSubscription=new d["a"],e}return Object(r["c"])(e,t),e.prototype.mounted=function(){console.log("Subscribe ChatRoomList subscription"),this.chatUserRoomListSubscription=m["a"].instance.changes.subscribe((function(t){console.log("ChatRoomList:: changed",t)}))},e.prototype.destroyed=function(){console.log("Destroy ChatRoomList subscription"),this.chatUserRoomListSubscription.unsubscribe()},e=Object(r["b"])([Object(a["a"])({})],e),e}(a["c"]),v=f,O=v,g=n("2877"),y=Object(g["a"])(O,p,b,!1,null,null,null),x=y.exports,C=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=l["a"].instance,e.chat=c["a"].instance,e.idxOrEmail="",e}return Object(r["c"])(e,t),e.prototype.mounted=function(){console.log("chat; ",this.chat)},e.prototype.onBeginChat=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t,e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:console.log("idxOrEmail; ",this.idxOrEmail),n.label=1;case 1:return n.trys.push([1,3,,4]),[4,u["a"].instance.otherUserProfile(this.idxOrEmail)];case 2:return t=n.sent(),console.log("user; ",t),h["a"].instance.enter({users:[t.firebaseUid]}),this.$router.push({path:"chat-message",query:{users:t.firebaseUid}}),[3,4];case 3:return e=n.sent(),this.app.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.onSameRoomChat=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t,e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:console.log("idxOrEmail; ",this.idxOrEmail),n.label=1;case 1:return n.trys.push([1,3,,4]),[4,u["a"].instance.otherUserProfile(this.idxOrEmail)];case 2:return t=n.sent(),console.log("user; ",t),this.$router.push({path:"chat-message",query:{users:t.firebaseUid,hatch:"false"}}),[3,4];case 3:return e=n.sent(),this.app.error(e),[3,4];case 4:return[2]}}))}))},e=Object(r["b"])([Object(a["a"])({components:{ChatRoomList:x}})],e),e}(o["default"]),E=C,R=E,j=Object(g["a"])(R,s,i,!1,null,null,null);e["default"]=j.exports}}]);
//# sourceMappingURL=chunk-2d0aeb1c.2392a721.js.map