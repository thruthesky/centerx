(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-81b3ae8c"],{"0738":function(t,e,s){t.exports=s.p+"img/fas-trash.7677c3c9.svg"},"25f0":function(t,e,s){"use strict";var n=s("6eeb"),i=s("825a"),o=s("d039"),r=s("ad6d"),a="toString",c=RegExp.prototype,l=c[a],u=o((function(){return"/a/b"!=l.call({source:"a",flags:"b"})})),p=l.name!=a;(u||p)&&n(RegExp.prototype,a,(function(){var t=i(this),e=String(t.source),s=t.flags,n=String(void 0===s&&t instanceof RegExp&&!("flags"in c)?r.call(t):s);return"/"+e+"/"+n}),{unsafe:!0})},"2a99":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[t.id?s("div",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]):t._e(),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("f873"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.id="",e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.id="displayname-popover-"+this.parent.idx},e=Object(o["b"])([Object(a["b"])({props:["parent"],components:{UserMenu:c["a"]}})],e),e}(r["default"]),u=l,p=u,m=s("2877"),d=Object(m["a"])(p,n,i,!1,null,null,null);e["a"]=d.exports},"2c67":function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"post-view-page"},[s("PostView",{key:t.$store.state.postViewKey,on:{post:function(e){return t.$store.commit("currentCategory",e.categoryId)}}})],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[t.post.idx&&!t.loading?s("article",{staticClass:"post-view px-2 py-4",attrs:{"data-cy":"post-view"}},[s("div",{staticClass:"d-flex justify-content-between"},[s("h3",{attrs:{id:"post-title"}},[t._v(t._s(t.post.title))]),s("router-link",{staticClass:"btn btn-outline-info",attrs:{to:t.toListPage}},[t._v(" "+t._s(t._f("t")("back_to_list"))+" ")])],1),s("div",{staticClass:"d-flex"},[s("user-avatar",{attrs:{parent:t.post}}),s("div",{staticClass:"ml-2"},[s("user-display-name",{staticClass:"font-weight-bold",attrs:{parent:t.post}}),s("post-meta-component",{attrs:{"data-cy":"post-view-meta",post:t.post}})],1)],1),t.post.deletedAt?s("div",{staticClass:"mt-2"},[t._v(" "+t._s(t._f("t")("post_deleted"))+" ")]):t._e(),t.post.deletedAt?t._e():s("div",{staticClass:"mt-3 p-2 rounded",staticStyle:{"background-color":"#f1f1f1","white-space":"break-space"},attrs:{id:"post-content"}},[t._v(" "+t._s(t.post.content)+" ")]),s("file-display",{staticClass:"mt-2",attrs:{files:t.post.files}}),s("hr",{staticClass:"my-3"}),s("div",{staticClass:"d-flex"},[s("vote-buttons-component",{attrs:{parent:t.post}}),s("span",{staticClass:"flex-grow-1"}),s("router-link",{staticClass:"btn btn-sm btn-info mr-2",attrs:{to:t.toListPage}},[t._v(" "+t._s(t._f("t")("back_to_list"))+" ")]),s("mine-buttons-component",{attrs:{parent:t.post}})],1),s("comment-form-component",{staticClass:"mt-2",attrs:{"data-cy":"post-comment-form",parent:t.post,root:t.post}}),t.post.comments.length?s("div",{staticClass:"comments"},[s("hr",{staticClass:"m-2"}),s("div",{staticClass:"text-muted px-2 mb-3"},[t._v(" "+t._s(t.post.comments.length)+" comments ")]),t._l(t.post.comments,(function(e,n){return s("div",{key:e.idx,staticClass:"mt-2",style:{"margin-left":8*e.depth+"px"}},[s("comment-view-component",{attrs:{"data-cy":"comment-"+n,post:t.post,comment:e}})],1)}))],2):t._e(),s("div",{staticClass:"d-flex justify-content-end mt-3"},[s("router-link",{staticClass:"btn btn-outline-info",attrs:{to:t.toListPage}},[t._v(" "+t._s(t._f("t")("back_to_list"))+" ")])],1)],1):t._e(),t.loading?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Please wait while loading the post ... ")],1):t._e()])},l=[],u=(s("d3b7"),s("ac1f"),s("1276"),s("841c"),s("d28a")),p=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"w-100"},[s("form",{staticClass:"comment-form p-2 d-flex",on:{submit:function(e){return e.preventDefault(),t.onCommentSubmit.apply(null,arguments)}}},[s("div",{staticClass:"mr-2"},[s("upload-button",{attrs:{size:35},on:{success:t.onFileUploaded,progress:function(e){t.uploadProgress=e}}})],1),s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.content,expression:"form.content"}],staticClass:"w-100 form-control",staticStyle:{height:"40px"},attrs:{"data-cy":"comment-input",type:"text",name:"content",placeholder:"Comment .."},domProps:{value:t.form.content},on:{input:function(e){e.target.composing||t.$set(t.form,"content",e.target.value)}}}),t.canSubmit||t.comment?s("div",{staticClass:"ml-2 d-flex"},[t.comment||t.parent.idx!=t.root.idx?s("div",[t.submitted?t._e():s("button",{staticClass:"btn btn-sm btn-danger h-100",attrs:{type:"button"},on:{click:t.onClickCancel}},[t._v(" Cancel ")])]):t._e(),!t.submitted&&t.canSubmit?s("div",[s("button",{staticClass:"w-100 ml-2 btn btn-sm btn-success h-100",attrs:{"data-cy":"comment-submit-button",type:"submit"}},[t._v(" Submit ")])]):t._e(),t.submitted?s("div",{staticClass:"my-1 mx-2"},[s("b-spinner",{attrs:{type:"grow",variant:"success"}})],1):t._e()]):t._e()]),t.uploadProgress?s("b-progress",{staticClass:"mb-3 ml-2 mr-3",attrs:{value:t.uploadProgress,max:"100"}}):t._e(),s("file-display",{attrs:{files:t.uploadedFiles,showDelete:!0},on:{"file-deleted":t.onFileDeleted}})],1)},m=[],d=(s("498a"),s("a15b"),s("d81d"),s("25f0"),s("450c")),f=s("8857"),b=s("9f3a"),h=s("d661"),v=s("f6b1"),g=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form=new u["d"],e.api=b["a"].instance,e.submitted=!1,e.uploadProgress=0,e.uploadedFiles=[],e}return Object(o["c"])(e,t),Object.defineProperty(e.prototype,"canSubmit",{get:function(){return!!this.uploadedFiles.length||!!this.form.content.trim().length},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){this.comment&&(this.form.idx=this.comment.idx,this.form.content=this.comment.content,this.form.files=this.comment.files.map((function(t){return""+t.idx})).join(","),this.uploadedFiles=this.comment.files)},e.prototype.onCommentSubmit=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e;return Object(o["d"])(this,(function(s){switch(s.label){case 0:if(this.submitted)return[2];this.submitted=!0,this.form.rootIdx=this.root.idx,this.form.parentIdx=this.comment?this.comment.parentIdx:this.parent.idx,s.label=1;case 1:return s.trys.push([1,3,,4]),[4,this.api.commentEdit(this.form)];case 2:return t=s.sent(),this.comment?(Object.assign(this.comment,t),this.comment.inEdit=!1):(t.depth=(this.parent.depth?+this.parent.depth+1:1).toString(),this.root.insertComment(t)),this.form.content="",this.uploadedFiles=[],this.submitted=!1,[3,4];case 3:return e=s.sent(),this.submitted=!1,v["b"].instance.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.onClickCancel=function(){this.comment?this.comment.inEdit=!1:this.parent.inReply=!1},e.prototype.onFileUploaded=function(t){this.form.files=Object(h["a"])(this.form.files,t.idx),this.uploadedFiles.push(t),this.uploadProgress=0},e.prototype.onFileDeleted=function(t){this.form.files=Object(h["c"])(this.form.files,t)},e=Object(o["b"])([Object(a["b"])({props:["root","parent","comment"],components:{UploadButton:d["a"],FileDisplay:f["a"]}})],e),e}(r["default"]),_=g,C=_,y=s("2877"),x=Object(y["a"])(C,p,m,!1,null,null,null),j=x.exports,O=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"comment-view"},[s("div",{staticClass:"p-3 rounded",staticStyle:{"background-color":"#f0f0f0"}},[s("div",{staticClass:"d-flex"},[s("user-avatar",{attrs:{parent:t.comment,size:2.8}}),s("div",{staticClass:"ml-2 text-truncate"},[s("user-display-name",{staticClass:"font-weight-bold",attrs:{parent:t.comment}}),s("div",[t._v("No. "+t._s(t.comment.idx)+" • "+t._s(t.comment.shortDate))])],1)],1),t.comment.inEdit?t._e():s("div",{staticClass:"w-100"},[t.comment.deletedAt?s("div",{staticClass:"mt-2"},[t._v(" "+t._s(t._f("t")("comment_deleted"))+" ")]):t._e(),t.comment.deletedAt?t._e():s("div",{staticClass:"mt-2",attrs:{"data-cy":"comment-content"}},[t._v(" "+t._s(t.comment.content)+" ")]),s("file-display",{attrs:{files:t.comment.files}})],1),t.comment.inEdit?s("comment-form-component",{attrs:{root:t.post,comment:t.comment}}):t._e(),s("hr",{staticClass:"my-2"}),t.comment.inEdit?t._e():s("div",{staticClass:"mt-2 d-flex"},[s("div",{staticClass:"d-flex"},[s("button",{staticClass:"mr-2 btn btn-sm",on:{click:function(e){t.comment.inReply=!t.comment.inReply}}},[t._v(" Reply ")]),s("vote-buttons-component",{attrs:{parent:t.comment}})],1),s("span",{staticClass:"flex-grow-1"}),s("mine-buttons-component",{attrs:{"data-cy":"comment-mine-button",parent:t.comment}})],1)],1),t.comment.inReply?s("comment-form-component",{attrs:{"data-cy":"comment-reply-form",root:t.post,parent:t.comment}}):t._e()],1)},w=[],k=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("button",{staticClass:"btn btn-sm",staticStyle:{color:"green"},on:{click:function(e){return t.onClickVote("Y")}}},[t._v(" Like "),t.parent.Y?s("span",{staticClass:"badge badge-pill badge-success"},[t._v(" "+t._s(t.parent.Y)+" ")]):t._e()]),s("button",{staticClass:"ml-2 btn btn-sm",staticStyle:{color:"red"},on:{click:function(e){return t.onClickVote("N")}}},[t._v(" Dislike "),t.parent.N?s("span",{staticClass:"badge badge-pill badge-danger"},[t._v(" "+t._s(t.parent.N)+" ")]):t._e()])])},P=[],S=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=b["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickVote=function(t){return Object(o["a"])(this,void 0,Promise,(function(){var e,s;return Object(o["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,this.api.vote({idx:this.parent.idx,choice:t})];case 1:return e=n.sent(),this.parent.updateVoteCount(e),[3,3];case 2:return s=n.sent(),v["b"].instance.error(s),[3,3];case 3:return[2]}}))}))},e=Object(o["b"])([Object(a["b"])({props:["parent"]})],e),e}(r["default"]),E=S,D=E,$=Object(y["a"])(D,k,P,!1,null,null,null),F=$.exports,z=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.api.isMine(t.parent)?n("div",{staticClass:"mine-buttons"},[n("button",{staticClass:"btn btn-sm",attrs:{"data-cy":"mine-button",id:"mine-button-popover-"+t.parent.idx}},[n("img",{staticClass:"icon-v grey",attrs:{src:s("df07")}})]),n("b-popover",{ref:"popover",attrs:{placement:"bottomleft",target:"mine-button-popover-"+t.parent.idx,triggers:"click blur"}},[n("button",{staticClass:"btn btn-sm btn-success",attrs:{"data-cy":"mine-edit-button"},on:{click:t.onClickEdit}},[t._v(" Edit ")]),n("button",{staticClass:"ml-2 btn btn-sm btn-danger",attrs:{"data-cy":"mine-delete-button"},on:{click:t.onClickDelete}},[t._v(" Delete ")])])],1):t._e()},V=[],N=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=b["a"].instance,e}return Object(o["c"])(e,t),e.prototype.hidePopup=function(){this.$root.$emit("bv::hide::popover","mine-button-popover-"+this.parent.idx)},e.prototype.onClickEdit=function(){this.hidePopup(),this.parent.isPost?v["b"].instance.open("/edit/"+this.parent.idx+location.search):this.parent.inEdit=!0},e.prototype.onClickDelete=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e,s;return Object(o["d"])(this,(function(n){switch(n.label){case 0:return this.hidePopup(),[4,v["b"].instance.confirm("Title","Are you sure you want to delete this comment? [IDX]: "+this.parent.idx)];case 1:if(t=n.sent(),!t)return[2];n.label=2;case 2:return n.trys.push([2,7,,8]),e=void 0,this.parent.isPost?[4,this.api.postDelete(this.parent.idx)]:[3,4];case 3:return e=n.sent(),[3,6];case 4:return[4,this.api.commentDelete(this.parent.idx)];case 5:e=n.sent(),n.label=6;case 6:return this.parent=Object.assign(this.parent,e),[3,8];case 7:return s=n.sent(),v["b"].instance.error(s),[3,8];case 8:return[2]}}))}))},e=Object(o["b"])([Object(a["b"])({props:["parent"]})],e),e}(r["default"]),U=N,R=U,A=Object(y["a"])(R,z,V,!1,null,null,null),I=A.exports,M=s("2a99"),B=s("82da"),L=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["b"])({props:["post","comment"],components:{CommentFormComponent:j,VoteButtonsComponent:F,MineButtonsComponent:I,UserDisplayName:M["a"],UserAvatar:B["a"],FileDisplay:f["a"]}})],e),e}(r["default"]),T=L,Y=T,J=Object(y["a"])(Y,O,w,!1,null,null,null),G=J.exports,K=s("3181"),X=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.post=new u["h"],e.loading=!1,e}return Object(o["c"])(e,t),e.prototype.mounted=function(){return Object(o["a"])(this,void 0,Promise,(function(){var t,e,s,n,i;return Object(o["d"])(this,(function(o){switch(o.label){case 0:console.log("PostView::mounted::"),this.loading=!0,t=location.href.split("/"),e=t[t.length-1],s={idx:e},o.label=1;case 1:return o.trys.push([1,3,,4]),n=this,[4,this.$app.api.postGet(s)];case 2:return n.post=o.sent(),this.$emit("post",this.post),this.loading=!1,[3,4];case 3:return i=o.sent(),this.loading=!1,this.$app.error(i),[3,4];case 4:return[2]}}))}))},Object.defineProperty(e.prototype,"toListPage",{get:function(){return"forum/"+this.post.categoryId+location.search},enumerable:!1,configurable:!0}),e=Object(o["b"])([Object(a["b"])({components:{CommentFormComponent:j,CommentViewComponent:G,PostMetaComponent:K["a"],VoteButtonsComponent:F,MineButtonsComponent:I,UserDisplayName:M["a"],UserAvatar:B["a"],FileDisplay:f["a"]}})],e),e}(r["default"]),q=X,H=q,Q=Object(y["a"])(H,c,l,!1,null,null,null),W=Q.exports,Z=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["b"])({components:{PostView:W}})],e),e}(r["default"]),tt=Z,et=tt,st=Object(y["a"])(et,n,i,!1,null,null,null);e["default"]=st.exports},3181:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"post-meta text-truncate"},[t.showName?s("user-displayname",{staticClass:"mr-2 font-weight-bold",attrs:{parent:t.post}}):t._e(),t.showName?t._e():s("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.post.idx))]),t.post.shortDate?s("span",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.shortDate)+" ")]):t._e(),t.post.noOfViews?s("span",{staticClass:"text-muted mr-2"},[t._v(" Views "+t._s(t.post.noOfViews)+" ")]):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("2a99"),l=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["b"])({props:["post","showName"],components:{UserDisplayname:c["a"]}})],e),e}(r["default"]),u=l,p=u,m=s("2877"),d=Object(m["a"])(p,n,i,!1,null,null,null);e["a"]=d.exports},"450c":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"pr-2 position-relative overflow-hidden pointer"},[n("img",{staticClass:"pointer",style:{width:t.defaultSize+"px",height:t.defaultSize+"px"},attrs:{src:s("872d")}}),n("input",{staticClass:"h-100 top right position-absolute fs-lg opacity-0 pointer",attrs:{type:"file"},on:{change:t.onFileChange}})])},i=[],o=(s("d3b7"),s("9ab4")),r=s("2b0e"),a=s("2fe1"),c=s("9f3a"),l=s("f6b1"),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=35,e.api=c["a"].instance,e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size)},e.prototype.onFileChange=function(t){var e,s;return Object(o["a"])(this,void 0,Promise,(function(){var n,i,r;return Object(o["d"])(this,(function(o){switch(o.label){case 0:if(!this.api._user.loggedIn)return l["b"].instance.error("error_login_first"),[2];if(null===t.target.files||0===(null===(s=null===(e=t.target)||void 0===e?void 0:e.files)||void 0===s?void 0:s.length))return[2];n=t.target.files[0],o.label=1;case 1:return o.trys.push([1,3,,4]),[4,this.api.fileUpload(n,{},this.onProgress)];case 2:return i=o.sent(),this.$emit("success",i),[3,4];case 3:return r=o.sent(),l["b"].instance.error(r),[3,4];case 4:return[2]}}))}))},e.prototype.onProgress=function(t){this.$emit("progress",t)},e=Object(o["b"])([Object(a["b"])({props:["size"]})],e),e}(r["default"]),p=u,m=p,d=s("2877"),f=Object(d["a"])(m,n,i,!1,null,null,null);e["a"]=f.exports},"498a":function(t,e,s){"use strict";var n=s("23e7"),i=s("58a8").trim,o=s("c8d2");n({target:"String",proto:!0,forced:o("trim")},{trim:function(){return i(this)}})},5899:function(t,e){t.exports="\t\n\v\f\r                　\u2028\u2029\ufeff"},"58a8":function(t,e,s){var n=s("1d80"),i=s("5899"),o="["+i+"]",r=RegExp("^"+o+o+"*"),a=RegExp(o+o+"*$"),c=function(t){return function(e){var s=String(n(e));return 1&t&&(s=s.replace(r,"")),2&t&&(s=s.replace(a,"")),s}};t.exports={start:c(1),end:c(2),trim:c(3)}},"82da":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("b-avatar",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id,src:t.parent.user.src,size:t.defaultSize+"em"}}),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=s("f873"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=3,e.src="",e.id="",e}return Object(o["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size),this.id="user-avatar-popover-"+this.parent.idx},e=Object(o["b"])([Object(a["b"])({props:["parent","size"],components:{UserMenu:c["a"]}})],e),e}(r["default"]),u=l,p=u,m=s("2877"),d=Object(m["a"])(p,n,i,!1,null,null,null);e["a"]=d.exports},"872d":function(t,e,s){t.exports=s.p+"img/camera.f2c26d4b.svg"},8857:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"file-display grid"},[n("div",{staticClass:"row"},t._l(t.files,(function(e){return n("div",{key:e.idx,staticClass:"position-relative p-1 col-3",staticStyle:{height:"150px"}},[t.showDelete?n("div",{staticClass:"icon-lg position-absolute m-2 bg-light circle-center pointer",on:{click:function(s){return t.onClickDelete(e.idx)}}},[n("img",{staticClass:"icon-md",attrs:{src:s("0738")}})]):t._e(),n("img",{staticClass:"w-100 h-100",attrs:{src:e.url,alt:e.name}})])})),0)])},i=[],o=(s("d3b7"),s("c740"),s("a434"),s("9ab4")),r=s("2b0e"),a=s("2fe1"),c=s("9f3a"),l=s("f6b1"),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=c["a"].instance,e}return Object(o["c"])(e,t),e.prototype.onClickDelete=function(t){return Object(o["a"])(this,void 0,Promise,(function(){var e,s,n;return Object(o["d"])(this,(function(i){switch(i.label){case 0:return[4,l["b"].instance.confirm("Title","Are you sure you want to delete this file?")];case 1:if(e=i.sent(),!e)return[2];i.label=2;case 2:return i.trys.push([2,4,,5]),[4,this.api.fileDelete(t)];case 3:return i.sent(),s=this.files.findIndex((function(e){return e.idx==t})),this.files.splice(s,1),this.$emit("file-deleted",t),[3,5];case 4:return n=i.sent(),l["b"].instance.error(n),[3,5];case 5:return[2]}}))}))},e=Object(o["b"])([Object(a["b"])({props:["files","showDelete"]})],e),e}(r["default"]),p=u,m=p,d=s("2877"),f=Object(d["a"])(m,n,i,!1,null,null,null);e["a"]=f.exports},c8d2:function(t,e,s){var n=s("d039"),i=s("5899"),o="​᠎";t.exports=function(t){return n((function(){return!!i[t]()||o[t]()!=o||i[t].name!==t}))}},df07:function(t,e,s){t.exports=s.p+"img/ellipsis-v.1f0cd80f.svg"},f873:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"user-menu"},[s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/profile/"+t.user.idx}},[t._v(" @Todo: See user profile ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/posts/"+t.user.idx}},[t._v(" See user posts ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/comments/"+t.user.idx}},[t._v(" See user comments ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/message/"+t.user.idx}},[t._v(" @Todo: Send message ")])],1)},i=[],o=s("9ab4"),r=s("2b0e"),a=s("2fe1"),c=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(o["c"])(e,t),e=Object(o["b"])([Object(a["b"])({props:["user"]})],e),e}(r["default"]),l=c,u=l,p=s("2877"),m=Object(p["a"])(u,n,i,!1,null,null,null);e["a"]=m.exports}}]);
//# sourceMappingURL=chunk-81b3ae8c.c33d7884.js.map