(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-8d94e650"],{"2a99":function(t,s,e){"use strict";var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"d-flex"},[e("div",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]),t.parent&&t.parent.idx?e("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[e("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},o=[],n=e("9ab4"),r=e("2b0e"),i=e("2fe1"),l=e("f873"),c=function(t){function s(){var s=null!==t&&t.apply(this,arguments)||this;return s.id="displayname-popover-",s}return Object(n["c"])(s,t),s.prototype.mounted=function(){this.id+=this.parent.idx},s=Object(n["b"])([Object(i["a"])({props:["parent"],components:{UserMenu:l["a"]}})],s),s}(r["a"]),p=c,u=p,d=e("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);s["a"]=m.exports},3181:function(t,s,e){"use strict";var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"post-meta text-truncate"},[t.showName?e("user-displayname",{staticClass:"mr-2 font-weight-bold",attrs:{parent:t.post}}):t._e(),t.showName?t._e():e("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.post.idx))]),t.post.shortDate?e("span",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.shortDate)+" ")]):t._e(),t.post.noOfViews?e("span",{staticClass:"text-muted mr-2"},[t._v(" Views "+t._s(t.post.noOfViews)+" ")]):t._e()],1)},o=[],n=e("9ab4"),r=e("2b0e"),i=e("2fe1"),l=e("2a99"),c=function(t){function s(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(s,t),s=Object(n["b"])([Object(i["a"])({props:["post","showName"],components:{UserDisplayname:l["a"]}})],s),s}(r["a"]),p=c,u=p,d=e("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);s["a"]=m.exports},"82da":function(t,s,e){"use strict";var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"d-flex"},[e("b-avatar",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id,src:t.parent.user.src,size:t.defaultSize+"em"}}),t.parent&&t.parent.idx?e("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[e("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},o=[],n=e("9ab4"),r=e("2b0e"),i=e("2fe1"),l=e("f873"),c=function(t){function s(){var s=null!==t&&t.apply(this,arguments)||this;return s.defaultSize=3,s.src="",s.id="user-avatar-popover-",s}return Object(n["c"])(s,t),s.prototype.mounted=function(){this.size&&(this.defaultSize=this.size),this.id+=this.parent.idx},s=Object(n["b"])([Object(i["a"])({props:["parent","size"],components:{UserMenu:l["a"]}})],s),s}(r["a"]),p=c,u=p,d=e("2877"),m=Object(d["a"])(u,a,o,!1,null,null,null);s["a"]=m.exports},e907:function(t,s,e){"use strict";e.r(s);var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("section",{staticClass:"post-list-page",attrs:{"data-cy":"post-list-page"}},[e("div",{staticClass:"d-flex align-items-center"},[e("div",[t.options.category?e("div",[t._v(" Category: "),e("span",{staticClass:"text-uppercase"},[t._v(t._s(t.category))])]):t._e(),t._v(" No of posts: "+t._s(t.total)+" ")]),e("span",{staticClass:"flex-grow-1"}),e("router-link",{staticClass:"btn btn-success",attrs:{"data-cy":"post-create-button",to:"/edit/"+t.category}},[t._v(" "+t._s(t._f("t")("Create"))+" ")])],1),t.posts.length?e("div",{staticClass:"mt-3"},t._l(t.posts,(function(t,s){return e("post-title-meta",{key:t.idx,staticClass:"m-2 p-2 bg-light rounded",attrs:{post:t,"data-cy":"post-titlemeta-"+s}})})),1):t._e(),t.posts.length||t.loadingPosts?t._e():e("div",[t._v("No posts ..")]),t.loadingPosts?e("div",{staticClass:"p-3 text-center rounded"},[e("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" Loading Posts ... ")],1):t._e(),e("div",{staticClass:"d-flex mt-3 justify-content-center w-100"},[e("div",{staticClass:"overflow-auto"},[e("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(s){t.currentPage=s},expression:"currentPage"}})],1)])])},o=[],n=(e("d3b7"),e("9ab4")),r=e("2b0e"),i=e("2fe1"),l=e("d68b"),c=function(){var t=this,s=t.$createElement,e=t._self._c||s;return t.post?e("article",{staticClass:"post-preview d-flex"},[e("user-avatar",{attrs:{parent:t.post}}),e("div",{staticClass:"ml-2 d-flex w-100"},[e("div",{staticClass:"w-100"},[e("router-link",{attrs:{to:t.post.relativeUrl||"/"+t.post.idx}},[e("span",[t._v("No. "+t._s(t.post.idx)+" - ")]),e("span",{attrs:{"data-cy":"post-title"}},[t._v(t._s(t.post.title||"no title"))]),t.post.noOfComments?e("span",{staticClass:"ml-1"},[t._v(" ("+t._s(t.post.noOfComments)+") ")]):t._e()]),e("div",[t.post.comments.length?e("i",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.comments[0].user.displayName)+': "'+t._s(t.post.comments[0].content)+'" ')]):t._e(),t.post.comments.length?t._e():e("i",{staticClass:"text-muted"},[t._v(" No comments yet .. ")])])],1),e("post-meta-component",{staticClass:"d-block",staticStyle:{width:"120px"},attrs:{showName:!0,post:t.post}})],1)],1):t._e()},p=[],u=e("3181"),d=e("82da"),m=function(t){function s(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(s,t),s=Object(n["b"])([Object(i["a"])({props:["post"],components:{PostMetaComponent:u["a"],UserAvatar:d["a"]}})],s),s}(r["a"]),h=m,f=h,b=e("2877"),v=Object(b["a"])(f,c,p,!1,null,null,null),g=v.exports,_=function(t){function s(){var s=null!==t&&t.apply(this,arguments)||this;return s.posts=[],s.app=l["a"].instance,s.loadingPosts=!1,s.total=0,s.limit=5,s.noOfPages=10,s.currentPage="1",s.options={},s}return Object(n["c"])(s,t),Object.defineProperty(s.prototype,"category",{get:function(){return this.$route.params.category},enumerable:!1,configurable:!0}),s.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},s.prototype.onPageChanged=function(t){console.log("page changed",t),this.options.page=t,this.loadPosts()},s.prototype.mounted=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,s;return Object(n["d"])(this,(function(e){switch(e.label){case 0:console.log("PostList::mounted(); ",this.$route.params),this.options.categoryIdx=this.$route.params.category,this.options.userIdx=this.$route.params.userIdx,this.options.limit=this.limit,this.options.page=1,this.options.comments=1,this.loadPosts(),this.currentPage=this.$route.query.page,e.label=1;case 1:return e.trys.push([1,3,,4]),t=this,[4,this.app.api.postCount(this.options)];case 2:return t.total=e.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,4];case 3:return s=e.sent(),this.app.error(s),[3,4];case 4:return[2]}}))}))},s.prototype.loadPosts=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,s;return Object(n["d"])(this,(function(e){switch(e.label){case 0:console.log(this.options),this.loadingPosts=!0,e.label=1;case 1:return e.trys.push([1,3,,4]),t=this,[4,this.app.api.postSearch(this.options)];case 2:return t.posts=e.sent(),console.log(this.posts),this.loadingPosts=!1,[3,4];case 3:return s=e.sent(),this.app.error(s),this.loadingPosts=!1,[3,4];case 4:return[2]}}))}))},s=Object(n["b"])([Object(i["a"])({components:{PostTitleMeta:g}})],s),s}(r["a"]),x=_,C=x,y=Object(b["a"])(C,a,o,!1,null,null,null);s["default"]=y.exports},f873:function(t,s,e){"use strict";var a=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"user-menu"},[e("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/profile/"+t.user.idx}},[t._v(" @Todo: See user profile ")]),e("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/posts/"+t.user.idx}},[t._v(" See user posts ")]),e("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/comments/"+t.user.idx}},[t._v(" See user comments ")]),e("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/message/"+t.user.idx}},[t._v(" @Todo: Send message ")])],1)},o=[],n=e("9ab4"),r=e("2b0e"),i=e("2fe1"),l=function(t){function s(){return null!==t&&t.apply(this,arguments)||this}return Object(n["c"])(s,t),s=Object(n["b"])([Object(i["a"])({props:["user"]})],s),s}(r["a"]),c=l,p=c,u=e("2877"),d=Object(u["a"])(p,a,o,!1,null,null,null);s["a"]=d.exports}}]);
//# sourceMappingURL=chunk-8d94e650.479c722f.js.map