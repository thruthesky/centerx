(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-12ee42b0"],{"2a99":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[t.id?s("div",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id}},[t._v(" "+t._s(t.parent.user.displayName)+" ")]):t._e(),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},r=[],a=s("9ab4"),o=s("2b0e"),i=s("2fe1"),c=s("f873"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.id="",e}return Object(a["c"])(e,t),e.prototype.mounted=function(){this.id="displayname-popover-"+this.parent.idx},e=Object(a["b"])([Object(i["b"])({props:["parent"],components:{UserMenu:c["a"]}})],e),e}(o["default"]),u=l,p=u,b=s("2877"),d=Object(b["a"])(p,n,r,!1,null,null,null);e["a"]=d.exports},3181:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"post-meta text-truncate"},[t.showName?s("user-displayname",{staticClass:"mr-2 font-weight-bold",attrs:{parent:t.post}}):t._e(),t.showName?t._e():s("span",{staticClass:"mr-2"},[t._v("No. "+t._s(t.post.idx))]),t.post.shortDate?s("span",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.shortDate)+" ")]):t._e(),t.post.noOfViews?s("span",{staticClass:"text-muted mr-2"},[t._v(" Views "+t._s(t.post.noOfViews)+" ")]):t._e()],1)},r=[],a=s("9ab4"),o=s("2b0e"),i=s("2fe1"),c=s("2a99"),l=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(a["c"])(e,t),e=Object(a["b"])([Object(i["b"])({props:["post","showName"],components:{UserDisplayname:c["a"]}})],e),e}(o["default"]),u=l,p=u,b=s("2877"),d=Object(b["a"])(p,n,r,!1,null,null,null);e["a"]=d.exports},"82da":function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"d-flex"},[s("b-avatar",{staticClass:"pointer",attrs:{tabindex:"0",id:t.id,src:t.parent.user.src,size:t.defaultSize+"em"}}),t.parent&&t.parent.idx?s("b-popover",{ref:"popover",attrs:{placement:"bottomright",target:t.id,triggers:"click blur"}},[s("user-menu",{attrs:{user:t.parent.user}})],1):t._e()],1)},r=[],a=s("9ab4"),o=s("2b0e"),i=s("2fe1"),c=s("f873"),l=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.defaultSize=3,e.src="",e.id="",e}return Object(a["c"])(e,t),e.prototype.mounted=function(){this.size&&(this.defaultSize=this.size),this.id="user-avatar-popover-"+this.parent.idx},e=Object(a["b"])([Object(i["b"])({props:["parent","size"],components:{UserMenu:c["a"]}})],e),e}(o["default"]),u=l,p=u,b=s("2877"),d=Object(b["a"])(p,n,r,!1,null,null,null);e["a"]=d.exports},e907:function(t,e,s){"use strict";s.r(e);var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"post-list-page",attrs:{"data-cy":"post-list-page"}},[s("div",{staticClass:"d-flex"},[s("advertisement-square-banners",{staticClass:"mb-2"})],1),s("advertisement-line-banner",{staticClass:"mb-2"}),s("div",{staticClass:"d-flex align-items-center"},[s("div",[t.options.category?s("div",[t._v(" "+t._s(t._f("t")("category"))+": "),s("span",{staticClass:"text-uppercase"},[t._v(t._s(t.category))])]):t._e(),t._v(" "+t._s(t._f("t")("no_of_posts"))+": "+t._s(t.total)+" ")]),s("span",{staticClass:"flex-grow-1"}),s("router-link",{staticClass:"btn btn-success",attrs:{"data-cy":"post-create-button",to:t.createLink}},[t._v(" "+t._s(t._f("t")("create"))+" ")])],1),t.posts.length?s("div",{staticClass:"mt-3"},t._l(t.posts,(function(t,e){return s("post-title-meta",{key:t.idx,staticClass:"m-2 p-2 bg-light rounded",attrs:{post:t,"data-cy":"post-titlemeta-"+e}})})),1):t._e(),t.posts.length||t.loadingPosts?t._e():s("div",{staticClass:"mt-3 p-2 text-center"},[t._v(" "+t._s(t._f("t")("no_posts"))+" ")]),t.loadingPosts?s("div",{staticClass:"p-3 text-center rounded"},[s("b-spinner",{staticClass:"mx-2",attrs:{small:"",type:"grow",variant:"info"}}),t._v(" "+t._s(t._f("t")("loading_post"))+" ")],1):t._e(),t.posts.length?s("div",{staticClass:"d-flex mt-3 justify-content-center w-100"},[s("div",{staticClass:"overflow-auto"},[s("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)]):t._e()],1)},r=[],a=(s("a15b"),s("d3b7"),s("9ab4")),o=s("d68b"),i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.post?s("article",{staticClass:"post-preview d-flex"},[s("user-avatar",{attrs:{parent:t.post}}),s("div",{staticClass:"ml-2 d-flex w-100"},[s("div",{staticClass:"w-100"},[s("router-link",{attrs:{to:t.toPostView()}},[s("span",[t._v("No. "+t._s(t.post.idx)+" - ")]),s("span",{attrs:{"data-cy":"post-title"}},[t._v(t._s(t.post.title||"no title"))]),t.post.noOfComments?s("span",{staticClass:"ml-1"},[t._v(" ("+t._s(t.post.noOfComments)+") ")]):t._e()]),s("div",[t.post.comments.length?s("i",{staticClass:"text-muted"},[t._v(" "+t._s(t.post.comments[0].user.displayName)+': "'+t._s(t.post.comments[0].content)+'" ')]):t._e(),t.post.comments.length?t._e():s("i",{staticClass:"text-muted"},[t._v(" No comments yet .. ")])])],1),s("post-meta-component",{staticClass:"d-block",staticStyle:{width:"120px"},attrs:{showName:!0,post:t.post}})],1)],1):t._e()},c=[],l=(s("ac1f"),s("841c"),s("3181")),u=s("82da"),p=s("2b0e"),b=s("2fe1");"undefined"!==typeof Reflect&&Reflect.getMetadata;function d(t,e){void 0===e&&(e={});var s=e.deep,n=void 0!==s&&s,r=e.immediate,a=void 0!==r&&r;return Object(b["a"])((function(e,s){"object"!==typeof e.watch&&(e.watch=Object.create(null));var r=e.watch;"object"!==typeof r[t]||Array.isArray(r[t])?"undefined"===typeof r[t]&&(r[t]=[]):r[t]=[r[t]],r[t].push({handler:s,deep:n,immediate:a})}))}var f=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(a["c"])(e,t),e.prototype.toPostView=function(){return(this.post.relativeUrl||"/"+this.post.idx)+location.search},e=Object(a["b"])([Object(b["b"])({props:["post"],components:{PostMetaComponent:l["a"],UserAvatar:u["a"]}})],e),e}(p["default"]),h=f,m=h,g=s("2877"),v=Object(g["a"])(m,i,c,!1,null,null,null),y=v.exports,_=s("0613"),C=function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.banners.length?s("div",{staticClass:"d-flex w-100 pb-2 border-bottom"},t._l(t.banners,(function(e){return s("div",{key:e.idx,staticClass:"banner square pointer mr-1 col-3 p-0",on:{click:function(s){return t.onClick(e)}}},[s("img",{staticClass:"w-100 h-100",attrs:{src:e.bannerUrl}})])})),0):t._e()},O=[],x=s("9f3a"),j=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(a["c"])(e,t),Object.defineProperty(e.prototype,"banners",{get:function(){var t=_["a"].state.currentCategory;return _["a"].state.banners[t]&&_["a"].state.banners[t]["square"]||(t="global"),_["a"].state.banners[t]&&_["a"].state.banners[t]["square"]?_["a"].state.banners[t]["square"]:[]},enumerable:!1,configurable:!0}),e.prototype.onClick=function(t){x["a"].instance.openAdvertisement(t)},e=Object(a["b"])([Object(b["b"])({})],e),e}(p["default"]),P=j,k=P,w=Object(g["a"])(k,C,O,!1,null,null,null),$=w.exports,q=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"mb-4 banner line d-flex pointer border-bottom",on:{click:t.onClick}},[s("img",{attrs:{src:t.currentBanner.bannerUrl}}),s("div",{staticClass:"title"},[t._v(" "+t._s(t.currentBanner.title)+" ")])])},S=[],N=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.index=0,e}return Object(a["c"])(e,t),e.prototype.mounted=function(){this.rotate()},Object.defineProperty(e.prototype,"banners",{get:function(){var t=_["a"].state.currentCategory;return _["a"].state.banners[t]&&_["a"].state.banners[t]["line"]||(t="global"),_["a"].state.banners[t]&&_["a"].state.banners[t]["line"]?_["a"].state.banners[t]["line"]:[]},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"currentBanner",{get:function(){return this.banners.length?this.banners[this.index%this.banners.length]:{}},enumerable:!1,configurable:!0}),e.prototype.rotate=function(){var t=this;setInterval((function(){return t.index++}),7e3)},e.prototype.onClick=function(){x["a"].instance.openAdvertisement(this.currentBanner)},e=Object(a["b"])([Object(b["b"])({})],e),e}(p["default"]),E=N,z=E,A=Object(g["a"])(z,q,S,!1,null,null,null),U=A.exports,B=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=o["a"].instance,e.loadingPosts=!1,e.total=0,e.limit=5,e.noOfPages=10,e.currentPage="1",e.options={},e}return Object(a["c"])(e,t),Object.defineProperty(e.prototype,"category",{get:function(){return this.$route.params.category},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"subCategory",{get:function(){return this.$route.query.sc},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"posts",{get:function(){return _["a"].state.posts},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"createLink",{get:function(){var t=this.$route.query.page?parseInt(this.$route.query.page):1;return"/edit/"+this.category+this.linkGen(t)},enumerable:!1,configurable:!0}),e.prototype.linkGen=function(t){var e=[];return t>1&&e.push("page="+t),this.subCategory&&e.push("sc="+this.subCategory),e.length?"?"+e.join("&"):""},e.prototype.onPageChanged=function(t){this.options.page=t,this.loadPosts()},e.prototype.initPostList=function(){return Object(a["a"])(this,void 0,Promise,(function(){var t,e;return Object(a["d"])(this,(function(s){switch(s.label){case 0:_["a"].state.posts=[],this.options.categoryId=this.$route.params.category,this.options.userIdx=this.$route.params.userIdx,this.options.limit=this.limit,this.options.comments=1,this.$route.query.page?(this.currentPage=this.$route.query.page,this.options.page=this.currentPage):(this.currentPage="1",this.options.page=1),this.subCategory&&(this.options.subcategory=this.subCategory),s.label=1;case 1:return s.trys.push([1,3,,4]),t=this,[4,this.app.api.postCount(this.options)];case 2:return t.total=s.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,4];case 3:return e=s.sent(),this.app.error(e),[3,4];case 4:return[2]}}))}))},e.prototype.mounted=function(){return Object(a["a"])(this,void 0,Promise,(function(){return Object(a["d"])(this,(function(t){return this.initPostList(),this.loadPosts(),[2]}))}))},e.prototype.onQueryChange=function(t,e){console.log(t,e),this.initPostList(),this.loadPosts()},e.prototype.loadPosts=function(){return Object(a["a"])(this,void 0,Promise,(function(){var t,e;return Object(a["d"])(this,(function(s){switch(s.label){case 0:this.loadingPosts=!0,s.label=1;case 1:return s.trys.push([1,3,,4]),t=_["a"].state,[4,this.app.api.postSearch(this.options)];case 2:return t.posts=s.sent(),this.loadingPosts=!1,[3,4];case 3:return e=s.sent(),this.app.error(e),this.loadingPosts=!1,[3,4];case 4:return[2]}}))}))},Object(a["b"])([d("$route.query.sc")],e.prototype,"onQueryChange",null),e=Object(a["b"])([Object(b["b"])({components:{PostTitleMeta:y,AdvertisementSquareBanners:$,AdvertisementLineBanner:U}})],e),e}(p["default"]),L=B,M=L,I=Object(g["a"])(M,n,r,!1,null,null,null);e["default"]=I.exports},f873:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"user-menu"},[s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/profile/"+t.user.idx}},[t._v(" @Todo: See user profile ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/posts/"+t.user.idx}},[t._v(" See user posts ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/user/comments/"+t.user.idx}},[t._v(" See user comments ")]),s("router-link",{staticClass:"btn d-block text-left",attrs:{to:"/message/"+t.user.idx}},[t._v(" @Todo: Send message ")])],1)},r=[],a=s("9ab4"),o=s("2b0e"),i=s("2fe1"),c=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(a["c"])(e,t),e=Object(a["b"])([Object(i["b"])({props:["user"]})],e),e}(o["default"]),l=c,u=l,p=s("2877"),b=Object(p["a"])(u,n,r,!1,null,null,null);e["a"]=b.exports}}]);
//# sourceMappingURL=chunk-12ee42b0.bfed988b.js.map