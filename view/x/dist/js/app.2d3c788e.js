(function(e){function t(t){for(var r,i,o=t[0],u=t[1],c=t[2],l=0,d=[];l<o.length;l++)i=o[l],Object.prototype.hasOwnProperty.call(a,i)&&a[i]&&d.push(a[i][0]),a[i]=0;for(r in u)Object.prototype.hasOwnProperty.call(u,r)&&(e[r]=u[r]);h&&h(t);while(d.length)d.shift()();return s.push.apply(s,c||[]),n()}function n(){for(var e,t=0;t<s.length;t++){for(var n=s[t],r=!0,i=1;i<n.length;i++){var u=n[i];0!==a[u]&&(r=!1)}r&&(s.splice(t--,1),e=o(o.s=n[0]))}return e}var r={},a={app:0},s=[];function i(e){return o.p+"js/"+({about:"about"}[e]||e)+"."+{about:"7ba678c9","chunk-13cff186":"461b7757","chunk-171ddf21":"a24da930","chunk-241b90b0":"b7756afc","chunk-25ceb68c":"19b0d999","chunk-2d0c1282":"fd08eda1","chunk-2d0cf888":"13ccf1c6","chunk-2d0d6d35":"55b5dee7","chunk-7d8b0498":"8aba1d5e","chunk-99768f36":"475b7ac7"}[e]+".js"}function o(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,o),n.l=!0,n.exports}o.e=function(e){var t=[],n=a[e];if(0!==n)if(n)t.push(n[2]);else{var r=new Promise((function(t,r){n=a[e]=[t,r]}));t.push(n[2]=r);var s,u=document.createElement("script");u.charset="utf-8",u.timeout=120,o.nc&&u.setAttribute("nonce",o.nc),u.src=i(e);var c=new Error;s=function(t){u.onerror=u.onload=null,clearTimeout(l);var n=a[e];if(0!==n){if(n){var r=t&&("load"===t.type?"missing":t.type),s=t&&t.target&&t.target.src;c.message="Loading chunk "+e+" failed.\n("+r+": "+s+")",c.name="ChunkLoadError",c.type=r,c.request=s,n[1](c)}a[e]=void 0}};var l=setTimeout((function(){s({type:"timeout",target:u})}),12e4);u.onerror=u.onload=s,document.head.appendChild(u)}return Promise.all(t)},o.m=e,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(n,r,function(t){return e[t]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/view/x/dist/",o.oe=function(e){throw console.error(e),e};var u=window["webpackJsonp"]=window["webpackJsonp"]||[],c=u.push.bind(u);u.push=t,u=u.slice();for(var l=0;l<u.length;l++)t(u[l]);var h=c;s.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("cd49")},"0613":function(e,t,n){"use strict";var r=n("2b0e"),a=n("2f62"),s={user:null,countries:void 0};r["a"].use(a["a"]),t["a"]=new a["a"].Store({state:s,mutations:{},actions:{},modules:{}})},8594:function(e,t,n){},aeda:function(e,t,n){"use strict";n.d(t,"g",(function(){return o})),n.d(t,"e",(function(){return u})),n.d(t,"b",(function(){return c})),n.d(t,"f",(function(){return l})),n.d(t,"c",(function(){return h})),n.d(t,"d",(function(){return d})),n.d(t,"a",(function(){return f}));var r=n("262e"),a=n("2caf"),s=n("d4ec"),i=n("bee2"),o=(n("b0c0"),n("ac1f"),n("1276"),n("d81d"),n("4de4"),n("c740"),n("a434"),n("a4d3"),n("e01a"),function(){function e(){Object(s["a"])(this,e),this.idx="",this.sessionId="",this.email="",this.name="",this.nickname="",this.photoUrl=""}return Object(i["a"])(e,[{key:"displayName",get:function(){if(this.name)return this.name;if(this.nickname)return this.nickname;var e;if(this.email&&(e=this.email.split("@").shift()),!e)return this.idx+"xxx";var t=e.substring(0,e.length-3);return t+"xxx"}},{key:"fromMap",value:function(e){return this.idx=e.idx,this.email=e.email,this.sessionId=e.sessionId,this.name=e.name,this.nickname=e.nickname,this.photoUrl=e.photoUrl,this}}]),e}()),u=function e(){Object(s["a"])(this,e),this.idx="",this.title="",this.content="",this.categoryId="",this.files=""},c=function e(){Object(s["a"])(this,e),this.idx="",this.content="",this.rootIdx="",this.parentIdx="",this.files=""},l=function(){function e(){Object(s["a"])(this,e),this.idx="",this.url="",this.relativeUrl="",this.path="",this.title="",this.content="",this.categoryIdx="",this.userIdx="",this.user={},this.comments=[],this.shortDate="",this.noOfComments="",this.noOfViews="",this.files=[],this.Y=0,this.N=0}return Object(i["a"])(e,[{key:"fromMap",value:function(e){return this.idx=e.idx,this.url=e.url,this.relativeUrl=e.relativeUrl,this.path=e.path,this.title=e.title,this.content=e.content,this.userIdx=e.userIdx,this.shortDate=e.shortDate,this.noOfComments=e.noOfComments,this.noOfViews=e.noOfViews,this.Y=e.Y,this.N=e.N,this.files=e.files.map((function(e){return(new d).fromMap(e)})),this.user=(new o).fromMap(e.user),this.comments=e.comments.filter((function(e){return"0"==e.deletedAt})).map((function(e){return(new h).fromMap(e)})),this}},{key:"insertComment",value:function(e){if(e.parentIdx==this.idx)this.comments.push(e);else{var t=this.comments.findIndex((function(t){return t.idx==e.parentIdx}));this.comments.splice(t+1,0,e)}}},{key:"deleteComment",value:function(e){var t=this.comments.findIndex((function(t){return t.idx==e}));this.comments.splice(t,1)}}]),e}(),h=function(){function e(){Object(s["a"])(this,e),this.idx="",this.content="",this.userIdx="",this.rootIdx="",this.parentIdx="",this.deletedAt="",this.depth="",this.shortDate="",this.Y=0,this.N=0,this.files=[],this.inEdit=!1,this.inReply=!1}return Object(i["a"])(e,[{key:"fromMap",value:function(e){return this.idx=e.idx,this.content=e.content,this.userIdx=e.userIdx,this.rootIdx=e.rootIdx,this.parentIdx=e.parentIdx,this.depth=e.depth,this.deletedAt=e.deletedAt,this.shortDate=e.shortDate,this.Y=e.Y,this.N=e.N,this.files=e.files.map((function(e){return(new d).fromMap(e)})),this.user=(new o).fromMap(e.user),this}}]),e}(),d=function(){function e(){Object(s["a"])(this,e),this.idx="",this.url="",this.name="",this.path="",this.size="",this.code="",this.type="",this.entity="",this.userIdx="",this.taxonomy="",this.createdAt="",this.updatedAt=""}return Object(i["a"])(e,[{key:"fromMap",value:function(e){return this.idx=e.idx,this.url=e.url,this.name=e.name,this.path=e.path,this.size=e.size,this.code=e.code,this.type=e.type,this.entity=e.entity,this.userIdx=e.userIdx,this.taxonomy=e.taxonomy,this.createdAt=e.createdAt,this.updatedAt=e.updatedAt,this}}]),e}(),p=function(){function e(){Object(s["a"])(this,e),this.idx="",this.userIdx="",this.id="",this.title="",this.description="",this.domain=""}return Object(i["a"])(e,[{key:"fromMap",value:function(e){return this.idx=e.idx,this.userIdx=e.userIdx,this.id=e.id,this.title=e.title,this.description=e.description,this.domain=e.domain,this}}]),e}(),f=function(e){Object(r["a"])(n,e);var t=Object(a["a"])(n);function n(){return Object(s["a"])(this,n),t.apply(this,arguments)}return n}(p)},c160:function(e,t,n){"use strict";n.d(t,"a",(function(){return d}));var r=n("1da1"),a=n("d4ec"),s=n("bee2"),i=(n("d81d"),n("ac1f"),n("1276"),n("96cf"),n("bc3a")),o=n.n(i),u=n("0613"),c=n("aeda"),l=n("a78e"),h=n.n(l),d=function(){function e(){Object(a["a"])(this,e),this.sessionId=null,console.log("ApiService::contructor()"),this.initUserAuth()}return Object(s["a"])(e,[{key:"user",get:function(){return u["a"].state.user},set:function(e){u["a"].state.user=e}},{key:"loggedIn",get:function(){return!!this.user&&!!this.user.idx}},{key:"notLoggedIn",get:function(){return!this.loggedIn}},{key:"initUserAuth",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.sessionId=this.getUserSessionId(),e.next=3,this.refreshLoginUserProfile();case 3:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},{key:"refreshLoginUserProfile",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(null!==this.sessionId){e.next=2;break}return e.abrupt("return");case 2:return e.next=4,this.request("user.profile");case 4:return t=e.sent,this.user=(new c["g"]).fromMap(t),this.setUserSessionId(this.user.sessionId),e.abrupt("return",this.user);case 8:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},{key:"setUserSessionId",value:function(e){localStorage.setItem("sessionId",e),this.sessionId=e}},{key:"deleteUserSessionId",value:function(){localStorage.removeItem("sessionId")}},{key:"getUserSessionId",value:function(){var e=localStorage.getItem("sessionId");return this.sessionId=e,e}},{key:"register",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("user.register",t);case 2:return n=e.sent,this.user=(new c["g"]).fromMap(n),this.setUserSessionId(this.user.sessionId),e.abrupt("return",this.user);case 6:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"login",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("user.login",t);case 2:return n=e.sent,this.user=(new c["g"]).fromMap(n),this.setUserSessionId(this.user.sessionId),e.abrupt("return",this.user);case 6:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"logout",value:function(){this.deleteUserSessionId(),this.sessionId=null,this.user=null}},{key:"request",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n,r,a=arguments;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n=a.length>1&&void 0!==a[1]?a[1]:{},n.route=t,this.sessionId&&(n.sessionId=this.sessionId),e.next=5,o.a.post("https://cherry.philov.com/index.php",n);case 5:if(r=e.sent,"string"!==typeof r.data){e.next=11;break}throw console.error(r),"error_error_string_from_php_backend";case 11:if(r.data.response){e.next=15;break}throw"error_malformed_response_from_php_backend";case 15:if("string"!==typeof r.data.response||0!==r.data.response.indexOf("error_")){e.next=17;break}throw r.data.response;case 17:return e.abrupt("return",r.data.response);case 18:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"version",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("app.version");case 2:return t=e.sent,e.abrupt("return",t.version);case 4:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},{key:"postGet",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("post.get",t);case 2:return n=e.sent,e.abrupt("return",(new c["f"]).fromMap(n));case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"postSearch",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("post.search",t);case 2:return n=e.sent,e.abrupt("return",n.map((function(e){return(new c["f"]).fromMap(e)})));case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"postEdit",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n,r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n="post.create",t.idx&&(n="post.update"),e.next=4,this.request(n,t);case 4:return r=e.sent,e.abrupt("return",(new c["f"]).fromMap(r));case 6:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"postDelete",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.t0=new c["f"],e.next=3,this.request("post.delete",{idx:t});case 3:return e.t1=e.sent,e.abrupt("return",e.t0.fromMap.call(e.t0,e.t1));case 5:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"commentSearch",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return t.userIdx&&(t.where="userIdx=".concat(t.userIdx)),e.next=3,this.request("comment.search",t);case 3:return n=e.sent,e.abrupt("return",n.map((function(e){return(new c["c"]).fromMap(e)})));case 5:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"commentEdit",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n,r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return n="comment.create",t.idx&&(n="comment.update"),e.next=4,this.request(n,t);case 4:return r=e.sent,e.abrupt("return",(new c["c"]).fromMap(r));case 6:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"commentDelete",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("comment.delete",{idx:t});case 2:return n=e.sent,e.abrupt("return",(new c["c"]).fromMap(n));case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"vote",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("post.vote",t);case 2:return n=e.sent,e.abrupt("return",n);case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"fileUpload",value:function(e,t,n,r,a){var s=new FormData;for(var i in s.append("route","file.upload"),this.sessionId&&s.append("sessionId",this.sessionId),t)s.append(i,t[i]);s.append("userfile",e);var u={onUploadProgress:function(e){var t=Math.round(100*e.loaded/e.total);a&&a(t)}};o.a.post("https://cherry.philov.com/index.php",s,u).then((function(e){if("string"===typeof e.data.response&&0===e.data.response.indexOf("error_"))r(e.data.response);else{var t=(new c["d"]).fromMap(e.data.response);n(t)}})).catch(r)}},{key:"fileDelete",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("file.delete",{idx:t});case 2:return n=e.sent,e.abrupt("return",n.idx);case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"isMine",value:function(e){var t;return!this.notLoggedIn&&e.userIdx===(null===(t=this.user)||void 0===t?void 0:t.idx)}},{key:"countryAll",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("country.all",{ln:this.userLanguage});case 2:return u["a"].state.countries=e.sent,e.abrupt("return",u["a"].state.countries);case 4:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},{key:"userLanguage",get:function(){var e,t=h.a.get("language");return e=t||(navigator.languages?navigator.languages[0]:navigator.language||navigator.userLanguage),e.substring(0,2)}},{key:"rootDomain",get:function(){var e=location.hostname;if(1===e.split(".").length)return e;var t=e.split(".");return t[1]+"."+t[2]}},{key:"setCookie",value:function(e,t){var n;"localhost"!=this.rootDomain&&(n="."+this.rootDomain),h.a.set(e,t,{expires:365,domain:n,path:"/"})}},{key:"cafeCreate",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("cafe.create",t);case 2:return n=e.sent,e.abrupt("return",(new c["a"]).fromMap(n));case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()},{key:"userList",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.request("user.search",t);case 2:return n=e.sent,e.abrupt("return",n.map((function(e){return(new c["g"]).fromMap(e)})));case 4:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}()}],[{key:"instance",get:function(){return e._instance||(e._instance=new e),e._instance}}]),e}()},cd49:function(e,t,n){"use strict";n.r(t);n("e260"),n("e6cf"),n("cca6"),n("a79d"),n("4de4");var r=n("2b0e"),a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{attrs:{id:"app","data-route":e.$route.path}},[n("mobile-header"),n("div",{staticClass:"row mt-2"},[n("div",{staticClass:"col-12 col-md-8",attrs:{id:"layout-content"}},[n("router-view",{key:e.$route.path}),n("top-menu-user"),n("desktop-search-box")],1),n("div",{staticClass:"d-none d-md-block col-md-4 p-0",attrs:{id:"layout-right"}},[n("desktop-right-sidebar")],1)]),n("section",{attrs:{id:"extra"}},[e._v(" extra : !! "+e._s(e.app.userLanguage)+" "+e._s(e._f("t")("login"))+" "+e._s(e.app.rootDomain)+" ")])],1)},s=[],i=n("d4ec"),o=n("bee2"),u=n("262e"),c=n("2caf"),l=(n("b0c0"),n("9ab4")),h=n("2fe1"),d=(n("d3b7"),n("3ca3"),n("ddb0"),n("8c4f")),p=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"home"},[n("div",[e._v("Version "+e._s(e.version))]),n("b-alert",{attrs:{show:""}},[e._v("Default Alert")]),e._m(0),n("b-alert",{attrs:{show:e.dismissCountDown,dismissible:"",variant:"warning"},on:{dismissed:function(t){e.dismissCountDown=0},"dismiss-count-down":e.countDownChanged}},[n("p",[e._v("This alert will dismiss after "+e._s(e.dismissCountDown)+" seconds...")]),n("b-progress",{attrs:{variant:"warning",max:e.dismissSecs,value:e.dismissCountDown,height:"4px"}})],1),n("b-button",{staticClass:"m-1",attrs:{variant:"info"},on:{click:e.showAlert}},[e._v(" Show alert with count-down timer ")]),n("b-button",{staticClass:"m-1",attrs:{variant:"info"},on:{click:function(t){e.showDismissibleAlert=!0}}},[e._v(" Show dismissible alert ("+e._s(e.showDismissibleAlert?"visible":"hidden")+") ")])],1)},f=[function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("a",{staticClass:"mr-2 btn btn-primary",attrs:{href:"/forum/qna"}},[e._v("QNA")]),n("a",{staticClass:"btn btn-primary",attrs:{href:"/forum/discussion"}},[e._v("Discussion")])])}],m=n("d68b"),v=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e.version="x.x.x",e.dismissSecs=10,e.dismissCountDown=0,e.showDismissibleAlert=!1,e}return Object(o["a"])(n,[{key:"countDownChanged",value:function(e){this.dismissCountDown=e}},{key:"showAlert",value:function(){this.dismissCountDown=this.dismissSecs}}]),n}(r["a"]);v=Object(l["a"])([Object(h["a"])({})],v);var b=v,g=b,y=n("2877"),x=Object(y["a"])(g,p,f,!1,null,null,null),w=x.exports;r["a"].use(d["a"]);var k=[{path:"/",name:"Home",component:w},{path:"/login",name:"Login",component:function(){return n.e("chunk-241b90b0").then(n.bind(null,"a55b"))}},{path:"/register",name:"Register",component:function(){return n.e("chunk-2d0d6d35").then(n.bind(null,"73cf"))}},{path:"/profile",name:"Profile",component:function(){return n.e("chunk-171ddf21").then(n.bind(null,"c66d"))}},{path:"/admin",name:"Admin",component:function(){return n.e("chunk-2d0c1282").then(n.bind(null,"459d"))}},{path:"/about",name:"About",component:function(){return n.e("about").then(n.bind(null,"f820"))}},{path:"*",name:"PostView",component:function(){return n.e("chunk-13cff186").then(n.bind(null,"2c67"))}},{path:"/forum/:category",name:"PostList",component:function(){return n.e("chunk-25ceb68c").then(n.bind(null,"e907"))}},{path:"/user/posts/:userIdx",name:"UserPostList",component:function(){return n.e("chunk-25ceb68c").then(n.bind(null,"e907"))}},{path:"/user/comments/:userIdx",name:"UserCommentList",component:function(){return n.e("chunk-7d8b0498").then(n.bind(null,"b7e6"))}},{path:"/edit/:idOrCategory",name:"PostEdit",component:function(){return n.e("chunk-99768f36").then(n.bind(null,"48d4"))}},{path:"/cafe/create",name:"CafeCreate",component:function(){return n.e("chunk-2d0cf888").then(n.bind(null,"63b7"))}}],O=new d["a"]({mode:"history",base:"/view/x/dist/",routes:k}),j=O,_=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"desktop-search-box d-none d-md-block",attrs:{"portal-to":"portal-header-center"}},[n("div",{staticClass:"text-center fs-lg"},[e._v("Search Box")]),n("div",{staticClass:"d-flex justify-content-center"},[n("search-box",{staticClass:"w-75"})],1)])},C=[],I=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"search-box"},[n("form",{on:{submit:function(t){return t.preventDefault(),e.search.apply(null,arguments)}}},[n("div",{staticClass:"position-relative w-100"},[n("input",{directives:[{name:"model",rawName:"v-model",value:e.keyword,expression:"keyword"}],staticClass:"fs-lg w-100",domProps:{value:e.keyword},on:{input:function(t){t.target.composing||(e.keyword=t.target.value)}}}),n("b-icon",{staticClass:"position-absolute top-35 right-35 fs-lg",attrs:{icon:"search",variant:"secondary"}})],1)])])},R=[],S=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e.keyword="",e}return Object(o["a"])(n,[{key:"search",value:function(){console.log("search: keyword: ",this.keyword)}}]),n}(r["a"]);S=Object(l["a"])([Object(h["a"])({})],S);var L=S,D=L,A=Object(y["a"])(D,I,R,!1,null,null,null),M=A.exports,U=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e.keyword="",e}return Object(o["a"])(n,[{key:"mounted",value:function(){}},{key:"search",value:function(){console.log("search: keyword: ",this.keyword)}}]),n}(r["a"]);U=Object(l["a"])([Object(h["a"])({components:{SearchBox:M}})],U);var P=U,q=P,E=Object(y["a"])(q,_,C,!1,null,null,null),N=E.exports,$=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{attrs:{"portal-to":"portal-top-menu-user"}},[e.app.notLoggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/login"}},[e._v("Login")]):e._e(),e.app.notLoggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/register"}},[e._v("Register")]):e._e(),e.app.loggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/profile"}},[e._v("Profile")]):e._e(),e.app.loggedIn?n("span",{staticClass:"p-2",on:{click:function(t){return e.app.api.logout()}}},[e._v("Logout")]):e._e()],1)},B=[],T=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e}return Object(o["a"])(n,[{key:"mounted",value:function(){}}]),n}(r["a"]);T=Object(l["a"])([Object(h["a"])({})],T);var V=T,Y=V,F=Object(y["a"])(Y,$,B,!1,null,null,null),z=F.exports,H=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"d-md-none"},[n("b-navbar",{attrs:{toggleable:"lg",type:"dark",variant:"info"}},[n("b-navbar-brand",{attrs:{href:"/"}},[e._v(" NavBar ")]),n("div",{staticClass:"left"},[n("a",{staticClass:"p-2",attrs:{href:"/forum/discussion"}},[e._v("Discussion")]),n("a",{staticClass:"p-2",attrs:{href:"/forum/qna"}},[e._v("QnA")])]),n("b-navbar-toggle",{attrs:{target:"nav-collapse"}}),n("b-collapse",{attrs:{id:"nav-collapse","is-nav":""}},[n("b-navbar-nav",[n("b-nav-item",{attrs:{href:"#"}},[e._v("Link")]),n("b-nav-item",{attrs:{href:"#",disabled:""}},[e._v("Disabled")])],1),n("b-navbar-nav",{staticClass:"ml-auto"},[n("b-nav-item-dropdown",{attrs:{text:"Lang",right:""}},[n("b-dropdown-item",{attrs:{href:"#"}},[e._v("EN")]),n("b-dropdown-item",{attrs:{href:"#"}},[e._v("ES")]),n("b-dropdown-item",{attrs:{href:"#"}},[e._v("RU")]),n("b-dropdown-item",{attrs:{href:"#"}},[e._v("FA")])],1),n("b-nav-item-dropdown",{attrs:{right:""},scopedSlots:e._u([{key:"button-content",fn:function(){return[n("em",[e._v("User")])]},proxy:!0}])},[n("b-dropdown-item",{attrs:{href:"#"}},[e._v("Profile")]),n("b-dropdown-item",{attrs:{href:"#"}},[e._v("Sign Out")])],1)],1)],1)],1),n("div",{staticClass:"mt-2 mx-2"},[n("search-box")],1)],1)},J=[],Q=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){return Object(i["a"])(this,n),t.apply(this,arguments)}return n}(r["a"]);Q=Object(l["a"])([Object(h["a"])({components:{SearchBox:M}})],Q);var G=Q,K=G,W=Object(y["a"])(K,H,J,!1,null,null,null),X=W.exports,Z=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("section",{},[e.app.notLoggedIn?n("div",{staticClass:"box"},[e._v("@todo display login banner")]):e._e(),e.app.loggedIn?n("div",{staticClass:"mt-2"},[e._v(" idx: "+e._s(e.app.user.idx)+" "),n("br"),e._v(" name: "+e._s(e.app.user.displayName)+" "),n("hr"),n("router-link",{staticClass:"mr-2 btn btn-dark",attrs:{to:"/admin"}},[e._v("Admin")]),n("router-link",{staticClass:"mr-2 btn btn-primary",attrs:{to:"/profile"}},[e._v("Profile")]),n("button",{staticClass:"btn btn-secondary",on:{click:function(t){return e.app.api.logout()}}},[e._v(" Logout ")])],1):e._e(),n("div",{staticClass:"mt-2 box"},[e._v(".Right side bar")]),n("cafe-create-banner")],1)},ee=[],te=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"mt-3"},[n("router-link",{attrs:{to:"/cafe/create"}},[n("div",{staticClass:"alert alert-info pointer"},[e._v("Create a cafe.")])])],1)},ne=[],re=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){return Object(i["a"])(this,n),t.apply(this,arguments)}return n}(r["a"]);re=Object(l["a"])([Object(h["a"])({})],re);var ae=re,se=ae,ie=Object(y["a"])(se,te,ne,!1,null,null,null),oe=ie.exports,ue=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e}return Object(o["a"])(n,[{key:"logout",value:function(){console.log("App::logout()"),this.app.api.logout()}}]),n}(r["a"]);ue=Object(l["a"])([Object(h["a"])({components:{CafeCreateBanner:oe}})],ue);var ce=ue,le=ce,he=Object(y["a"])(le,Z,ee,!1,null,null,null),de=he.exports,pe=function(e){Object(u["a"])(n,e);var t=Object(c["a"])(n);function n(){var e;return Object(i["a"])(this,n),e=t.apply(this,arguments),e.app=m["a"].instance,e}return Object(o["a"])(n,[{key:"mounted",value:function(){var e=this;console.log("App::mounted. running mode: ","production"),this.app.portal(),j.afterEach((function(t){"PostList"==t.name||"PostView"==t.name?e.app.hideLeftSidebar():e.app.showLeftSidebar()}))}}]),n}(r["a"]);pe=Object(l["a"])([Object(h["a"])({components:{DesktopSearchBox:N,SearchBox:M,TopMenuUser:z,MobileHeader:X,DesktopRightSidebar:de}})],pe);var fe=pe,me=fe,ve=Object(y["a"])(me,a,s,!1,null,null,null),be=ve.exports,ge=n("9483");Object(ge["a"])("".concat("/view/x/dist/","service-worker.js"),{ready:function(){console.log("App is being served from cache by a service worker.\nFor more details, visit https://goo.gl/AFskqB")},registered:function(){console.log("Service worker has been registered.")},cached:function(){console.log("Content has been cached for offline use.")},updatefound:function(){console.log("New content is downloading.")},updated:function(){console.log("New content is available; please refresh.")},offline:function(){console.log("No internet connection found. App is running in offline mode.")},error:function(e){console.error("Error during service worker registration:",e)}});var ye=n("0613"),xe=n("63e9"),we=n("cca8"),ke=n("7049"),Oe=n("40aa"),je=n("b1e0"),_e=n("f9bc"),Ce=n("b1fc"),Ie=n("b519"),Re=n("a166"),Se=n("f7ca"),Le=n("700c"),De=n("a7e2"),Ae=(n("f9e3"),n("2dd8"),n("8d76")),Me=n.n(Ae);n("8594");r["a"].config.productionTip=!1,r["a"].use(xe["a"]),r["a"].use(we["a"]),r["a"].use(ke["a"]),r["a"].use(Oe["a"]),r["a"].use(je["a"]),r["a"].use(_e["a"]),r["a"].use(Ce["a"]),r["a"].use(Ie["a"]),r["a"].use(Re["a"]),r["a"].use(Se["a"]),r["a"].use(Le["a"]),r["a"].use(De["a"]),r["a"].use(je["a"]);var Ue=m["a"].instance;r["a"].filter("t",(function(e){return console.log(Ue.translation.texts.login),console.log(Ue.userLanguage),e?Ue.translation.texts[e]?Ue.translation.texts[e][Ue.userLanguage]:e:""}));var Pe=new r["a"]({router:j,store:ye["a"],data:{a:"apple",landing:!0},render:function(e){return e(be)},mounted:function(){},methods:{aTag:function(e){this.$router.push(e).catch((function(){return null}))},changeLanguage:function(e){console.log("changeLanguage",e),Ue.setCookie("language",e),location.reload()}}}).$mount("#app");Me()("a").click((function(e){e.preventDefault(),console.log("click",Me()(this).attr("href")),Pe.aTag(Me()(this).attr("href"))}))},d68b:function(e,t,n){"use strict";n.d(t,"a",(function(){return l}));var r=n("1da1"),a=n("d4ec"),s=n("bee2"),i=(n("ac1f"),n("1276"),n("a15b"),n("4de4"),n("a434"),n("96cf"),n("c160")),o=n("8d76"),u=n.n(o),c=function e(){Object(a["a"])(this,e),this.texts={home:{en:"Home",ko:"홈"},login:{en:"Login",ko:"로그인"}}},l=function(){function e(){Object(a["a"])(this,e),this.api=i["a"].instance,this.translation=new c,console.log("AppService::constructor()"),this.init()}return Object(s["a"])(e,[{key:"loggedIn",get:function(){return this.api.loggedIn}},{key:"notLoggedIn",get:function(){return this.api.notLoggedIn}},{key:"user",get:function(){return this.api.user}},{key:"init",value:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:case"end":return e.stop()}}),e)})));function t(){return e.apply(this,arguments)}return t}()},{key:"error",value:function(e){"string"===typeof e&&0===e.indexOf("error_")&&alert(e)}},{key:"removeAllChildNodes",value:function(e){while(null!==e&&void 0!==e&&e.firstChild)e.removeChild(e.firstChild)}},{key:"hideLeftSidebar",value:function(){u()("#layout-left").removeClass("d-lg-block"),u()("#layout-content-right").removeClass("col-lg-9"),u()("#layout-content").removeClass("col-md-8").addClass("col-md-9"),u()("#layout-right").removeClass("col-md-4").addClass("col-md-3")}},{key:"showLeftSidebar",value:function(){u()("#layout-left").addClass("d-lg-block"),u()("#layout-content-right").addClass("col-lg-9"),u()("#layout-content").addClass("col-md-8").removeClass("col-md-9"),u()("#layout-right").addClass("col-md-4").removeClass("col-md-3")}},{key:"userLanguage",get:function(){return this.api.userLanguage}},{key:"rootDomain",get:function(){return this.api.rootDomain}},{key:"setCookie",value:function(e,t){return this.api.setCookie(e,t)}},{key:"addByComma",value:function(e,t){var n=e.split(",");return n.indexOf(t)>=0?e:(n.push(t),n.filter((function(e){return!!e})).join(","))}},{key:"deleteByComma",value:function(e,t){var n=e.split(","),r=n.indexOf(t);return r>=0&&n.splice(r,1),n.filter((function(e){return!!e})).join(",")}},{key:"portal",value:function(){u()("[portal-to]").each((function(){var e=u()(this).attr("portal-to");u()("#"+e).empty().append(u()(this))}))}},{key:"openCafe",value:function(e){location.href="//"+e}}],[{key:"instance",get:function(){return this._instance||(this._instance=new e),this._instance}}]),e}()}});
//# sourceMappingURL=app.2d3c788e.js.map