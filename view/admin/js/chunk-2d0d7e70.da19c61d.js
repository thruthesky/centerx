(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0d7e70"],{7991:function(t,e,a){"use strict";a.r(e);var o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("section",[a("h1",[t._v(t._s(t._f("t")("category_edit")))]),a("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit()}}},[a("table",{staticClass:"table"},[a("thead",{staticClass:"fs-sm"},[a("tr",{staticClass:"thead-light"},[a("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("option")))]),a("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("setting")))])])]),a("tbody",[a("tr",[a("td",[t._v(t._s(t._f("t")("category_id")))]),a("td",[t._v(t._s(t.category.id))])]),a("tr",[a("td",[t._v(t._s(t._f("t")("title")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.title,expression:"category.title"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.category.title},on:{input:function(e){e.target.composing||t.$set(t.category,"title",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("description")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.description,expression:"category.description"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.category.description},on:{input:function(e){e.target.composing||t.$set(t.category,"description",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("domain")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.domain,expression:"category.domain"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.category.domain},on:{input:function(e){e.target.composing||t.$set(t.category,"domain",e.target.value)}}})])]),a("tr",{staticClass:"table-dark fs-sm"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("subcategories")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("subcategories_hint"))+" ")])])]),a("tr",[a("td",{attrs:{colspan:"2"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.category.subcategories,expression:"category.subcategories"}],staticClass:"w-100 form-control",attrs:{rows:"3",name:"subcategories"},domProps:{value:t.category.subcategories},on:{input:function(e){e.target.composing||t.$set(t.category,"subcategories",e.target.value)}}})])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("point_settings")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("point_settings_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_create_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createPost,expression:"category.createPost"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.createPost},on:{input:function(e){e.target.composing||t.$set(t.category,"createPost",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_delete_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.deletePost,expression:"category.deletePost"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.deletePost},on:{input:function(e){e.target.composing||t.$set(t.category,"deletePost",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_create_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createComment,expression:"category.createComment"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.createComment},on:{input:function(e){e.target.composing||t.$set(t.category,"createComment",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_delete_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.deleteComment,expression:"category.deleteComment"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.deleteComment},on:{input:function(e){e.target.composing||t.$set(t.category,"deleteComment",e.target.value)}}})])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("limit_by_hour_day")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("limit_by_hour_day_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("hour_count_limit")))]),a("td",{staticClass:"d-flex align-items-center"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createHourLimit,expression:"category.createHourLimit"}],staticClass:"w-25 form-control",attrs:{type:"number",placeholder:t._f("t")("create_hour_limit")},domProps:{value:t.category.createHourLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"createHourLimit",e.target.value)}}}),a("span",{staticClass:"mx-2"},[t._v("/")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createHourLimitCount,expression:"category.createHourLimitCount"}],staticClass:"w-25 form-control",attrs:{type:"number",placeholder:t._f("t")("create_hour_limit_count")},domProps:{value:t.category.createHourLimitCount},on:{input:function(e){e.target.composing||t.$set(t.category,"createHourLimitCount",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("day_count_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createDailyLimitCount,expression:"category.createDailyLimitCount"}],staticClass:"w-25 form-control",attrs:{type:"number"},domProps:{value:t.category.createDailyLimitCount},on:{input:function(e){e.target.composing||t.$set(t.category,"createDailyLimitCount",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("ban_on_writing")))]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.banCreateOnLimit,expression:"category.banCreateOnLimit"}],attrs:{type:"radio",value:"Y"},domProps:{checked:t._q(t.category.banCreateOnLimit,"Y")},on:{change:function(e){return t.$set(t.category,"banCreateOnLimit","Y")}}}),t._v(" "+t._s(t._f("t")("yes"))+", ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.banCreateOnLimit,expression:"category.banCreateOnLimit"}],attrs:{type:"radio",value:"N"},domProps:{checked:t._q(t.category.banCreateOnLimit,"N")},on:{change:function(e){return t.$set(t.category,"banCreateOnLimit","N")}}}),t._v(" "+t._s(t._f("t")("no"))+" ")])])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("limit_by_point_possession")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("limit_by_point_possession_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_create_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postCreateLimit,expression:"category.postCreateLimit"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.postCreateLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"postCreateLimit",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_create_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.commentCreateLimit,expression:"category.commentCreateLimit"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.commentCreateLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"commentCreateLimit",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_comment_read_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.readLimit,expression:"category.readLimit"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.readLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"readLimit",e.target.value)}}})])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("return_to")))])]),a("tr",[a("td",[t._v(t._s(t._f("t")("return_to_after_edit")))]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.returnToAfterPostEdit,expression:"category.returnToAfterPostEdit"}],attrs:{type:"radio",value:"V"},domProps:{checked:t._q(t.category.returnToAfterPostEdit,"V")},on:{change:function(e){return t.$set(t.category,"returnToAfterPostEdit","V")}}}),t._v(" "+t._s(t._f("t")("Post view page"))+" ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.returnToAfterPostEdit,expression:"category.returnToAfterPostEdit"}],attrs:{type:"radio",value:"L"},domProps:{checked:t._q(t.category.returnToAfterPostEdit,"L")},on:{change:function(e){return t.$set(t.category,"returnToAfterPostEdit","L")}}}),t._v(" "+t._s(t._f("t")("Post list page"))+" ")])])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("widgets_web")))])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Post Edit Widget")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postEditWidget,expression:"category.postEditWidget"}],staticClass:"form-control",domProps:{value:t.category.postEditWidget},on:{input:function(e){e.target.composing||t.$set(t.category,"postEditWidget",e.target.value)}}})])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("Input post edit widget options"))+" ")])])]),a("tr",[a("td",{attrs:{colspan:"2"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.category.postEditWidgetOption,expression:"category.postEditWidgetOption"}],staticClass:"w-100",attrs:{rows:"5"},domProps:{value:t.category.postEditWidgetOption},on:{input:function(e){e.target.composing||t.$set(t.category,"postEditWidgetOption",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Post View Widget")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postViewWidget,expression:"category.postViewWidget"}],staticClass:"form-control",domProps:{value:t.category.postViewWidget},on:{input:function(e){e.target.composing||t.$set(t.category,"postViewWidget",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Header")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postListHeaderWidget,expression:"category.postListHeaderWidget"}],staticClass:"form-control",domProps:{value:t.category.postListHeaderWidget},on:{input:function(e){e.target.composing||t.$set(t.category,"postListHeaderWidget",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Widget")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postListWidget,expression:"category.postListWidget"}],staticClass:"form-control",domProps:{value:t.category.postListWidget},on:{input:function(e){e.target.composing||t.$set(t.category,"postListWidget",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Pagination Widget")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.paginationWidget,expression:"category.paginationWidget"}],staticClass:"form-control",domProps:{value:t.category.paginationWidget},on:{input:function(e){e.target.composing||t.$set(t.category,"paginationWidget",e.target.value)}}})])]),a("tr",[a("td",[t._v(" "+t._s(t._f("t")("Post list under view page"))+" ")]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.listOnView,expression:"category.listOnView"}],attrs:{type:"radio",value:"Y"},domProps:{checked:t._q(t.category.listOnView,"Y")},on:{change:function(e){return t.$set(t.category,"listOnView","Y")}}}),t._v(" "+t._s(t._f("t")("yes"))+", ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.listOnView,expression:"category.listOnView"}],attrs:{type:"radio",value:"N"},domProps:{checked:t._q(t.category.listOnView,"N")},on:{change:function(e){return t.$set(t.category,"listOnView","N")}}}),t._v(" "+t._s(t._f("t")("no"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("No of posts per page")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.noOfPostsPerPage,expression:"category.noOfPostsPerPage"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.noOfPostsPerPage},on:{input:function(e){e.target.composing||t.$set(t.category,"noOfPostsPerPage",e.target.value)}}})])]),a("tr",[a("td",{attrs:{nowrap:""}},[t._v(" "+t._s(t._f("t")("No of pages on navigator"))+" ")]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.noOfPagesOnNav,expression:"category.noOfPagesOnNav"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.noOfPagesOnNav},on:{input:function(e){e.target.composing||t.$set(t.category,"noOfPagesOnNav",e.target.value)}}})])]),a("tr",[a("td",{attrs:{colspan:"2"}},[a("button",{staticClass:"btn btn-sm btn-success w-100",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])])])])])])])},r=[],s=a("1da1"),i=a("d4ec"),n=a("bee2"),c=a("262e"),d=a("2caf"),m=(a("a4d3"),a("e01a"),a("96cf"),a("9ab4")),l=a("9f3a"),g=a("2b0e"),u=a("2fe1"),p=a("f6b1"),v=function(t){Object(c["a"])(a,t);var e=Object(d["a"])(a);function a(){var t;return Object(i["a"])(this,a),t=e.apply(this,arguments),t.category={},t.s=p["a"].instance,t}return Object(n["a"])(a,[{key:"mounted",value:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,l["a"].instance.categoryGet({id:null!==(e=this.$route.params.categoryId)&&void 0!==e?e:0});case 3:this.category=t.sent,t.next=9;break;case 6:t.prev=6,t.t0=t["catch"](0),this.s.error(t.t0);case 9:case"end":return t.stop()}}),t,this,[[0,6]])})));function e(){return t.apply(this,arguments)}return e}()},{key:"onSubmit",value:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return e={id:this.category.id,title:this.category.title,description:this.category.description,subcategories:this.category.subcategories,createPost:this.category.createPost,deletePost:this.category.deletePost,createComment:this.category.createComment,deleteComment:this.category.deleteComment,createHourLimit:this.category.createHourLimit,createHourLimitCount:this.category.createHourLimitCount,createDailyLimitCount:this.category.createDailyLimitCount,banCreateOnLimit:this.category.banCreateOnLimit,postCreateLimit:this.category.postCreateLimit,commentCreateLimit:this.category.commentCreateLimit,readLimit:this.category.readLimit,returnToAfterPostEdit:this.category.returnToAfterPostEdit,postEditWidget:this.category.postEditWidget,postEditWidgetOption:this.category.postEditWidgetOption,postViewWidget:this.category.postViewWidget,postListHeaderWidget:this.category.postListHeaderWidget,postListWidget:this.category.postListWidget,paginationWidget:this.category.paginationWidget,listOnView:this.category.listOnView,noOfPostsPerPage:this.category.noOfPostsPerPage,noOfPagesOnNav:this.category.noOfPagesOnNav,domain:this.category.domain},t.prev=1,t.next=4,l["a"].instance.categoryUpdate(e);case 4:this.category=t.sent,this.s.alert("Category Update : ","Update Success"),t.next=11;break;case 8:t.prev=8,t.t0=t["catch"](1),this.s.error(t.t0);case 11:case"end":return t.stop()}}),t,this,[[1,8]])})));function e(){return t.apply(this,arguments)}return e}()}]),a}(g["default"]);v=Object(m["a"])([Object(u["b"])({components:{}})],v);var _=v,y=_,f=a("2877"),C=Object(f["a"])(y,o,r,!1,null,null,null);e["default"]=C.exports}}]);
//# sourceMappingURL=chunk-2d0d7e70.da19c61d.js.map