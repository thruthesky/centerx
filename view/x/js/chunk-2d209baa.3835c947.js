(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d209baa"],{a9fb:function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",[n("div",{staticClass:"d-flex justify-content-between mb-2"},[n("h4",[t._v(t._s(t._f("t")("category_list")))]),n("div",{staticClass:"btn btn-sm btn-info",on:{click:t.checkDefaultCategory}},[t._v(" Check Default Category ")])]),n("div",{staticClass:"container"},[n("div",{staticClass:"row"},[n("section",{staticClass:"w-100"},[n("admin-category-create")],1),n("table",{staticClass:"table table-striped mt-2"},[n("thead",{staticClass:"thead-dark"},[n("tr",{staticClass:"fs-sm"},[n("th",{attrs:{scope:"col"}},[t._v("#")]),n("th",{attrs:{scope:"col"}},[t._v("ID")]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("title")))]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("description")))]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("action")))])])]),n("tbody",t._l(t.categories,(function(e){return n("tr",{key:e.idx},[n("th",{attrs:{scope:"row"}},[n("router-link",{attrs:{to:"/forum/"+e.id}},[t._v(t._s(e.idx))])],1),n("td",[n("router-link",{attrs:{to:"/admin/category/edit/"+e.id}},[t._v(t._s(e.id)+" ")])],1),n("td",[n("span",[t._v(t._s(e.title))])]),n("td",[n("span",[t._v(" "+t._s(e.description)+" ")])]),n("td",{staticClass:"justify-content-center"},[n("div",{staticClass:"btn btn-sm btn-outline-danger",on:{click:function(n){return t.onClickDelete(e)}}},[t._v(" ❌ ")])])])})),0)]),n("div",{staticClass:"overflow-auto"},[n("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])])])},r=[],i=(n("d3b7"),n("c740"),n("a434"),n("9ab4")),a=n("9f3a"),c=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",[n("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit()}}},[n("div",{staticClass:"d-flex"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.id,expression:"id"}],staticClass:"form-control mb-2",attrs:{type:"text",placeholder:t._f("t")("enter_category_id")},domProps:{value:t.id},on:{input:function(e){e.target.composing||(t.id=e.target.value)}}}),n("button",{staticClass:"btn btn-primary ml-3 mb-2 w-50",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("create"))+" ")])])])])},o=[],u=(n("a4d3"),n("e01a"),n("2b0e")),l=n("2fe1"),d=n("f6b1"),h=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.s=d["b"].instance,e.category={},e.api=a["a"].instance,e.id="",e.title="",e.description="",e}return Object(i["c"])(e,t),e.prototype.onSubmit=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e;return Object(i["d"])(this,(function(n){switch(n.label){case 0:return n.trys.push([0,2,,3]),t=this,[4,a["a"].instance.categoryCreate({id:this.id})];case 1:return t.category=n.sent(),console.log(this.category),this.s.open("/admin/category/edit/"+this.category.id),[3,3];case 2:return e=n.sent(),"error_category_exists"==e?this.s.open("/admin/category/edit/"+this.id):this.s.error(e),[3,3];case 3:return[2]}}))}))},e=Object(i["b"])([Object(l["b"])({})],e),e}(u["default"]),f=h,b=f,p=n("2877"),g=Object(p["a"])(b,c,o,!1,null,null,null),m=g.exports,v=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.categories=[],e.s=d["b"].instance,e.limit=5,e.noOfPages=10,e.currentPage="1",e.total=0,e}return Object(i["c"])(e,t),e.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},e.prototype.onPageChanged=function(t){this.currentPage=""+t,this.onSubmitSearch()},e.prototype.mounted=function(){this.onSubmitSearch()},e.prototype.onSubmitSearch=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(i["d"])(this,(function(s){switch(s.label){case 0:return s.trys.push([0,3,,4]),t=this,[4,a["a"].instance.categorySearch({limit:this.limit,page:this.currentPage})];case 1:return t.categories=s.sent(),e=this,[4,a["a"].instance.categoryCount({})];case 2:return e.total=s.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,4];case 3:return n=s.sent(),this.s.error(n),[3,4];case 4:return[2]}}))}))},e.prototype.onClickDelete=function(t){return Object(i["a"])(this,void 0,Promise,(function(){var e,n,s,r;return Object(i["d"])(this,(function(i){switch(i.label){case 0:if(e=confirm("Delete the category?"),!e)return[2];i.label=1;case 1:return i.trys.push([1,3,,4]),[4,a["a"].instance.categoryDelete({idx:t.idx})];case 2:return n=i.sent(),s=this.categories.findIndex((function(t){return t.idx==n.idx})),-1!=s&&this.categories.splice(s,1),[3,4];case 3:return r=i.sent(),this.s.error(r),[3,4];case 4:return[2]}}))}))},e.prototype.checkDefaultCategory=function(){return Object(i["a"])(this,void 0,Promise,(function(){var t,e,n,s,r;return Object(i["d"])(this,(function(i){switch(i.label){case 0:return i.trys.push([0,2,,3]),[4,a["a"].instance.cafeInitDefautMenu()];case 1:for(s in t=i.sent(),e=0,n=0,t)s?e++:n++;return this.s.alert("Default Menus: ",e+" Okay Menus. "+n+" Error Menus"),[3,3];case 2:return r=i.sent(),this.s.error(r),[3,3];case 3:return[2]}}))}))},e=Object(i["b"])([Object(l["b"])({components:{AdminCategoryCreate:m}})],e),e}(u["default"]),y=v,_=y,C=Object(p["a"])(_,s,r,!1,null,null,null);e["default"]=C.exports}}]);
//# sourceMappingURL=chunk-2d209baa.3835c947.js.map