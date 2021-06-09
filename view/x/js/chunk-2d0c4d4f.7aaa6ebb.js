(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c4d4f"],{"3d08":function(t,e,a){"use strict";a.r(e);var o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("section",[a("h1",[t._v("Admin Category Edit")]),a("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit()}}},[a("table",{staticClass:"table"},[a("thead",{staticClass:"fs-sm"},[a("tr",{staticClass:"thead-light"},[a("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("option")))]),a("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("setting")))])])]),a("tbody",[a("tr",[a("td",[t._v(t._s(t._f("t")("category_id")))]),a("td",[t._v(" "+t._s(t.category.id)+" ")])]),a("tr",[a("td",[t._v(t._s(t._f("t")("title")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.title,expression:"category.title"}],staticClass:"form-control",domProps:{value:t.category.title},on:{input:function(e){e.target.composing||t.$set(t.category,"title",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("description")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.description,expression:"category.description"}],staticClass:"form-control",domProps:{value:t.category.description},on:{input:function(e){e.target.composing||t.$set(t.category,"description",e.target.value)}}})])]),a("tr",{staticClass:"table-dark fs-sm"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("subcategories")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("subcategories_hint"))+" ")])])]),t._m(0),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("point_settings")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("point_settings_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_create_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createPost,expression:"category.createPost"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.createPost},on:{input:function(e){e.target.composing||t.$set(t.category,"createPost",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_delete_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.deletePost,expression:"category.deletePost"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.deletePost},on:{input:function(e){e.target.composing||t.$set(t.category,"deletePost",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_create_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createComment,expression:"category.createComment"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.createComment},on:{input:function(e){e.target.composing||t.$set(t.category,"createComment",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_delete_point")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.deleteComment,expression:"category.deleteComment"}],staticClass:"form-control",attrs:{type:"number"},domProps:{value:t.category.deleteComment},on:{input:function(e){e.target.composing||t.$set(t.category,"deleteComment",e.target.value)}}})])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("limit_by_hour_day")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("limit_by_hour_day_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("hour_count_limit")))]),a("td",{staticClass:"d-flex align-items-center"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createHourLimit,expression:"category.createHourLimit"}],staticClass:"w-25 form-control",attrs:{type:"number"},domProps:{value:t.category.createHourLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"createHourLimit",e.target.value)}}}),a("span",{staticClass:"mx-2"},[t._v("/")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createHourLimitCount,expression:"category.createHourLimitCount"}],staticClass:"w-25 form-control",attrs:{type:"number"},domProps:{value:t.category.createHourLimitCount},on:{input:function(e){e.target.composing||t.$set(t.category,"createHourLimitCount",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("day_count_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.createDailyLimitCount,expression:"category.createDailyLimitCount"}],staticClass:"w-25 form-control",attrs:{type:"number"},domProps:{value:t.category.createDailyLimitCount},on:{input:function(e){e.target.composing||t.$set(t.category,"createDailyLimitCount",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("ban_on_writing")))]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.banCreateOnLimit,expression:"category.banCreateOnLimit"}],attrs:{type:"radio",value:"Y"},domProps:{checked:t._q(t.category.banCreateOnLimit,"Y")},on:{change:function(e){return t.$set(t.category,"banCreateOnLimit","Y")}}}),t._v(" "+t._s(t._f("t")("yes"))+", ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.banCreateOnLimit,expression:"category.banCreateOnLimit"}],attrs:{type:"radio",value:"N"},domProps:{checked:t._q(t.category.banCreateOnLimit,"N")},on:{change:function(e){return t.$set(t.category,"banCreateOnLimit","N")}}}),t._v(" "+t._s(t._f("t")("no"))+" ")])])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("limit_by_point_possession")))])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("limit_by_point_possession_hint"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_create_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.postCreateLimit,expression:"category.postCreateLimit"}],staticClass:"form-control",domProps:{value:t.category.postCreateLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"postCreateLimit",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("comment_create_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.commentCreateLimit,expression:"category.commentCreateLimit"}],staticClass:"form-control",domProps:{value:t.category.commentCreateLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"commentCreateLimit",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("post_comment_read_limit")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.readLimit,expression:"category.readLimit"}],staticClass:"form-control",domProps:{value:t.category.readLimit},on:{input:function(e){e.target.composing||t.$set(t.category,"readLimit",e.target.value)}}})])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("return_to")))])]),a("tr",[a("td",[t._v(t._s(t._f("t")("return_to_after_edit")))]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.returnToAfterPostEdit,expression:"category.returnToAfterPostEdit"}],attrs:{type:"radio",value:"V"},domProps:{checked:t._q(t.category.returnToAfterPostEdit,"V")},on:{change:function(e){return t.$set(t.category,"returnToAfterPostEdit","V")}}}),t._v(" "+t._s(t._f("t")("Post view page"))+" ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.returnToAfterPostEdit,expression:"category.returnToAfterPostEdit"}],attrs:{type:"radio",value:"L"},domProps:{checked:t._q(t.category.returnToAfterPostEdit,"L")},on:{change:function(e){return t.$set(t.category,"returnToAfterPostEdit","L")}}}),t._v(" "+t._s(t._f("t")("Post list page"))+" ")])])]),a("tr",{staticClass:"table-dark"},[a("td",{attrs:{colspan:"2"}},[t._v(t._s(t._f("t")("widgets_web")))])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Post Edit Widget")))]),a("td",[t._v("@todo postEditWidget")])]),a("tr",{staticClass:"table-light"},[a("td",{attrs:{colspan:"2"}},[a("div",{staticClass:"hint"},[t._v(" "+t._s(t._f("t")("Input post edit widget options"))+" ")])])]),a("tr",[a("td",{attrs:{colspan:"2"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.category.postEditWidgetOptio,expression:"category.postEditWidgetOptio"}],staticClass:"w-100",attrs:{rows:"5"},domProps:{value:t.category.postEditWidgetOptio},on:{input:function(e){e.target.composing||t.$set(t.category,"postEditWidgetOptio",e.target.value)}}})])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Post View Widget")))]),a("td",[t._v("@todo postViewWidget")])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Header")))]),a("td",[t._v("@todo postListHeaderWidget")])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Widget")))]),a("td",[t._v("@todo postListWidget")])]),a("tr",[a("td",[t._v(t._s(t._f("t")("Forum List Pagination Widget")))]),a("td",[t._v("@todo paginationWidget")])]),a("tr",[a("td",[t._v(" "+t._s(t._f("t")("Post list under view page"))+" ")]),a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.listOnView,expression:"category.listOnView"}],attrs:{type:"radio",value:"Y"},domProps:{checked:t._q(t.category.listOnView,"Y")},on:{change:function(e){return t.$set(t.category,"listOnView","Y")}}}),t._v(" "+t._s(t._f("t")("yes"))+", ")]),t._v("   "),a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.listOnView,expression:"category.listOnView"}],attrs:{type:"radio",value:"N"},domProps:{checked:t._q(t.category.listOnView,"N")},on:{change:function(e){return t.$set(t.category,"listOnView","N")}}}),t._v(" "+t._s(t._f("t")("no"))+" ")])])]),a("tr",[a("td",[t._v(t._s(t._f("t")("No of posts per page")))]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.noOfPostsPerPage,expression:"category.noOfPostsPerPage"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.category.noOfPostsPerPage},on:{input:function(e){e.target.composing||t.$set(t.category,"noOfPostsPerPage",e.target.value)}}})])]),a("tr",[a("td",{attrs:{nowrap:""}},[t._v(" "+t._s(t._f("t")("No of pages on navigator"))+" ")]),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.category.noOfPagesOnNav,expression:"category.noOfPagesOnNav"}],staticClass:"form-control",attrs:{type:"text"},domProps:{value:t.category.noOfPagesOnNav},on:{input:function(e){e.target.composing||t.$set(t.category,"noOfPagesOnNav",e.target.value)}}})])]),a("tr",[a("td",{attrs:{colspan:"2"}},[a("button",{staticClass:"btn btn-sm btn-success w-100",attrs:{"data-cy":"form-submit",type:"submit"}},[t._v(" "+t._s(t._f("t")("submit"))+" ")])])])])])])])},r=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"2"}},[a("textarea",{staticClass:"w-100 form-control",attrs:{rows:"3",name:"subcategories"}})])])}],s=(a("d3b7"),a("a4d3"),a("e01a"),a("9ab4")),i=a("d68b"),n=a("9f3a"),c=a("2b0e"),l=a("2fe1"),d=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.category={},e.app=i["a"].instance,e}return Object(s["c"])(e,t),e.prototype.mounted=function(){var t;return Object(s["a"])(this,void 0,Promise,(function(){var e,a,o;return Object(s["d"])(this,(function(r){switch(r.label){case 0:console.log("AdminCategoryEdit::mounted(); "),e={id:null!==(t=this.$route.params.categoryId)&&void 0!==t?t:0},r.label=1;case 1:return r.trys.push([1,3,,4]),console.log(e),a=this,[4,n["a"].instance.categoryGet(e)];case 2:return a.category=r.sent(),console.log(this.category),[3,4];case 3:return o=r.sent(),this.app.error(o),[3,4];case 4:return[2]}}))}))},e.prototype.onSubmit=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t,e,a;return Object(s["d"])(this,(function(o){switch(o.label){case 0:t={id:this.category.id,title:this.category.title,description:this.category.description},console.log("onsubmit"),console.log(t),o.label=1;case 1:return o.trys.push([1,3,,4]),e=this,[4,n["a"].instance.categoryUpdate(t)];case 2:return e.category=o.sent(),alert("Update Success"),console.log(this.category),[3,4];case 3:return a=o.sent(),this.app.error(a),[3,4];case 4:return[2]}}))}))},e=Object(s["b"])([Object(l["a"])({components:{}})],e),e}(c["a"]),m=d,u=m,g=a("2877"),p=Object(g["a"])(u,o,r,!1,null,null,null);e["default"]=p.exports}}]);
//# sourceMappingURL=chunk-2d0c4d4f.7aaa6ebb.js.map