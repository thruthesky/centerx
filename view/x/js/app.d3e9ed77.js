(function(t){function e(e){for(var r,s,a=e[0],c=e[1],u=e[2],l=0,f=[];l<a.length;l++)s=a[l],Object.prototype.hasOwnProperty.call(o,s)&&o[s]&&f.push(o[s][0]),o[s]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(t[r]=c[r]);d&&d(e);while(f.length)f.shift()();return i.push.apply(i,u||[]),n()}function n(){for(var t,e=0;e<i.length;e++){for(var n=i[e],r=!0,s=1;s<n.length;s++){var c=n[s];0!==o[c]&&(r=!1)}r&&(i.splice(e--,1),t=a(a.s=n[0]))}return t}var r={},o={app:0},i=[];function s(t){return a.p+"js/"+({about:"about"}[t]||t)+"."+{about:"854098c9","chunk-2d0aa5d2":"41119cff","chunk-2d0c1282":"31df5aaf","chunk-2d0cf888":"4ae63b59","chunk-2d0d6d35":"cddebff5","chunk-3ee9dab5":"d25c9d0f","chunk-6e510f22":"3c4a38b1","chunk-78e97d9d":"9bffbf58","chunk-8d94e650":"2f89292b","chunk-c425edd8":"b4470817","chunk-ecba9ee6":"81c2f691"}[t]+".js"}function a(e){if(r[e])return r[e].exports;var n=r[e]={i:e,l:!1,exports:{}};return t[e].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.e=function(t){var e=[],n=o[t];if(0!==n)if(n)e.push(n[2]);else{var r=new Promise((function(e,r){n=o[t]=[e,r]}));e.push(n[2]=r);var i,c=document.createElement("script");c.charset="utf-8",c.timeout=120,a.nc&&c.setAttribute("nonce",a.nc),c.src=s(t);var u=new Error;i=function(e){c.onerror=c.onload=null,clearTimeout(l);var n=o[t];if(0!==n){if(n){var r=e&&("load"===e.type?"missing":e.type),i=e&&e.target&&e.target.src;u.message="Loading chunk "+t+" failed.\n("+r+": "+i+")",u.name="ChunkLoadError",u.type=r,u.request=i,n[1](u)}o[t]=void 0}};var l=setTimeout((function(){i({type:"timeout",target:c})}),12e4);c.onerror=c.onload=i,document.head.appendChild(c)}return Promise.all(e)},a.m=t,a.c=r,a.d=function(t,e,n){a.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},a.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},a.t=function(t,e){if(1&e&&(t=a(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(a.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)a.d(n,r,function(e){return t[e]}.bind(null,r));return n},a.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return a.d(e,"a",e),e},a.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},a.p="/",a.oe=function(t){throw console.error(t),t};var c=window["webpackJsonp"]=window["webpackJsonp"]||[],u=c.push.bind(c);c.push=e,c=c.slice();for(var l=0;l<c.length;l++)e(c[l]);var d=u;i.push([0,"chunk-vendors"]),n()})({0:function(t,e,n){t.exports=n("cd49")},"0613":function(t,e,n){"use strict";var r=n("2b0e"),o=n("2f62"),i={home:{en:"Home",ko:"홈"},login:{en:"Login",ko:"로그인"},qna:{en:"QnA",ko:"질문게시판"},discussion:{en:"Discussion",ko:"자유게시판"},buyandsell:{en:"Buy&sell",ko:"회원장터"},reminder:{en:"Reminder",ko:"공지사항"},job:{en:"Job",ko:"구인구직"},rent_house:{en:"Houses",ko:"주택임대"},rent_car:{en:"RentCar",ko:"렌트카"},im:{en:"Immigrant",ko:"이민"},real_estate:{en:"Realestate",ko:"부동산"},money_exchange:{en:"Exchange",ko:"환전"},sitemap:{en:"Sitemap",ko:"전체메뉴"},error:{en:"Warning",ko:"알림"},error_not_logged_in:{en:"Please, login first!",ko:"로그인을 해 주세요."}},s={user:void 0,countries:void 0,cafe:void 0,cafeSettings:{},texts:{}},a={vm:{}};s.texts=i,r["a"].use(o["a"]);e["a"]=new o["a"].Store({state:Object.assign({},a,s),mutations:{},actions:{},modules:{}})},"0a17":function(t,e,n){t.exports=n.p+"img/search.c9055354.svg"},"20d6":function(t,e,n){"use strict";var r,o;n.d(e,"b",(function(){return r})),n.d(e,"a",(function(){return o})),function(t){t["sessionId"]="sessionId"}(r||(r={})),function(t){t["main_cafe_has_no_cafe_category_record"]="error_main_cafe_has_no_cafe_category_record",t["cafe_not_exists"]="error_cafe_not_exists"}(o||(o={}))},8594:function(t,e,n){},"9f3a":function(t,e,n){"use strict";n.d(e,"a",(function(){return f}));n("d3b7"),n("d81d");var r=n("9ab4"),o=n("bc3a"),i=n.n(o),s=n("0613"),a=n("d28a"),c=n("a78e"),u=n.n(c),l=n("20d6"),d=n("d661"),f=function(){function t(){this.initUserAuth()}return Object.defineProperty(t,"instance",{get:function(){return t._instance||(t._instance=new t),t._instance},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"user",{get:function(){return s["a"].state.user},set:function(t){s["a"].state.user=t},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"loggedIn",{get:function(){return!!this.user&&!!this.user.idx},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"notLoggedIn",{get:function(){return!this.loggedIn},enumerable:!1,configurable:!0}),t.prototype.initUserAuth=function(){return Object(r["a"])(this,void 0,Promise,(function(){return Object(r["d"])(this,(function(t){switch(t.label){case 0:return this.sessionId=this.getUserSessionId(),[4,this.refreshLoginUserProfile()];case 1:return t.sent(),[2]}}))}))},t.prototype.refreshLoginUserProfile=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t;return Object(r["d"])(this,(function(e){switch(e.label){case 0:return this.sessionId?[4,this.request("user.profile")]:[2];case 1:return t=e.sent(),[2,this.setUserSessionId(t)]}}))}))},t.prototype.setUserSessionId=function(t){return console.log(t),this.user=(new a["g"]).fromJson(t),this.setCookie(l["b"].sessionId,this.user.sessionId),this.sessionId=this.user.sessionId,this.user},t.prototype.deleteUserSessionId=function(){this.removeCookie(l["b"].sessionId)},t.prototype.getUserSessionId=function(){return this.sessionId=u.a.get(l["b"].sessionId),this.sessionId},t.prototype.register=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.register",t)];case 1:return e=n.sent(),[2,this.setUserSessionId(e)]}}))}))},t.prototype.login=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.login",t)];case 1:return e=n.sent(),[2,this.setUserSessionId(e)]}}))}))},t.prototype.kakaoLogin=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.kakaoLogin",t)];case 1:return e=n.sent(),[2,this.setUserSessionId(e)]}}))}))},t.prototype.otherUserProfile=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.otherUserProfile",{idx:t})];case 1:return e=n.sent(),[2,(new a["g"]).fromJson(e)]}}))}))},t.prototype.logout=function(){this.deleteUserSessionId(),this.sessionId=void 0,this.user=void 0},t.prototype.request=function(t,e){return void 0===e&&(e={}),Object(r["a"])(this,void 0,Promise,(function(){var n,o,s;return Object(r["d"])(this,(function(r){switch(r.label){case 0:return e.route=t,this.sessionId&&(e.sessionId=this.sessionId),n=location.hostname,o="https://"+n+"/index.php",console.log("endpoint; ",o),[4,i.a.post(o,e)];case 1:if(s=r.sent(),"string"===typeof s.data)throw console.error(s),"error_error_string_from_php_backend";if(!s.data.response)throw"error_malformed_response_from_php_backend";if("string"===typeof s.data.response&&0===s.data.response.indexOf("error_"))throw s.data.response;return[2,s.data.response]}}))}))},t.prototype.version=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t;return Object(r["d"])(this,(function(e){switch(e.label){case 0:return[4,this.request("app.version")];case 1:return t=e.sent(),[2,t.version]}}))}))},t.prototype.postGet=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("post.get",t)];case 1:return e=n.sent(),[2,(new a["f"]).fromJson(e)]}}))}))},t.prototype.postSearch=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("post.search",t)];case 1:return e=n.sent(),[2,e.map((function(t){return(new a["f"]).fromJson(t)}))]}}))}))},t.prototype.postCount=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("post.count",t)];case 1:return e=n.sent(),[2,e.count]}}))}))},t.prototype.postEdit=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,n;return Object(r["d"])(this,(function(r){switch(r.label){case 0:return e="post.create",t.idx&&(e="post.update"),[4,this.request(e,t)];case 1:return n=r.sent(),[2,(new a["f"]).fromJson(n)]}}))}))},t.prototype.postDelete=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,n;return Object(r["d"])(this,(function(r){switch(r.label){case 0:return n=(e=new a["f"]).fromJson,[4,this.request("post.delete",{idx:t})];case 1:return[2,n.apply(e,[r.sent()])]}}))}))},t.prototype.commentSearch=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return t.userIdx&&(t.where="userIdx="+t.userIdx),[4,this.request("comment.search",t)];case 1:return e=n.sent(),[2,e.map((function(t){return(new a["c"]).fromJson(t)}))]}}))}))},t.prototype.commentEdit=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e,n;return Object(r["d"])(this,(function(r){switch(r.label){case 0:return e="comment.create",t.idx&&(e="comment.update"),[4,this.request(e,t)];case 1:return n=r.sent(),[2,(new a["c"]).fromJson(n)]}}))}))},t.prototype.commentDelete=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("comment.delete",{idx:t})];case 1:return e=n.sent(),[2,(new a["c"]).fromJson(e)]}}))}))},t.prototype.vote=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("post.vote",t)];case 1:return e=n.sent(),[2,e]}}))}))},t.prototype.fileUpload=function(t,e,n,r,o){var s=new FormData;for(var c in s.append("route","file.upload"),this.sessionId&&s.append("sessionId",this.sessionId),e)s.append(c,e[c]);s.append("userfile",t);var u={onUploadProgress:function(t){var e=Math.round(100*t.loaded/t.total);o&&o(e)}};i.a.post("https://cherry.philov.com/index.php",s,u).then((function(t){if("string"===typeof t.data.response&&0===t.data.response.indexOf("error_"))r(t.data.response);else{var e=(new a["d"]).fromJson(t.data.response);n(e)}})).catch(r)},t.prototype.fileDelete=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("file.delete",{idx:t})];case 1:return e=n.sent(),[2,e.idx]}}))}))},t.prototype.isMine=function(t){var e;return!this.notLoggedIn&&t.userIdx===(null===(e=this.user)||void 0===e?void 0:e.idx)},t.prototype.countryAll=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t;return Object(r["d"])(this,(function(e){switch(e.label){case 0:return t=s["a"].state,[4,this.request("country.all",{ln:this.userLanguage})];case 1:return t.countries=e.sent(),[2,s["a"].state.countries]}}))}))},Object.defineProperty(t.prototype,"userLanguage",{get:function(){var t,e=u.a.get("language");return t=e||(navigator.languages?navigator.languages[0]:navigator.language),t.substring(0,2)},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"domain",{get:function(){return location.hostname},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"rootDomain",{get:function(){return Object(d["c"])(this.domain)},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"cookieDomain",{get:function(){var t;return"localhost"!=this.rootDomain&&(t="."+this.rootDomain),t},enumerable:!1,configurable:!0}),t.prototype.setCookie=function(t,e){u.a.set(t,e,{expires:365,domain:this.cookieDomain,path:"/"})},t.prototype.removeCookie=function(t){u.a.remove(t,{expires:365,domain:this.cookieDomain,path:"/"})},t.prototype.userSearch=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.search",t)];case 1:return e=n.sent(),[2,e.map((function(t){return(new a["g"]).fromJson(t)}))]}}))}))},t.prototype.userGet=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.get",t)];case 1:return e=n.sent(),[2,(new a["g"]).fromJson(e)]}}))}))},t.prototype.userUpdate=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.update",t)];case 1:return e=n.sent(),[2,(new a["g"]).fromJson(e)]}}))}))},t.prototype.userCount=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("user.count",t)];case 1:return e=n.sent(),console.log(e),[2,e&&e.count?e.count:0]}}))}))},t.prototype.cafeCreate=function(t){return Object(r["a"])(this,void 0,Promise,(function(){var e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,this.request("cafe.create",t)];case 1:return e=n.sent(),[2,(new a["a"]).fromJson(e)]}}))}))},t.prototype.loadCafe=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t;return Object(r["d"])(this,(function(e){switch(e.label){case 0:return[4,this.request("cafe.get",{domain:this.domain})];case 1:return t=e.sent(),s["a"].state.cafe=(new a["a"]).fromJson(t),[2,s["a"].state.cafe]}}))}))},t.prototype.setStorage=function(t,e){localStorage.setItem(t,JSON.stringify(e))},t.prototype.getStorage=function(t){var e=localStorage.getItem(t);return e?JSON.parse(e):e},t.prototype.loadCafeSettings=function(){return Object(r["a"])(this,void 0,Promise,(function(){var t,e;return Object(r["d"])(this,(function(n){switch(n.label){case 0:return t=this.getStorage("cafeSettings"),t&&(s["a"].state.cafeSettings=t),[4,this.request("cafe.settings",{domain:this.domain})];case 1:return e=n.sent(),s["a"].state.cafeSettings=e,this.setStorage("cafeSettings",s["a"].state.cafeSettings),[2,s["a"].state.cafeSettings]}}))}))},t.prototype.currentCafeSettings=function(){if(s["a"].state.cafeSettings&&s["a"].state.cafeSettings["rootDomainSettings"]&&s["a"].state.cafeSettings["rootDomainSettings"][this.rootDomain])return s["a"].state.cafeSettings["rootDomainSettings"][this.rootDomain]},t.prototype.error=function(t){return"string"===typeof t&&0===t.indexOf("error_")?this.alert(Object(d["d"])("error"),Object(d["d"])(t)):this.alert(Object(d["d"])("error"),"Unknown error: "+t)},t.prototype.alert=function(t,e){return Object(r["a"])(this,void 0,Promise,(function(){return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,s["a"].state.vm.$bvModal.msgBoxOk(e,{title:t,size:"sm",buttonSize:"sm",okVariant:"success",headerClass:"p-2 border-bottom-0",footerClass:"p-2 border-top-0"})];case 1:return[2,n.sent()]}}))}))},t.prototype.confirm=function(t,e){return Object(r["a"])(this,void 0,Promise,(function(){return Object(r["d"])(this,(function(n){switch(n.label){case 0:return[4,s["a"].state.vm.$bvModal.msgBoxConfirm(e,{title:t,size:"sm",buttonSize:"sm",okVariant:"danger",okTitle:Object(d["d"])("yes"),cancelTitle:Object(d["d"])("no"),footerClass:"p-2",hideHeaderClose:!1,centered:!0})];case 1:return[2,n.sent()]}}))}))},t}()},c401:function(t,e,n){"use strict";e["a"]={kakaoJavascriptKey:"937af10cf8688bd9a7554cf088b2ac3e",naver:{clientId:"uCSRMmdn9Neo98iSpduh",callbackUrl:"https://main.philov.com/etc/callbacks/naver/naver-login.callback.php"},cafeSettings:{mainDomains:["philov.com","www.philov.com","main.philov.com","sonub.com","www.sonub.com","main.sonub.com"],countryDomains:["philov.com"],rootDomainSettings:{"sonub.com":{name:"필러브",countryCode:"",logo:"/img/cafe/root-domain-logo/no-logo.jpg"},"philov.com":{name:"필러브",countryCode:"PH",logo:"/img/cafe/root-domain-logo/philov-logo.jpg"}},mainMenus:["qna","discussion","buyandsell","reminder","job","rent_house","rent_car","im","real_estate","money_exchange","sitemap"],sitemap:{community:["qna","discussion","buyandsell","reminder"],business:["job","rent_house","rent_car","im","real_estate","money_exchange"]}}}},cd49:function(t,e,n){"use strict";n.r(e);n("e260"),n("e6cf"),n("cca6"),n("a79d"),n("4de4");var r=n("2b0e"),o=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"app","data-route":t.$route.path}},[n("mobile-header"),n("div",{staticClass:"row mt-2"},[n("div",{staticClass:"col-12 col-md-8",attrs:{id:"layout-content"}},[n("router-view",{key:t.$route.path}),n("top-menu-user"),n("desktop-header"),n("desktop-main-menu-right")],1),n("div",{staticClass:"d-none d-md-block col-md-4 p-0",attrs:{id:"layout-right"}},[n("desktop-right-sidebar")],1)])],1)},i=[],s=(n("d3b7"),n("b0c0"),n("9ab4")),a=n("2fe1"),c=(n("3ca3"),n("ddb0"),n("8c4f")),u=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"home"},[n("div",[t._v("Version "+t._s(t.version))]),n("b-alert",{attrs:{show:""}},[t._v("Default Alert")]),t._m(0),n("b-alert",{attrs:{show:t.dismissCountDown,dismissible:"",variant:"warning"},on:{dismissed:function(e){t.dismissCountDown=0},"dismiss-count-down":t.countDownChanged}},[n("p",[t._v("This alert will dismiss after "+t._s(t.dismissCountDown)+" seconds...")]),n("b-progress",{attrs:{variant:"warning",max:t.dismissSecs,value:t.dismissCountDown,height:"4px"}})],1),n("b-button",{staticClass:"m-1",attrs:{variant:"info"},on:{click:t.showAlert}},[t._v(" Show alert with count-down timer ")]),n("b-button",{staticClass:"m-1",attrs:{variant:"info"},on:{click:function(e){t.showDismissibleAlert=!0}}},[t._v(" Show dismissible alert ("+t._s(t.showDismissibleAlert?"visible":"hidden")+") ")])],1)},l=[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("a",{staticClass:"mr-2 btn btn-primary",attrs:{href:"/forum/qna"}},[t._v("QNA")]),n("a",{staticClass:"btn btn-primary",attrs:{href:"/forum/discussion"}},[t._v("Discussion")])])}],d=n("d68b"),f=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.version="x.x.x",e.dismissSecs=10,e.dismissCountDown=0,e.showDismissibleAlert=!1,e}return Object(s["c"])(e,t),e.prototype.countDownChanged=function(t){this.dismissCountDown=t},e.prototype.showAlert=function(){this.dismissCountDown=this.dismissSecs},e=Object(s["b"])([Object(a["a"])({})],e),e}(r["a"]),p=f,h=p,m=n("2877"),b=Object(m["a"])(h,u,l,!1,null,null,null),g=b.exports;r["a"].use(c["a"]);var v=[{path:"/",name:"Home",component:g},{path:"/login",name:"Login",component:function(){return n.e("chunk-c425edd8").then(n.bind(null,"a55b"))}},{path:"/register",name:"Register",component:function(){return n.e("chunk-2d0d6d35").then(n.bind(null,"73cf"))}},{path:"/profile",name:"Profile",component:function(){return n.e("chunk-ecba9ee6").then(n.bind(null,"c66d"))}},{path:"/admin",name:"Admin",component:function(){return n.e("chunk-2d0c1282").then(n.bind(null,"459d"))}},{path:"/admin/user/edit/:userIdx",name:"AdminUserEdit",component:function(){return n.e("chunk-2d0aa5d2").then(n.bind(null,"1162"))}},{path:"/about",name:"About",component:function(){return n.e("about").then(n.bind(null,"f820"))}},{path:"*",name:"PostView",component:function(){return n.e("chunk-6e510f22").then(n.bind(null,"2c67"))}},{path:"/forum/:category",name:"PostList",component:function(){return n.e("chunk-8d94e650").then(n.bind(null,"e907"))}},{path:"/user/posts/:userIdx",name:"UserPostList",component:function(){return n.e("chunk-8d94e650").then(n.bind(null,"e907"))}},{path:"/user/comments/:userIdx",name:"UserCommentList",component:function(){return n.e("chunk-78e97d9d").then(n.bind(null,"b7e6"))}},{path:"/edit/:idOrCategory",name:"PostEdit",component:function(){return n.e("chunk-3ee9dab5").then(n.bind(null,"48d4"))}},{path:"/cafe/create",name:"CafeCreate",component:function(){return n.e("chunk-2d0cf888").then(n.bind(null,"63b7"))}}],y=new c["a"]({mode:"history",base:"/",routes:v}),O=y,j=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{"portal-to":"portal-top-menu-user"}},[t.app.notLoggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/login"}},[t._v("Login")]):t._e(),t.app.notLoggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/register"}},[t._v("Register")]):t._e(),t.app.loggedIn?n("router-link",{staticClass:"p-2",attrs:{to:"/profile"}},[t._v("Profile")]):t._e(),t.app.loggedIn?n("span",{staticClass:"p-2",on:{click:function(e){return t.app.api.logout()}}},[t._v("Logout")]):t._e()],1)},w=[],_=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e}return Object(s["c"])(e,t),e.prototype.mounted=function(){},e=Object(s["b"])([Object(a["a"])({})],e),e}(r["a"]),x=_,k=x,C=Object(m["a"])(k,j,w,!1,null,null,null),I=C.exports,P=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"d-md-none"},[n("b-navbar",{attrs:{toggleable:"lg",type:"dark",variant:"info"}},[n("b-navbar-brand",{attrs:{href:"/"}},[t._v(" NavBar ")]),n("div",{staticClass:"left"},[n("a",{staticClass:"p-2",attrs:{href:"/forum/discussion"}},[t._v("Discussion")]),n("a",{staticClass:"p-2",attrs:{href:"/forum/qna"}},[t._v("QnA")])]),n("b-navbar-toggle",{attrs:{target:"nav-collapse"}}),n("b-collapse",{attrs:{id:"nav-collapse","is-nav":""}},[n("b-navbar-nav",[n("b-nav-item",{attrs:{href:"#"}},[t._v("Link")]),n("b-nav-item",{attrs:{href:"#",disabled:""}},[t._v("Disabled")])],1),n("b-navbar-nav",{staticClass:"ml-auto"},[n("b-nav-item-dropdown",{attrs:{text:"Lang",right:""}},[n("b-dropdown-item",{attrs:{href:"#"}},[t._v("EN")]),n("b-dropdown-item",{attrs:{href:"#"}},[t._v("ES")]),n("b-dropdown-item",{attrs:{href:"#"}},[t._v("RU")]),n("b-dropdown-item",{attrs:{href:"#"}},[t._v("FA")])],1),n("b-nav-item-dropdown",{attrs:{right:""},scopedSlots:t._u([{key:"button-content",fn:function(){return[n("em",[t._v("User")])]},proxy:!0}])},[n("b-dropdown-item",{attrs:{href:"#"}},[t._v("Profile")]),n("b-dropdown-item",{attrs:{href:"#"}},[t._v("Sign Out")])],1)],1)],1)],1),n("div",{staticClass:"mt-2 mx-2"},[n("search-box")],1)],1)},S=[],D=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"search-box"},[r("form",{on:{submit:function(e){return e.preventDefault(),t.search.apply(null,arguments)}}},[r("div",{staticClass:"position-relative w-100"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.keyword,expression:"keyword"}],staticClass:"fs-lg w-100",domProps:{value:t.keyword},on:{input:function(e){e.target.composing||(t.keyword=e.target.value)}}}),r("img",{staticClass:"icon position-absolute top-35 right-35 fs-lg grey",attrs:{src:n("0a17")}})])])])},L=[],U=(n("ac1f"),n("841c"),function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.keyword="",e}return Object(s["c"])(e,t),e.prototype.search=function(){console.log("search: keyword: ",this.keyword)},e=Object(s["b"])([Object(a["a"])({})],e),e}(r["a"])),A=U,q=A,J=Object(m["a"])(q,D,L,!1,null,null,null),E=J.exports,N=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(s["c"])(e,t),e=Object(s["b"])([Object(a["a"])({components:{SearchBox:E}})],e),e}(r["a"]),M=N,$=M,R=Object(m["a"])($,P,S,!1,null,null,null),T=R.exports,z=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",{},[t.app.notLoggedIn?n("div",{staticClass:"box"},[n("router-link",{attrs:{to:"/login"}},[t._v("로그인하기")])],1):t._e(),t.app.loggedIn?n("div",{staticClass:"mt-2"},[t._v(" idx: "+t._s(t.app.user.idx)+" "),n("br"),t._v(" name: "+t._s(t.app.user.displayName)+" "),n("hr"),t.app.user.admin?n("router-link",{staticClass:"mr-2 btn btn-dark",attrs:{to:"/admin"}},[t._v("Admin")]):t._e(),n("router-link",{staticClass:"mr-2 btn btn-primary",attrs:{to:"/profile"}},[t._v("Profile")]),n("button",{staticClass:"btn btn-secondary",attrs:{"data-cy":"logout-button"},on:{click:function(e){return t.app.api.logout()}}},[t._v(" Logout ")])],1):t._e(),n("div",{staticClass:"mt-2 box"},[t._v(".Right side bar")]),n("cafe-create-banner")],1)},B=[],V=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"mt-3"},[n("router-link",{attrs:{to:"/cafe/create"}},[n("div",{staticClass:"alert alert-info pointer"},[t._v("Create a cafe.")])])],1)},H=[],Y=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(s["c"])(e,t),e=Object(s["b"])([Object(a["a"])({})],e),e}(r["a"]),F=Y,Q=F,G=Object(m["a"])(Q,V,H,!1,null,null,null),K=G.exports,W=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e}return Object(s["c"])(e,t),e.prototype.logout=function(){console.log("App::logout()"),this.app.api.logout()},e=Object(s["b"])([Object(a["a"])({components:{CafeCreateBanner:K}})],e),e}(r["a"]),X=W,Z=X,tt=Object(m["a"])(Z,z,B,!1,null,null,null),et=tt.exports,nt=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"d-flex justify-content-around",attrs:{"portal-to":"portal-desktop-mainmenu-right"}},t._l(t.menus,(function(e){return n("router-link",{key:e,attrs:{to:"/forum/"+e}},[t._v(t._s(t._f("t")(e)))])})),1)},rt=[],ot=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.keyword="",e}return Object(s["c"])(e,t),Object.defineProperty(e.prototype,"menus",{get:function(){return this.app.cafeMenus},enumerable:!1,configurable:!0}),e.prototype.search=function(){console.log("search: keyword: ",this.keyword)},e=Object(s["b"])([Object(a["a"])({})],e),e}(r["a"]),it=ot,st=it,at=Object(m["a"])(st,nt,rt,!1,null,null,null),ct=at.exports,ut=n("9f3a"),lt=n("20d6"),dt=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"container-xl",attrs:{"portal-to":"portal-header"}},[n("div",{staticClass:"row"},[t._m(0),n("div",{staticClass:"col-12 col-md-8 col-lg-6"},[n("desktop-search-box")],1),t._m(1)])])},ft=[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"d-none d-lg-flex align-items-end col-3 p-0"},[n("div",{staticClass:"banner top left"},[n("img",{staticClass:"w-100",attrs:{src:"/tmp/left-banner.jpg"}})])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"d-none d-md-flex align-items-end col-4 col-lg-3 p-0 bg-white"},[n("div",{staticClass:"banner top right"},[n("img",{staticClass:"w-100",attrs:{src:"/tmp/right-banner.jpg"}})])])}],pt=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"desktop-search-box d-none d-md-block",attrs:{"portal-to":"portal-header-center"}},[n("div",{staticClass:"d-flex justify-content-center"},[n("router-link",{staticClass:"logo",attrs:{to:"/"}},[n("img",{attrs:{src:t.logo}})])],1),n("div",{staticClass:"d-flex justify-content-center"},[n("search-box",{staticClass:"w-75"})],1)])},ht=[],mt=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.keyword="",e}return Object(s["c"])(e,t),Object.defineProperty(e.prototype,"title",{get:function(){return this.app.cafeName},enumerable:!1,configurable:!0}),Object.defineProperty(e.prototype,"logo",{get:function(){return this.app.cafeLogo},enumerable:!1,configurable:!0}),e.prototype.search=function(){console.log("search: keyword: ",this.keyword)},e=Object(s["b"])([Object(a["a"])({components:{SearchBox:E}})],e),e}(r["a"]),bt=mt,gt=bt,vt=Object(m["a"])(gt,pt,ht,!1,null,null,null),yt=vt.exports,Ot=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(s["c"])(e,t),e=Object(s["b"])([Object(a["a"])({components:{DesktopSearchBox:yt}})],e),e}(r["a"]),jt=Ot,wt=jt,_t=Object(m["a"])(wt,dt,ft,!1,null,null,null),xt=_t.exports,kt=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=d["a"].instance,e.api=ut["a"].instance,e}return Object(s["c"])(e,t),e.prototype.mounted=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t,e=this;return Object(s["d"])(this,(function(n){switch(n.label){case 0:this.app.portal(),n.label=1;case 1:return n.trys.push([1,3,,4]),[4,this.api.loadCafe()];case 2:return n.sent(),[3,4];case 3:return t=n.sent(),t===lt["a"].main_cafe_has_no_cafe_category_record?console.log(t):t===lt["a"].cafe_not_exists?this.app.error("@todo set dev environment to move to local main cafe"):this.app.error(t),[3,4];case 4:return O.afterEach((function(t){"PostList"==t.name||"PostView"==t.name||"Admin"==t.name?e.app.hideLeftSidebar():e.app.showLeftSidebar()})),[2]}}))}))},e=Object(s["b"])([Object(a["a"])({components:{TopMenuUser:I,MobileHeader:T,DesktopRightSidebar:et,DesktopMainMenuRight:ct,DesktopHeader:xt}})],e),e}(r["a"]),Ct=kt,It=Ct,Pt=Object(m["a"])(It,o,i,!1,null,null,null),St=Pt.exports,Dt=n("9483");Object(Dt["a"])("/service-worker.js",{ready:function(){console.log("App is being served from cache by a service worker.\nFor more details, visit https://goo.gl/AFskqB")},registered:function(){console.log("Service worker has been registered.")},cached:function(){console.log("Content has been cached for offline use.")},updatefound:function(){console.log("New content is downloading.")},updated:function(){console.log("New content is available; please refresh.")},offline:function(){console.log("No internet connection found. App is running in offline mode.")},error:function(t){console.error("Error during service worker registration:",t)}});var Lt=n("0613"),Ut=n("63e9"),At=n("cca8"),qt=n("7049"),Jt=n("40aa"),Et=n("f9bc"),Nt=n("b1fc"),Mt=n("b519"),$t=n("a166"),Rt=n("f7ca"),Tt=n("700c"),zt=n("a7e2"),Bt=n("dbbe"),Vt=n("ad5f"),Ht=(n("f9e3"),n("2dd8"),n("a78e")),Yt=n.n(Ht),Ft=n("8d76"),Qt=n.n(Ft),Gt=(n("8594"),n("d661"));r["a"].config.productionTip=!1,r["a"].use(Ut["a"]),r["a"].use(At["a"]),r["a"].use(qt["a"]),r["a"].use(Jt["a"]),r["a"].use(Et["a"]),r["a"].use(Nt["a"]),r["a"].use(Mt["a"]),r["a"].use($t["a"]),r["a"].use(Rt["a"]),r["a"].use(Tt["a"]),r["a"].use(zt["a"]),r["a"].use(Bt["a"]),r["a"].use(Vt["a"]);var Kt=d["a"].instance;r["a"].filter("t",Gt["d"]);var Wt=new r["a"]({router:O,store:Lt["a"],data:{a:"apple",landing:!0},render:function(t){return t(St)},mounted:function(){},methods:{aTag:function(t){this.$router.push(t).catch((function(){return null}))},changeLanguage:function(t){Kt.setCookie("language",t),location.reload()}}}).$mount("#app");Lt["a"].state.vm=Wt,Qt()("a").click((function(t){t.preventDefault(),Wt.aTag(Qt()(this).attr("href"))})),Qt()((function(){var t=Yt.a.get("language");t&&Qt()(".desktop-topmenu [name='language']").val(t)}))},d28a:function(t,e,n){"use strict";n.d(e,"g",(function(){return o})),n.d(e,"e",(function(){return i})),n.d(e,"b",(function(){return s})),n.d(e,"f",(function(){return c})),n.d(e,"c",(function(){return u})),n.d(e,"d",(function(){return l})),n.d(e,"a",(function(){return f}));n("b0c0"),n("ac1f"),n("1276"),n("d81d"),n("4de4"),n("c740"),n("a434"),n("a4d3"),n("e01a");var r=n("9ab4"),o=function(){function t(){this.idx="",this.sessionId="",this.email="",this.name="",this.nickname="",this.photoUrl="",this.admin=!1,this.point=0,this.firebaseUid="",this.phoneNo="",this.gender="",this.birthdate=0,this.countryCode="",this.province="",this.city="",this.address="",this.zipcode="",this.block=!1}return Object.defineProperty(t.prototype,"displayName",{get:function(){if(this.name)return this.name;if(this.nickname)return this.nickname;var t;if(this.email&&(t=this.email.split("@").shift()),!t)return this.idx+"xxx";var e=t.substring(0,t.length-3);return e+"xxx"},enumerable:!1,configurable:!0}),t.prototype.fromJson=function(t){return this.idx=t.idx,this.email=t.email,this.sessionId=t.sessionId,this.name=t.name,this.nickname=t.nickname,this.photoUrl=t.photoUrl,this.admin="Y"==t.admin,this.point=t.point,this.firebaseUid=t.firebaseUid,this.phoneNo=t.phoneNo,this.gender=t.gender,this.birthdate=t.birthdate,this.countryCode=t.countryCode,this.province=t.province,this.city=t.city,this.address=t.address,this.zipcode=t.zipcode,this.block="Y"==t.block,this},t}(),i=function(){function t(){this.idx="",this.title="",this.content="",this.categoryId="",this.files=""}return t}(),s=function(){function t(){this.idx="",this.content="",this.rootIdx="",this.parentIdx="",this.files=""}return t}(),a=function(){function t(){this.idx="",this.userIdx="",this.content="",this.shortDate="",this.Y=0,this.N=0,this.files=[],this.user={}}return t.prototype.fromJson=function(t){return this.idx=t.idx,this.userIdx=t.userIdx,this.content=t.content,this.shortDate=t.shortDate,this.Y=t.Y,this.N=t.N,t.user&&(this.user=(new o).fromJson(t.user)),t.files&&(this.files=t.files.map((function(t){return(new l).fromJson(t)}))),this},t.prototype.updateVoteCount=function(t){this.N=t.N,this.Y=t.Y},t}(),c=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.url="",e.path="",e.relativeUrl="",e.title="",e.categoryIdx="",e.noOfViews="",e.noOfComments="0",e.comments=[],e}return Object(r["c"])(e,t),e.prototype.fromJson=function(e){return this.url=e.url,this.path=e.path,this.relativeUrl=e.relativeUrl,this.title=e.title,this.categoryIdx=e.categoryIdx,this.noOfViews=e.noOfViews,this.comments=e.comments.filter((function(t){return"0"==t.deletedAt})).map((function(t){return(new u).fromJson(t)})),this.noOfComments=e.noOfComments,t.prototype.fromJson.call(this,e),this},e.prototype.insertComment=function(t){if(t.parentIdx==this.idx)this.comments.push(t);else{var e=this.comments.findIndex((function(e){return e.idx==t.parentIdx}));this.comments.splice(e+1,0,t)}},e.prototype.deleteComment=function(t){var e=this.comments.findIndex((function(e){return e.idx==t}));this.comments.splice(e,1)},e}(a),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.rootIdx="",e.parentIdx="",e.deletedAt="",e.depth="",e.inEdit=!1,e.inReply=!1,e}return Object(r["c"])(e,t),e.prototype.fromJson=function(e){return this.rootIdx=e.rootIdx,this.parentIdx=e.parentIdx,this.deletedAt=e.deletedAt,this.depth=e.depth,t.prototype.fromJson.call(this,e),this},e}(a),l=function(){function t(){this.idx="",this.url="",this.name="",this.path="",this.size="",this.code="",this.type="",this.entity="",this.userIdx="",this.taxonomy="",this.createdAt="",this.updatedAt=""}return t.prototype.fromJson=function(t){return this.idx=t.idx,this.url=t.url,this.name=t.name,this.path=t.path,this.size=t.size,this.code=t.code,this.type=t.type,this.entity=t.entity,this.userIdx=t.userIdx,this.taxonomy=t.taxonomy,this.createdAt=t.createdAt,this.updatedAt=t.updatedAt,this},t}(),d=function(){function t(){this.idx="",this.userIdx="",this.id="",this.title="",this.description="",this.domain=""}return t.prototype.fromJson=function(t){return this.idx=t.idx,this.userIdx=t.userIdx,this.id=t.id,this.title=t.title,this.description=t.description,this.domain=t.domain,this},t}(),f=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return Object(r["c"])(e,t),e}(d)},d661:function(t,e,n){"use strict";n.d(e,"d",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){return a})),n.d(e,"b",(function(){return c}));n("ac1f"),n("1276"),n("a15b"),n("4de4"),n("a434");var r=n("0613"),o=n("9f3a");function i(t){return t?r["a"].state.texts[t]?r["a"].state.texts[t][o["a"].instance.userLanguage]:t:""}function s(t){if(1===t.split(".").length)return t;var e=t.split(".");return e[1]+"."+e[2]}function a(t,e){var n=t.split(",");return n.indexOf(e)>=0?t:(n.push(e),n.filter((function(t){return!!t})).join(","))}function c(t,e){var n=t.split(","),r=n.indexOf(e);return r>=0&&n.splice(r,1),n.filter((function(t){return!!t})).join(",")}},d68b:function(t,e,n){"use strict";n.d(e,"a",(function(){return d}));var r=n("53ca"),o=(n("d3b7"),n("9ab4")),i=n("9f3a"),s=n("8d76"),a=n.n(s),c=n("c401"),u=n("0613"),l=n("d661"),d=function(){function t(){this.api=i["a"].instance,this.init()}return t.prototype.init=function(){return Object(o["a"])(this,void 0,Promise,(function(){return Object(o["d"])(this,(function(t){return console.log("AppService::init()"),u["a"].state.cafeSettings.mainMenus=c["a"].cafeSettings.mainMenus,this.api.loadCafeSettings(),[2]}))}))},Object.defineProperty(t.prototype,"cafeName",{get:function(){return"Root domain nmame or subdomain name?"},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"cafeLogo",{get:function(){return u["a"].state.cafeSettings.rootDomainSettings[this.api.rootDomain].logo},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"cafeMenus",{get:function(){return u["a"].state.cafeSettings.mainMenus},enumerable:!1,configurable:!0}),Object.defineProperty(t,"instance",{get:function(){return this._instance||(this._instance=new t),this._instance},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"loggedIn",{get:function(){return this.api.loggedIn},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"notLoggedIn",{get:function(){return this.api.notLoggedIn},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"user",{get:function(){return this.api.user},enumerable:!1,configurable:!0}),t.prototype.error=function(t){return Object(o["a"])(this,void 0,Promise,(function(){return Object(o["d"])(this,(function(e){return console.error("code: ",t,Object(r["a"])(t)),"string"===typeof t&&0===t.indexOf("error_")?[2,this.api.error(t)]:[2,this.api.alert(Object(l["d"])("error"),"Unknown error: "+t)]}))}))},t.prototype.removeAllChildNodes=function(t){while(null===t||void 0===t?void 0:t.firstChild)t.removeChild(t.firstChild)},t.prototype.hideLeftSidebar=function(){a()("#layout-left").removeClass("d-lg-block"),a()("#layout-content-right").removeClass("col-lg-9"),a()("#layout-content").removeClass("col-md-8").addClass("col-md-9"),a()("#layout-right").removeClass("col-md-4").addClass("col-md-3")},t.prototype.showLeftSidebar=function(){a()("#layout-left").addClass("d-lg-block"),a()("#layout-content-right").addClass("col-lg-9"),a()("#layout-content").addClass("col-md-8").removeClass("col-md-9"),a()("#layout-right").addClass("col-md-4").removeClass("col-md-3")},Object.defineProperty(t.prototype,"userLanguage",{get:function(){return this.api.userLanguage},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"rootDomain",{get:function(){return this.api.rootDomain},enumerable:!1,configurable:!0}),t.prototype.setCookie=function(t,e){return this.api.setCookie(t,e)},t.prototype.portal=function(){a()("[portal-to]").each((function(){var t=a()(this).attr("portal-to");a()("#"+t).empty().append(a()(this))}))},t.prototype.openCafe=function(t){this.open("//"+t)},t.prototype.open=function(t){location.href=t},t}()}});
//# sourceMappingURL=app.d3e9ed77.js.map