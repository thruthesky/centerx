(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0590b908"],{2297:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"pr-2 position-relative overflow-hidden"},[n("img",{style:{width:t.defaultSize+"px",height:t.defaultSize+"px"},attrs:{src:s("872d")}}),n("input",{staticClass:"h-100 top left position-absolute opacity-0",attrs:{type:"file"},on:{change:t.onFileChange}})])},i=[],o=s("9ab4"),r=s("d68b"),a=s("2b0e"),c=s("2fe1"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=35,e.app=r["a"].instance,e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size)},e.prototype.onFileChange=function(t){var e,s;if(this.app.notLoggedIn)this.app.error("error_login_first");else if(null!==t.target.files&&0!==(null===(s=null===(e=t.target)||void 0===e?void 0:e.files)||void 0===s?void 0:s.length)){var n=t.target.files[0];this.app.api.fileUpload(n,{},this.onUploaded,this.app.error,this.onProgress)}},e.prototype.onUploaded=function(t){this.$emit("success",t)},e.prototype.onProgress=function(t){this.$emit("progress",t)},e=Object(o["b"])([Object(c["a"])({props:["parent","size"]})],e),e}(a["a"]),p=l,u=p,m=s("2877"),d=Object(m["a"])(u,n,i,!1,null,null,null);e["a"]=d.exports},"25f0":function(t,e,s){"use strict";var n=s("6eeb"),i=s("825a"),o=s("d039"),r=s("ad6d"),a="toString",c=RegExp.prototype,l=c[a],p=o((function(){return"/a/b"!=l.call({source:"a",flags:"b"})})),u=l.name!=a;(p||u)&&n(RegExp.prototype,a,(function(){var t=i(this),e=String(t.source),s=t.flags,n=String(void 0===s&&t instanceof RegExp&&!("flags"in c)?r.call(t):s);return"/"+e+"/"+n}),{unsafe:!0})},"2c67":function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"post-view-page"},[t.pageNotFound?t._e():s("div",[t.loading?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Please wait while loading the post ... ")],1):t._e(),!t.loading&&t.post?s("div",[s("post-view-component",{attrs:{post:t.post},on:{"post-deleted":t.onPostDeleted}})],1):t._e()]),t.pageNotFound?s("div",{staticClass:"p-5 box text-center fs-lg font-weight-bold"},[t._v(" Page not found! ")]):t._e()])},i=[],o=(s("d3b7"),s("ac1f"),s("1276"),s("9ab4")),r=s("2b0e"),a=s("2fe1"),c=s("d28a"),l=s("d68b"),p=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("article",{staticClass:"post-view px-2 py-4"},[s("h3",[t._v(t._s(t.post.title))]),s("div",{staticClass:"d-flex"},[s("user-avatar",{attrs:{parent:t.post}}),s("div",{staticClass:"ml-2"},[s("user-display-name",{staticClass:"font-weight-bold",attrs:{parent:t.post}}),s("post-meta-component",{attrs:{post:t.post}})],1)],1),s("div",{staticClass:"mt-3 p-2 rounded",staticStyle:{"background-color":"#f1f1f1","white-space":"break-space"}},[t._v(" "+t._s(t.post.content)+" ")]),s("file-display",{staticClass:"mt-2",attrs:{files:t.post.files}}),s("hr",{staticClass:"my-3"}),s("div",{staticClass:"d-flex"},[s("vote-buttons-component",{attrs:{parent:t.post}}),s("span",{staticClass:"flex-grow-1"}),t.app.api.isMine(t.post)?s("mine-buttons-component",{attrs:{parent:t.post},on:{"on-click-edit":function(e){return t.onClickEdit()},"on-click-delete":function(e){return t.onClickDelete(t.post.idx)}}}):t._e()],1),s("comment-form-component",{staticClass:"mt-2",attrs:{parent:t.post,root:t.post}}),s("div",{staticClass:"comments"},t._l(t.post.comments,(function(e){return s("div",{key:e.idx,staticClass:"mt-2",style:{"margin-left":8*e.depth+"px"}},[s("comment-view-component",{attrs:{post:t.post,comment:e}})],1)})),0)],1)},u=[],m=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"w-100"},[s("form",{staticClass:"comment-form p-2 d-flex",on:{submit:function(e){return e.preventDefault(),t.onCommentSubmit.apply(null,arguments)}}},[s("div",{staticClass:"mr-2"},[s("upload-button",{attrs:{size:35},on:{success:t.onFileUploaded,progress:function(e){t.uploadProgress=e}}})],1),s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.content,expression:"form.content"}],staticClass:"w-100 form-control",staticStyle:{height:"40px"},attrs:{type:"text",name:"content",placeholder:"Comment .."},domProps:{value:t.form.content},on:{input:function(e){e.target.composing||t.$set(t.form,"content",e.target.value)}}}),t.canSubmit||t.comment?s("div",{staticClass:"ml-2 d-flex"},[t.comment||t.parent.idx!=t.root.idx?s("div",[t.submitted?t._e():s("button",{staticClass:"btn btn-sm btn-danger h-100",attrs:{type:"button"},on:{click:t.onClickCancel}},[t._v(" Cancel ")])]):t._e(),!t.submitted&&t.canSubmit?s("div",[s("button",{staticClass:"w-100 ml-2 btn btn-sm btn-success h-100",attrs:{type:"submit"}},[t._v(" Submit ")])]):t._e(),t.submitted?s("div",{staticClass:"my-1 mx-2"},[s("b-spinner",{attrs:{type:"grow",variant:"success"}})],1):t._e()]):t._e()]),t.uploadProgress?s("b-progress",{staticClass:"mb-3 ml-2 mr-3",attrs:{value:t.uploadProgress,max:"100"}}):t._e(),s("file-display",{attrs:{files:t.uploadedFiles,showDelete:!0},on:{"file-deleted":t.onFileDeleted}})],1)},d=[],f=(s("498a"),s("a15b"),s("d81d"),s("25f0"),s("c740"),s("a434"),s("2297")),h=s("ae56"),b=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form=new c["b"],e.app=l["a"].instance,e.submitted=!1,e.uploadProgress=0,e.uploadedFiles=[],e}return Object(o["c"])(e,t),Object.defineProperty(e.prototype,"canSubmit",{get:function(){return!!this.uploadedFiles.length||!!this.form.content.trim().length},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){this.comment&&(this.form.idx=this.comment.idx,this.form.content=this.comment.content,this.form.files=this.comment.files.map((function(t){return""+t.idx})).join(","),this.uploadedFiles=this.comment.files)},e.prototype.onCommentSubmit=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e;return Object(o["d"])(this,(function(s){switch(s.label){case 0:if(this.submitted)return[2];this.submitted=!0,this.form.rootIdx=this.root.idx,this.form.parentIdx=this.comment?this.comment.parentIdx:this.parent.idx,s.label=1;case 1:return s.trys.push([1,3,,4]),[4,this.app.api.commentEdit(this.form)];case 2:return t=s.sent(),this.comment?(Object.assign(this.comment,t),this.comment.inEdit=!1):(t.depth=(this.parent.depth?+this.parent.depth+1:1).toString(),this.root.insertComment(t)),this.form.content="",this.uploadedFiles=[],this.submitted=!1,[3,4];case 3:return e=s.sent(),this.app.error(e),this.submitted=!1,[3,4];case 4:return[2]}}))}))},e.prototype.onClickCancel=function(){this.comment?this.comment.inEdit=!1:this.parent.inReply=!1},e.prototype.onFileUploaded=function(t){this.form.files=this.app.addByComma(this.form.files,t.idx),this.uploadedFiles.push(t),this.uploadProgress=0},e.prototype.onFileDeleted=function(t){this.form.files=this.app.deleteByComma(this.form.files,t);var e=this.uploadedFiles.findIndex((function(e){return e.idx==t}));this.uploadedFiles.splice(e,1)},e=Object(o["b"])([Object(a["a"])({props:["root","parent","comment"],components:{UploadButton:f["a"],FileDisplay:h["a"]}})],e),e}(r["a"]),v=b,g=v,C=s("2877"),x=Object(C["a"])(g,m,d,!1,null,null,null),y=x.exports,_=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",[s("div",{staticClass:"comment-view p-3 rounded",staticStyle:{"background-color":"#f0f0f0"}},[s("div",{staticClass:"d-flex"},[s("user-avatar",{attrs:{parent:t.comment,size:2.8}}),s("div",{staticClass:"ml-2 text-truncate"},[s("user-display-name",{staticClass:"font-weight-bold",attrs:{parent:t.comment}}),s("div",[t._v("No. "+t._s(t.comment.idx)+" • "+t._s(t.comment.shortDate))])],1)],1),t.comment.inEdit?t._e():s("div",{staticClass:"w-100"},[s("div",{staticClass:"mt-2"},[t._v(t._s(t.comment.content))]),s("file-display",{attrs:{files:t.comment.files}})],1),t.comment.inEdit?s("comment-form-component",{attrs:{root:t.post,comment:t.comment}}):t._e(),s("hr",{staticClass:"my-2"}),t.comment.inEdit?t._e():s("div",{staticClass:"mt-2 d-flex"},[s("div",{staticClass:"d-flex"},[s("button",{staticClass:"mr-2 btn btn-sm",on:{click:function(e){t.comment.inReply=!t.comment.inReply}}},[t._v(" Reply ")]),s("vote-buttons-component",{attrs:{parent:t.comment}})],1),s("span",{staticClass:"flex-grow-1"}),t.app.api.isMine(t.comment)?s("mine-buttons-component",{attrs:{parent:t.comment},on:{"on-click-edit":function(e){t.comment.inEdit=!t.comment.inEdit},"on-click-delete":t.onClickDelete}}):t._e()],1)],1),t.comment.inReply?s("comment-form-component",{attrs:{root:t.post,parent:t.comment}}):t._e()],1)},O=[],j=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("button",{staticClass:"btn btn-sm",staticStyle:{color:"green"},on:{click:function(e){return t.onClickVote("Y")}}},[t._v(" Like "),t.parent.Y?s("span",{staticClass:"badge badge-pill badge-success"},[t._v(" "+t._s(t.parent.Y)+" ")]):t._e()]),s("button",{staticClass:"ml-2 btn btn-sm",staticStyle:{color:"red"},on:{click:function(e){return t.onClickVote("N")}}},[t._v(" Dislike "),t.parent.N?s("span",{staticClass:"badge badge-pill badge-danger"},[t._v(" "+t._s(t.parent.N)+" ")]):t._e()])])},w=[],k=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=l["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickVote=function(t){return Object(o["a"])(this,void 0,Promise,(function(){var e,s;return Object(o["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,this.app.api.vote({idx:this.parent.idx,choice:t})];case 1:return e=n.sent(),Object.assign(this.parent,{Y:e["Y"],N:e["N"]}),[3,3];case 2:return s=n.sent(),this.app.error(s),[3,3];case 3:return[2]}}))}))},e=Object(o["b"])([Object(a["a"])({props:["parent"]})],e),e}(r["a"]),D=k,E=D,S=Object(C["a"])(E,j,w,!1,null,null,null),F=S.exports,P=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"mine-buttons"},[n("button",{staticClass:"btn btn-sm",attrs:{id:"mine-button-popover-"+t.parent.idx}},[n("img",{staticClass:"icon-v grey",attrs:{src:s("df07")}})]),n("b-popover",{ref:"popover",attrs:{placement:"bottomleft",target:"mine-button-popover-"+t.parent.idx,triggers:"click blur"}},[n("button",{staticClass:"btn btn-sm btn-success",on:{click:function(e){return t.onClickEmit("on-click-edit")}}},[t._v(" Edit ")]),n("button",{staticClass:"ml-2 btn btn-sm btn-danger",on:{click:function(e){return t.onClickEmit("on-click-delete")}}},[t._v(" Delete ")])])],1)},$=[],N=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e.prototype.onClickEmit=function(t){this.$emit(t),this.$root.$emit("bv::hide::popover","mine-button-popover-"+this.parent.idx)},e=Object(o["b"])([Object(a["a"])({props:["parent"]})],e),e}(r["a"]),z=N,U=z,V=Object(C["a"])(U,P,$,!1,null,null,null),I=V.exports,R=s("adee"),B=s("903b"),M=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=l["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickDelete=function(){var t;return Object(o["a"])(this,void 0,Promise,(function(){var e,s;return Object(o["d"])(this,(function(n){switch(n.label){case 0:if(e=confirm("Are you sure you want to delete this comment? [IDX]: "+this.post.idx),!e)return[2];n.label=1;case 1:return n.trys.push([1,3,,4]),[4,this.app.api.commentDelete(null===(t=this.comment)||void 0===t?void 0:t.idx)];case 2:return n.sent(),this.post.deleteComment(this.comment.idx),[3,4];case 3:return s=n.sent(),this.app.error(s),[3,4];case 4:return[2]}}))}))},e=Object(o["b"])([Object(a["a"])({props:["post","comment"],components:{CommentFormComponent:y,VoteButtonsComponent:F,MineButtonsComponent:I,UserDisplayName:R["a"],UserAvatar:B["a"],FileDisplay:h["a"]}})],e),e}(r["a"]),A=M,Y=A,J=Object(C["a"])(Y,_,O,!1,null,null,null),L=J.exports,T=s("6b91"),X=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=l["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickDelete=function(){var t,e;return Object(o["a"])(this,void 0,Promise,(function(){var s,n;return Object(o["d"])(this,(function(i){switch(i.label){case 0:if(s=confirm("Are you sure you want to delete this post? [IDX]: "+this.post.idx),!s)return[2];i.label=1;case 1:return i.trys.push([1,3,,4]),[4,this.app.api.postDelete(null===(t=this.post)||void 0===t?void 0:t.idx)];case 2:return i.sent(),this.$emit("post-deleted",null===(e=this.post)||void 0===e?void 0:e.idx),[3,4];case 3:return n=i.sent(),this.app.error(n),[3,4];case 4:return[2]}}))}))},e.prototype.onClickEdit=function(){this.$router.push("/edit/"+this.post.idx).catch((function(){return null}))},e=Object(o["b"])([Object(a["a"])({props:["post"],components:{CommentFormComponent:y,CommentViewComponent:L,PostMetaComponent:T["a"],VoteButtonsComponent:F,MineButtonsComponent:I,UserDisplayName:R["a"],UserAvatar:B["a"],FileDisplay:h["a"]}})],e),e}(r["a"]),G=X,q=G,H=Object(C["a"])(q,p,u,!1,null,null,null),K=H.exports,Q=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.loading=!1,e.post=new c["f"],e.app=l["a"].instance,e.pageNotFound=!1,e}return Object(o["c"])(e,t),e.prototype.mounted=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e,s,n,i;return Object(o["d"])(this,(function(o){switch(o.label){case 0:console.log("PostView::mounted(); "),this.loading=!0,e=location.href.split("/"),s=e[e.length-1],console.log(s),t=isNaN(parseInt(s))?{path:location.href}:{idx:s},o.label=1;case 1:return o.trys.push([1,3,,4]),console.log(t),[4,this.app.api.postGet(t)];case 2:return n=o.sent(),this.loading=!1,this.post=this.post.fromJson(n),[3,4];case 3:return i=o.sent(),this.loading=!1,this.pageNotFound=!0,this.app.error(i),[3,4];case 4:return[2]}}))}))},e.prototype.onPostDeleted=function(t){console.log("Post "+t+" deleted. todo: move back to list.")},e=Object(o["b"])([Object(a["a"])({components:{PostViewComponent:K}})],e),e}(r["a"]),W=Q,Z=W,tt=Object(C["a"])(Z,n,i,!1,null,null,null);e["default"]=tt.exports},"2e1d":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"user-menu"},[s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/profile/"+t.user.idx}},[t._v(" @Todo: See user profile ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/posts/"+t.user.idx}},[t._v(" See user posts ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/comments/"+t.user.idx}},[t._v(" See user comments ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/message/"+t.user.idx}},[t._v(" @Todo: Send message ")])],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["a"])({props:["user"]})],e),e}(r["a"]),l=c,p=l,u=s("2877"),m=Object(u["a"])(p,n,i,!1,null,null,null);e["a"]=m.exports},"498a":function(t,e,s){"use strict";var n=s("23e7"),i=s("58a8").trim,o=s("c8d2");n({target:"String",proto:!0,forced:o("trim")},{trim:function(){return i(this)}})},5899:function(t,e){t.exports="\t\n\v\f\r                　\u2028\u2029\ufeff"},"58a8":function(t,e,s){var n=s("1d80"),i=s("5899"),o="["+i+"]",r=RegExp("^"+o+o+"*"),a=RegExp(o+o+"*$"),c=function(t){return function(e){var s=String(n(e));return 1&t&&(s=s.replace(r,"")),2&t&&(s=s.replace(a,"")),s}};t.exports={start:c(1),end:c(2),trim:c(3)}},"6b91":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"post-meta d-flex text-truncate"},[t.showName?s("user-displayname",{staticClass:"mr-2 font-weight-bold",attrs:{parent:t.post}}):t._e(),t.showName?t._e():s("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.post.idx))]),t.post.categoryIdx?s("span",{staticClass:"text-muted mr-2"},[t._v(" • Category "+t._s(t.post.categoryIdx)+" ")]):t._e(),t.post.noOfComments?s("span",{staticClass:"text-muted mr-2"},[t._v(" • Comments "+t._s(t.post.noOfComments)+" ")]):t._e(),t.post.noOfViews?s("span",{staticClass:"text-muted mr-2"},[t._v(" • Views "+t._s(t.post.noOfViews)+" ")]):t._e(),t.post.shortDate?s("span",{staticClass:"text-muted"},[t._v(" • Date: "+t._s(t.post.shortDate)+" ")]):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("adee"),l=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["a"])({props:["post","showName"],components:{UserDisplayname:c["a"]}})],e),e}(r["a"]),p=l,u=p,m=s("2877"),d=Object(m["a"])(u,n,i,!1,null,null,null);e["a"]=d.exports},"872d":function(t,e,s){t.exports=s.p+"img/camera.f2c26d4b.svg"},"903b":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("b-avatar",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id,src:t.src,size:t.defaultSize+"em"}}),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("2e1d"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=3,e.src="",e.id="user-avatar-popover-",e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size),this.src=this.parent.user.photoUrl,this.id+=this.parent.idx},e=Object(o["b"])([Object(a["a"])({props:["parent","size"],components:{UserMenu:c["a"]}})],e),e}(r["a"]),p=l,u=p,m=s("2877"),d=Object(m["a"])(u,n,i,!1,null,null,null);e["a"]=d.exports},adee:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("div",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("2e1d"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.id="displayname-popover-",e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.id+=this.parent.idx},e=Object(o["b"])([Object(a["a"])({props:["parent"],components:{UserMenu:c["a"]}})],e),e}(r["a"]),p=l,u=p,m=s("2877"),d=Object(m["a"])(u,n,i,!1,null,null,null);e["a"]=d.exports},ae56:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"file-display grid"},[s("div",{staticClass:"row"},t._l(t.files,(function(e){return s("div",{key:e.idx,staticClass:"position-relative p-1 col-3",staticStyle:{height:"150px"}},[t.showDelete?s("img",{staticClass:"icon position-absolute top-35 left-35",attrs:{src:"/svg/fas-trash.svg"},on:{click:function(s){return t.onClickDelete(e.idx)}}}):t._e(),s("img",{staticClass:"w-100 h-100",attrs:{src:e.url,alt:e.name}})])})),0)])},i=[],o=(s("d3b7"),s("9ab4")),r=s("d68b"),a=s("2b0e"),c=s("2fe1"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=r["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickDelete=function(t){return Object(o["a"])(this,void 0,Promise,(function(){var e,s;return Object(o["d"])(this,(function(n){switch(n.label){case 0:if(e=confirm("Are you sure you want to delete this file?"),!e)return[2];n.label=1;case 1:return n.trys.push([1,3,,4]),[4,this.app.api.fileDelete(t)];case 2:return n.sent(),this.$emit("file-deleted",t),[3,4];case 3:return s=n.sent(),this.app.error(s),[3,4];case 4:return[2]}}))}))},e=Object(o["b"])([Object(c["a"])({props:["files","showDelete"]})],e),e}(a["a"]),p=l,u=p,m=s("2877"),d=Object(m["a"])(u,n,i,!1,null,null,null);e["a"]=d.exports},c8d2:function(t,e,s){var n=s("d039"),i=s("5899"),o="​᠎";t.exports=function(t){return n((function(){return!!i[t]()||o[t]()!=o||i[t].name!==t}))}},df07:function(t,e,s){t.exports=s.p+"img/ellipsis-v.1f0cd80f.svg"}}]);
//# sourceMappingURL=chunk-0590b908.8db3697d.js.map