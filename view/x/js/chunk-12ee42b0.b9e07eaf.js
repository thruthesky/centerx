(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-12ee42b0"],{"2a99":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("div",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},o=[],n=s("9ab4"),r=s("2b0e"),i=s("2fe1"),l=s("f873"),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.id="displayname-popover-",e}return Object(n["c"])(e,t),e.prototype.mounted=function(){this.id+=this.parent.idx},e=Object(n["b"])([Object(i["a"])({props:["parent"],components:{UserMenu:l["a"]}})],e),e}(r["a"]),p=c,u=p,d=s("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);e["a"]=m.exports},3181:function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"post-meta text-truncate"},[t.showName?s("user-displayname",{staticClass:"mr-2 font-weight-bold",attrs:{parent:t.post}}):t._e(),t.showName?t._e():s("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.post.idx))]),t.post.shortDate?s("span",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.shortDate)+" ")]):t._e(),t.post.noOfViews?s("span",{staticClass:"text-muted mr-2"},[t._v(" Views "+t._s(t.post.noOfViews)+" ")]):t._e()],1)},o=[],n=s("9ab4"),r=s("2b0e"),i=s("2fe1"),l=s("2a99"),c=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(i["a"])({props:["post","showName"],components:{UserDisplayname:l["a"]}})],e),e}(r["a"]),p=c,u=p,d=s("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);e["a"]=m.exports},"82da":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("b-avatar",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id,src:t.parent.user.src,size:t.defaultSize+"em"}}),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},o=[],n=s("9ab4"),r=s("2b0e"),i=s("2fe1"),l=s("f873"),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=3,e.src="",e.id="user-avatar-popover-",e}return Object(n["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size),this.id+=this.parent.idx},e=Object(n["b"])([Object(i["a"])({props:["parent","size"],components:{UserMenu:l["a"]}})],e),e}(r["a"]),p=c,u=p,d=s("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);e["a"]=m.exports},e907:function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"post-list-page",attrs:{"data-cy":"post-list-page"}},[s("div",{staticClass:"d-flex align-items-center"},[s("div",[t.options.category?s("div",[t._v(" Category: "),s("span",{staticClass:"text-uppercase"},[t._v(t._s(t.category))])]):t._e(),t._v(" No of posts: "+t._s(t.total)+" ")]),s("span",{staticClass:"flex-grow-1"}),s("router-link",{staticClass:"btn btn-success",attrs:{"data-cy":"post-create-button",to:"/edit/"+t.category}},[t._v(" "+t._s(t._f("t")("Create"))+" ")])],1),t.posts.length?s("div",{staticClass:"mt-3"},t._l(t.posts,(function(t,e){return s("post-title-meta",{key:t.idx,staticClass:"m-2 p-2 bg-light rounded",attrs:{post:t,"data-cy":"post-titlemeta-"+e}})})),1):t._e(),t.posts.length||t.loadingPosts?t._e():s("div",[t._v("No posts ..")]),t.loadingPosts?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Loading Posts ... ")],1):t._e(),s("div",{staticClass:"d-flex mt-3 justify-content-center w-100"},[s("div",{staticClass:"overflow-auto"},[s("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])])},o=[],n=(s("d3b7"),s("9ab4")),r=s("2b0e"),i=s("2fe1"),l=s("d68b"),c=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.post?s("article",{staticClass:"post-preview d-flex"},[s("user-avatar",{attrs:{parent:t.post}}),s("div",{staticClass:"ml-2 d-flex w-100"},[s("div",{staticClass:"w-100"},[s("router-link",{attrs:{to:t.post.relativeUrl||"/"+t.post.idx}},[s("span",[t._v("No. "+t._s(t.post.idx)+" - ")]),s("span",{attrs:{"data-cy":"post-title"}},[t._v(t._s(t.post.title||"no title"))]),t.post.noOfComments?s("span",{staticClass:"ml-1"},[t._v(" ("+t._s(t.post.noOfComments)+") ")]):t._e()]),s("div",[t.post.comments.length?s("i",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.comments[0].user.displayName)+': "'+t._s(t.post.comments[0].content)+'" ')]):t._e(),t.post.comments.length?t._e():s("i",{staticClass:"text-muted"},[t._v(" No comments yet .. ")])])],1),s("post-meta-component",{staticClass:"d-block",staticStyle:{width:"120px"},attrs:{showName:!0,post:t.post}})],1)],1):t._e()},p=[],u=s("3181"),d=s("82da"),m=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(i["a"])({props:["post"],components:{PostMetaComponent:u["a"],UserAvatar:d["a"]}})],e),e}(r["a"]),h=m,f=h,b=s("2877"),v=Object(b["a"])(f,c,p,!1,null,null,null),g=v.exports,_=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.posts=[],e.app=l["a"].instance,e.loadingPosts=!1,e.total=0,e.limit=5,e.noOfPages=10,e.currentPage="1",e.options={},e}return Object(n["c"])(e,t),Object.defineProperty(e.prototype,"category",{get:function(){return this.$route.params.category},enumerable:!1,configurable:!0}),e.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},e.prototype.onPageChanged=function(t){console.log("page changed",t),this.options.page=t,this.loadPosts()},e.prototype.mounted=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,e;return Object(n["d"])(this,(function(s){switch(s.label){case 0:console.log("PostList::mounted(); ",this.$route.params),this.options.categoryIdx=this.$route.params.category,this.options.userIdx=this.$route.params.userIdx,this.options.limit=this.limit,this.options.page=1,this.options.comments=1,this.loadPosts(),this.currentPage=this.$route.query.page,s.label=1;case 1:return s.trys.push([1,3,,4]),t=this,[4,this.app.api.postCount(this.options)];case 2:return t.total=s.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,4];case 3:return e=s.sent(),this.app.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.loadPosts=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,e;return Object(n["d"])(this,(function(s){switch(s.label){case 0:console.log(this.options),this.loadingPosts=!0,s.label=1;case 1:return s.trys.push([1,3,,4]),t=this,[4,this.app.api.postSearch(this.options)];case 2:return t.posts=s.sent(),console.log(this.posts),this.loadingPosts=!1,[3,4];case 3:return e=s.sent(),this.app.error(e),this.loadingPosts=!1,[3,4];case 4:return[2]}}))}))},e=Object(n["b"])([Object(i["a"])({components:{PostTitleMeta:g}})],e),e}(r["a"]),x=_,C=x,y=Object(b["a"])(C,a,o,!1,null,null,null);e["default"]=y.exports},f873:function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"user-menu"},[s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/profile/"+t.user.idx}},[t._v(" @Todo: See user profile ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/posts/"+t.user.idx}},[t._v(" See user posts ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/comments/"+t.user.idx}},[t._v(" See user comments ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/message/"+t.user.idx}},[t._v(" @Todo: Send message ")])],1)},o=[],n=s("9ab4"),r=s("2b0e"),i=s("2fe1"),l=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(e,t),e=Object(n["b"])([Object(i["a"])({props:["user"]})],e),e}(r["a"]),c=l,p=c,u=s("2877"),d=Object(u["a"])(p,a,o,!1,null,null,null);e["a"]=d.exports}}]);
//# sourceMappingURL=chunk-12ee42b0.b9e07eaf.js.map