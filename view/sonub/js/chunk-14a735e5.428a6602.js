(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-14a735e5"],{"11c8":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[s("path",{attrs:{d:"M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"}})])},i=[],r=s("2877"),o={},a=Object(r["a"])(o,n,i,!1,null,null,null);e["a"]=a.exports},1909:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 128 512"}},[s("path",{attrs:{d:"M64 208c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM16 104c0 26.5 21.5 48 48 48s48-21.5 48-48-21.5-48-48-48-48 21.5-48 48zm0 304c0 26.5 21.5 48 48 48s48-21.5 48-48-21.5-48-48-48-48 21.5-48 48z"}})])},i=[],r=s("2877"),o={},a=Object(r["a"])(o,n,i,!1,null,null,null);e["a"]=a.exports},2690:function(t,e,s){},"2a99":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"user-display-name d-flex"},[t.id?s("div",{staticClass:"pointer text-truncate",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]):t._e(),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},i=[],r=s("9ab4"),o=s("2b0e"),a=s("2fe1"),c=s("f873"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.id="",e}return Object(r["c"])(e,t),e.prototype.mounted=function(){this.id="displayname-popover-"+this.parent.idx},e=Object(r["b"])([Object(a["b"])({props:["parent"],components:{UserMenu:c["a"]}})],e),e}(o["default"]),u=l,p=u,d=s("2877"),m=Object(d["a"])(p,n,i,!1,null,null,null);e["a"]=m.exports},3213:function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"d-flex justify-content-end"},[s("router-link",{staticClass:"btn btn-link btn-sm fs-sm",attrs:{to:t.toListPage}},[t._v(t._s(t._f("t")("back_to_list")))]),s("router-link",{staticClass:"btn btn-link btn-sm fs-sm",attrs:{to:t.createUrl}},[t._v(t._s(t._f("t")("post_create")))])],1),t.loaded?s("article",{staticClass:"forum-view"},[s("h1",{staticClass:"title"},[t._v(t._s(t.post.title))]),s("div",{staticClass:"mt-3 d-flex"},[s("ForumUserAvatar",{attrs:{parent:t.post}}),s("div",{staticClass:"ml-2"},[s("div",{staticClass:"fs-sm"},[t._v(t._s(t.post.user.displayName))]),s("div",{staticClass:"fs-xs"},[t._v("번호: "+t._s(t.post.idx)+"   조회: "+t._s(t.post.noOfViews)+"   "+t._s(t.post.shortDate))])])],1),s("FileList",{staticClass:"round mt-2",attrs:{post:t.post}}),s("Content",{staticClass:"mt-3 p-25 fs-sm fs-md-md bg-lighter round",attrs:{parent:t.post}}),s("hr",{staticClass:"my-3"}),s("div",{staticClass:"d-flex"},[s("VoteButtons",{attrs:{parent:t.post},on:{voted:t.onVoted}}),s("span",{staticClass:"flex-grow-1"}),s("router-link",{staticClass:"btn btn-sm btn-info mr-2",attrs:{to:t.toListPage}},[t._v(t._s(t._f("t")("back_to_list")))]),s("MineButtons",{attrs:{parent:t.post},on:{edit:t.onClickEdit,delete:t.onClickDelete}})],1),s("CommentForm",{staticClass:"mt-2",attrs:{parent:t.post,root:t.post},on:{edited:t.onCommentEdited}}),t.post.comments.length?s("div",{staticClass:"comments"},[s("hr",{staticClass:"m-2"}),s("div",{staticClass:"text-muted px-2 mb-3"},[t._v(t._s(t.post.comments.length)+" comments")]),t._l(t.post.comments,(function(e){return s("div",{key:e.idx,staticClass:"mt-2",attrs:{depth:e.depth}},[s("div",{staticClass:"p-3 rounded",staticStyle:{"background-color":"#f0f0f0"}},[s("CommentMeta",{attrs:{comment:e}}),e.inEdit||e.deletedAt?t._e():s("div",{staticClass:"mt-2"},[s("FileList",{attrs:{post:e}}),s("Content",{staticClass:"mt-2",attrs:{parent:e}})],1),e.deletedAt?t._e():s("div",{staticClass:"mt-2 d-flex border-top"},[s("button",{staticClass:"mr-2 btn btn-sm",on:{click:function(t){e.inReply=!e.inReply}}},[t._v(" "+t._s(t._f("t")(e.inReply?"cancel":"reply"))+" ")]),s("VoteButtons",{attrs:{parent:e},on:{voted:t.onVoted}}),s("span",{staticClass:"flex-grow-1"}),s("MineButtons",{attrs:{parent:e},on:{edit:t.onClickEdit,delete:t.onClickDelete}})],1),e.inEdit?s("CommentForm",{attrs:{comment:e,root:t.post},on:{edited:t.onCommentEdited}}):t._e()],1),e.inReply?s("CommentForm",{attrs:{parent:e,root:t.post},on:{edited:t.onCommentEdited}}):t._e()],1)}))],2):t._e()],1):t._e(),0==t.loaded?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" "+t._s(t._f("t")("loading_post"))+" ")],1):t._e(),s("h1",[t._v("forum list")]),t.loaded?s("ForumList",{attrs:{post:t.post}}):t._e()],1)},i=[],r=(s("d3b7"),s("ac1f"),s("1276"),s("841c"),s("9ab4")),o=s("2b0e"),a=s("2fe1"),c=s("f793"),l=s("d68b"),u=s("9f3a"),p=s("3fdf"),d=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"w-100"},[s("form",{staticClass:"comment-form p-2 d-flex",on:{submit:function(e){return e.preventDefault(),t.onCommentSubmit.apply(null,arguments)}}},[s("div",{staticClass:"mr-2"},[s("upload-button",{attrs:{size:35},on:{success:t.onFileUploaded,progress:function(e){t.uploadProgress=e}}})],1),s("b-form-textarea",{staticClass:"w-100 form-control",attrs:{"data-cy":"comment-input",type:"text",name:"content",placeholder:"Comment ..",rows:"1","max-rows":"5"},model:{value:t.form.content,callback:function(e){t.$set(t.form,"content",e)},expression:"form.content"}}),t.canSubmit||t.comment?s("div",{staticClass:"ml-2"},[t.submitted?t._e():s("div",[t.canCancel?s("button",{staticClass:"w-100 mb-1 btn btn-sm btn-danger h-100",attrs:{type:"button"},on:{click:t.onClickCancel}},[t._v(" "+t._s(t._f("t")("cancel"))+" ")]):t._e(),t.canSubmit?s("button",{staticClass:"w-100 btn btn-sm btn-success h-100",attrs:{"data-cy":"comment-submit-button",type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")]):t._e()]),t.submitted?s("div",{staticClass:"my-1 mx-2"},[s("b-spinner",{attrs:{type:"grow",variant:"success"}})],1):t._e()]):t._e()],1),t.uploadProgress?s("b-progress",{staticClass:"mb-3 ml-2 mr-2",attrs:{value:t.uploadProgress,max:"100"}}):t._e(),s("FileEditList",{attrs:{post:t.form},on:{deleted:t.onFileDeleted}})],1)},m=[],f=(s("498a"),s("a15b"),s("d81d"),s("190e")),b=s("d661"),h=s("450c"),v=s("f297"),_=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.form=new p["a"],e.api=u["a"].instance,e.submitted=!1,e.uploadProgress=0,e.uploadedFiles=[],e}return Object(r["c"])(e,t),Object.defineProperty(e.prototype,"canSubmit",{get:function(){return!!this.uploadedFiles.length||!!this.form.content.trim().length},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"canCancel",{get:function(){return!!this.comment||(this.parent.idx!=this.root.idx||(this.submitted,!1))},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){this.comment&&(this.form.idx=this.comment.idx,this.form.content=this.comment.content,this.form.files=this.comment.files,this.form.fileIdxes=this.comment.files.map((function(t){return""+t.idx})).join(","),this.uploadedFiles=this.comment.files)},e.prototype.onCommentSubmit=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t,e;return Object(r["d"])(this,(function(s){switch(s.label){case 0:if(this.submitted)return[2];this.submitted=!0,this.form.rootIdx=this.root.idx,this.form.parentIdx=this.comment?this.comment.parentIdx:this.parent.idx,s.label=1;case 1:return s.trys.push([1,3,,4]),[4,this.api.commentEdit(this.form)];case 2:return t=s.sent(),this.comment?(t.depth=this.comment.depth,Object.assign(this.comment,t),this.comment.inEdit=!1):(t.depth=this.parent.depth?+this.parent.depth+1:1,this.parent.inReply=!1,this.root.insertComment(t)),this.form.content="",this.uploadedFiles=[],this.submitted=!1,this.$emit("edited",t),[3,4];case 3:return e=s.sent(),this.submitted=!1,f["b"].instance.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.onClickCancel=function(){this.comment?this.comment.inEdit=!1:this.parent.inReply=!1},e.prototype.onFileUploaded=function(t){this.form.fileIdxes=Object(b["a"])(this.form.fileIdxes,t.idx),this.uploadedFiles.push(t),this.uploadProgress=0},e.prototype.onFileDeleted=function(t){this.form.fileIdxes=Object(b["c"])(this.form.fileIdxes,t)},e=Object(r["b"])([Object(a["b"])({props:["root","parent","comment"],components:{UploadButton:h["a"],FileEditList:v["a"]}})],e),e}(o["default"]),C=_,y=C,g=s("2877"),x=Object(g["a"])(y,d,m,!1,null,null,null),j=x.exports,O=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[t.comment.deletedAt?s("div",{staticClass:"text-truncate text-muted"},[t._v(" "+t._s(t._f("t")("comment_deleted"))+" ")]):t._e(),t.comment.deletedAt?t._e():s("div",{staticClass:"d-flex"},[s("user-avatar",{attrs:{parent:t.comment,size:2.8}}),s("div",{staticClass:"ml-2 text-truncate"},[s("user-display-name",{staticClass:"font-weight-bold",attrs:{parent:t.comment}}),s("div",[t._v("No. "+t._s(t.comment.idx)+" • "+t._s(t.comment.shortDate))])],1)],1)])},w=[],k=s("2a99"),E=s("a153"),P=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(r["c"])(e,t),e=Object(r["b"])([Object(a["b"])({props:["comment"],components:{UserDisplayName:k["a"],UserAvatar:E["a"]}})],e),e}(o["default"]),$=P,F=$,D=Object(g["a"])(F,O,w,!1,null,null,null),S=D.exports,z=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("button",{staticClass:"btn btn-sm",staticStyle:{color:"green"},on:{click:function(e){return t.onClickVote("Y")}}},[t._v(" Like "),t.parent.Y?s("span",{staticClass:"badge badge-pill badge-success"},[t._v(" "+t._s(t.parent.Y)+" ")]):t._e()]),s("button",{staticClass:"ml-2 btn btn-sm",staticStyle:{color:"red"},on:{click:function(e){return t.onClickVote("N")}}},[t._v(" Dislike "),t.parent.N?s("span",{staticClass:"badge badge-pill badge-danger"},[t._v(" "+t._s(t.parent.N)+" ")]):t._e()])])},I=[],L=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=u["a"].instance,e}return Object(r["c"])(e,t),e.prototype.onClickVote=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,s;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),[4,this.api.vote({idx:this.parent.idx,choice:t})];case 1:return e=n.sent(),this.parent.updateVoteCount(e),this.$emit("voted"),[3,3];case 2:return s=n.sent(),f["b"].instance.error(s),[3,3];case 3:return[2]}}))}))},e=Object(r["b"])([Object(a["b"])({props:["parent"]})],e),e}(o["default"]),V=L,M=V,U=Object(g["a"])(M,z,I,!1,null,null,null),A=U.exports,N=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.api.isMine(t.parent)||t.api.admin?s("div",{staticClass:"mine-buttons"},[s("button",{staticClass:"btn btn-sm",attrs:{"data-cy":"mine-button",id:"mine-button-popover-"+t.parent.idx}},[s("EllipsisVSvg",{staticClass:"icon-v grey"})],1),s("b-popover",{ref:"popover",attrs:{placement:"bottomleft",target:"mine-button-popover-"+t.parent.idx,triggers:"click blur"}},[s("button",{staticClass:"btn btn-sm btn-success",attrs:{"data-cy":"mine-edit-button"},on:{click:t.onClickEdit}},[t._v(t._s(t._f("t")("edit")))]),s("button",{staticClass:"ml-2 btn btn-sm btn-danger",attrs:{"data-cy":"mine-delete-button"},on:{click:t.onClickDelete}},[t._v(" "+t._s(t._f("t")("delete"))+" ")])])],1):t._e()},B=[],R=s("1909"),H=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=u["a"].instance,e}return Object(r["c"])(e,t),e.prototype.hidePopup=function(){this.$root.$emit("bv::hide::popover","mine-button-popover-"+this.parent.idx)},e.prototype.onClickEdit=function(){this.hidePopup(),this.$emit("edit",this.parent)},e.prototype.onClickDelete=function(){return Object(r["a"])(this,void 0,Promise,(function(){return Object(r["d"])(this,(function(t){return this.hidePopup(),this.$emit("delete",this.parent),[2]}))}))},e=Object(r["b"])([Object(a["b"])({components:{EllipsisVSvg:R["a"]},props:["parent"]})],e),e}(o["default"]),q=H,Y=q,J=Object(g["a"])(Y,N,B,!1,null,null,null),T=J.exports,G=s("93f2"),K=s("f273"),Q=s("c24e"),W=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=u["a"].instance,e.app=l["a"].instance,e.post=new p["d"],e.loaded=!1,e}return Object(r["c"])(e,t),Object.defineProperty(e.prototype,"createUrl",{get:function(){return this.app.postCreateUrl({categoryId:this.post.categoryId,subCategory:this.routeSubCategory,pageNo:this.routePageNo})},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"routePageNo",{get:function(){return this.$route.query.page?parseInt(this.$route.query.page):1},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"routeSubCategory",{get:function(){return this.$route.query.sc},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t,e,s,n,i;return Object(r["d"])(this,(function(r){switch(r.label){case 0:t=location.href.split("/"),e=t[t.length-1],s={idx:e},r.label=1;case 1:return r.trys.push([1,3,,4]),n=this,[4,this.api.postGet(s)];case 2:return n.post=r.sent(),this.$store.commit("currentCategory",this.post.categoryId),[3,4];case 3:return i=r.sent(),this.$app.error(i),[3,4];case 4:return this.loaded=!0,[2]}}))}))},Object.defineProperty(e.prototype,"toListPage",{get:function(){return"forum/"+this.post.categoryId+location.search},enumerable:!1,configurable:!0}),e.prototype.onVoted=function(){this.app.refreshProfile()},e.prototype.onCommentEdited=function(){this.app.refreshProfile()},e.prototype.onClickEdit=function(t){t.isPost?this.app.open("/forum/edit/"+t.idx+location.search):t.inEdit=!0},e.prototype.onClickDelete=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,s,n;return Object(r["d"])(this,(function(i){switch(i.label){case 0:return[4,c["a"].instance.confirm("Title","Are you sure you want to delete this "+(t.isPost?"post":"comment"))];case 1:if(e=i.sent(),!e)return[2];i.label=2;case 2:return i.trys.push([2,7,,8]),s=void 0,t.isPost?[4,this.api.postDelete(t.idx)]:[3,4];case 3:return s=i.sent(),this.app.open(this.toListPage),[3,6];case 4:return[4,this.api.commentDelete(t.idx)];case 5:s=i.sent(),i.label=6;case 6:return t=Object.assign(t,s),[3,8];case 7:return n=i.sent(),c["a"].instance.error(n),[3,8];case 8:return this.app.refreshProfile(),[2]}}))}))},e=Object(r["b"])([Object(a["b"])({components:{CommentForm:j,CommentMeta:S,VoteButtons:A,MineButtons:T,UserDisplayName:k["a"],ForumUserAvatar:E["a"],FileList:G["a"],Content:K["a"],ForumList:Q["default"]}})],e),e}(o["default"]),X=W,Z=X,tt=(s("49ff"),Object(g["a"])(Z,n,i,!1,null,null,null));e["default"]=tt.exports},"450c":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"pr-2 position-relative overflow-hidden pointer"},[s("camera-svg",{staticClass:"pointer",style:{width:t.defaultSize+"px",height:t.defaultSize+"px"}}),s("input",{staticClass:"h-100 top right position-absolute fs-lg opacity-0 pointer",attrs:{type:"file"},on:{change:t.onFileChange}})],1)},i=[],r=(s("d3b7"),s("9ab4")),o=s("2b0e"),a=s("2fe1"),c=s("9f3a"),l=s("190e"),u=s("11c8"),p=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=35,e.api=c["a"].instance,e}return Object(r["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size)},e.prototype.onFileChange=function(t){var e,s;return Object(r["a"])(this,void 0,Promise,(function(){var n,i,o;return Object(r["d"])(this,(function(r){switch(r.label){case 0:if(!this.api._user.loggedIn)return l["b"].instance.error("error_login_first"),[2];if(null===t.target.files||0===(null===(s=null===(e=t.target)||void 0===e?void 0:e.files)||void 0===s?void 0:s.length))return[2];n=t.target.files[0],r.label=1;case 1:return r.trys.push([1,3,,4]),[4,this.api.fileUpload(n,{},this.onProgress)];case 2:return i=r.sent(),this.$emit("success",i),[3,4];case 3:return o=r.sent(),l["b"].instance.error(o),[3,4];case 4:return[2]}}))}))},e.prototype.onProgress=function(t){this.$emit("progress",t)},e=Object(r["b"])([Object(a["b"])({props:["size"],components:{CameraSvg:u["a"]}})],e),e}(o["default"]),d=p,m=d,f=s("2877"),b=Object(f["a"])(m,n,i,!1,null,null,null);e["a"]=b.exports},"49ff":function(t,e,s){"use strict";s("c657")},"71b8":function(t,e,s){"use strict";s("c188")},"85bc":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512"}},[s("path",{attrs:{d:"M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"}})])},i=[],r=s("2877"),o={},a=Object(r["a"])(o,n,i,!1,null,null,null);e["a"]=a.exports},"93f2":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",t._l(t.post.files,(function(t){return s("div",{key:t.idx},[s("img",{staticClass:"mw-100",attrs:{src:t.url}})])})),0)},i=[],r=s("9ab4"),o=s("3fdf"),a=s("2b0e"),c=s("1b40"),l=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(r["c"])(e,t),Object(r["b"])([Object(c["b"])({default:function(){return new o["d"]}})],e.prototype,"post",void 0),e=Object(r["b"])([Object(c["a"])({})],e),e}(a["default"]),u=l,p=u,d=s("2877"),m=Object(d["a"])(p,n,i,!1,null,null,null);e["a"]=m.exports},"9b55":function(t,e,s){"use strict";s("2690")},c188:function(t,e,s){},c657:function(t,e,s){},f273:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.parent.content?s("div",{staticClass:"content"},[t._v(t._s(t.parent.content))]):t._e()},i=[],r=s("9ab4"),o=s("2b0e"),a=s("2fe1"),c=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(r["c"])(e,t),e=Object(r["b"])([Object(a["b"])({props:["parent"]})],e),e}(o["default"]),l=c,u=l,p=(s("9b55"),s("2877")),d=Object(p["a"])(u,n,i,!1,null,"0d53883e",null);e["a"]=d.exports},f297:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{},[s("div",{staticClass:"m-0 row"},t._l(t.post.files,(function(e){return s("div",{key:e.idx,staticClass:"position-relative p-1 col-3",staticStyle:{height:"150px"}},[s("FileEdit",{attrs:{file:e},on:{delete:t.onClickDelete}})],1)})),0)])},i=[],r=(s("d3b7"),s("c740"),s("a434"),s("9ab4")),o=s("2b0e"),a=s("2fe1"),c=s("1b40"),l=s("9f3a"),u=s("190e"),p=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"h-100 file-edit"},[s("div",{staticClass:"trash",on:{click:function(e){return t.$emit("delete",t.file)}}},[s("trash-svg")],1),s("img",{staticClass:"h-100",attrs:{src:t.file.url,alt:t.file.name}})])},d=[],m=s("85bc"),f=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(r["c"])(e,t),Object(r["b"])([Object(c["b"])()],e.prototype,"file",void 0),e=Object(r["b"])([Object(a["b"])({components:{TrashSvg:m["a"]}})],e),e}(o["default"]),b=f,h=b,v=(s("71b8"),s("2877")),_=Object(v["a"])(h,p,d,!1,null,"ce21229a",null),C=_.exports,y=s("d661"),g=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.api=l["a"].instance,e}return Object(r["c"])(e,t),e.prototype.onClickDelete=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,s;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,u["b"].instance.confirm("File Delete","Are you sure you want to delete this file?")];case 1:if(e=n.sent(),!e)return[2];n.label=2;case 2:return n.trys.push([2,4,,5]),[4,this.api.fileDelete(t.idx)];case 3:return n.sent(),this.onFileDelete(t.idx),this.$emit("deleted",t.idx),[3,5];case 4:return s=n.sent(),u["b"].instance.error(s),[3,5];case 5:return[2]}}))}))},e.prototype.onFileDelete=function(t){var e=this.post.files.findIndex((function(e){return e.idx==t}));console.log("index; ",e),this.post.files.splice(e,1),this.post.fileIdxes=Object(y["c"])(this.post.fileIdxes,t)},Object(r["b"])([Object(c["b"])()],e.prototype,"post",void 0),e=Object(r["b"])([Object(a["b"])({components:{FileEdit:C}})],e),e}(o["default"]),x=g,j=x,O=Object(v["a"])(j,n,i,!1,null,null,null);e["a"]=O.exports}}]);
//# sourceMappingURL=chunk-14a735e5.428a6602.js.map