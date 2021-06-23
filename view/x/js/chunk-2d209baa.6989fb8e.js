(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d209baa"],{a9fb:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",[n("div",{staticClass:"d-flex justify-content-between mb-2"},[n("h4",[t._v(t._s(t._f("t")("category_list")))]),n("div",{staticClass:"btn btn-sm btn-info",on:{click:t.checkDefaultCategory}},[t._v(" Check Default Category ")])]),n("div",{staticClass:"container"},[n("div",{staticClass:"row"},[n("section",{staticClass:"w-100"},[n("admin-category-create")],1),n("table",{staticClass:"table table-striped mt-2"},[n("thead",{staticClass:"thead-dark"},[n("tr",{staticClass:"fs-sm"},[n("th",{attrs:{scope:"col"}},[t._v("#")]),n("th",{attrs:{scope:"col"}},[t._v("ID")]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("title")))]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("description")))]),n("th",{attrs:{scope:"col"}},[t._v(t._s(t._f("t")("action")))])])]),n("tbody",t._l(t.categories,(function(e){return n("tr",{key:e.idx},[n("th",{attrs:{scope:"row"}},[n("router-link",{attrs:{to:"/forum/"+e.id}},[t._v(t._s(e.idx))])],1),n("td",[n("router-link",{attrs:{to:"/admin/category/edit/"+e.id}},[t._v(t._s(e.id)+" ")])],1),n("td",[n("span",[t._v(t._s(e.title))])]),n("td",[n("span",[t._v(" "+t._s(e.description)+" ")])]),n("td",{staticClass:"justify-content-center"},[n("div",{staticClass:"btn btn-sm btn-outline-danger",on:{click:function(n){return t.onClickDelete(e)}}},[t._v(" ❌ ")])])])})),0)]),n("div",{staticClass:"overflow-auto"},[n("b-pagination-nav",{attrs:{"link-gen":t.linkGen,"number-of-pages":t.noOfPages,"use-router":""},on:{change:t.onPageChanged},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}})],1)])])])},r=[],s=(n("d3b7"),n("c740"),n("a434"),n("9ab4")),i=n("9f3a"),c=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("section",[n("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit()}}},[n("div",{staticClass:"d-flex"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.id,expression:"id"}],staticClass:"form-control mb-2",attrs:{type:"text",placeholder:t._f("t")("enter_category_id")},domProps:{value:t.id},on:{input:function(e){e.target.composing||(t.id=e.target.value)}}}),n("button",{staticClass:"btn btn-primary ml-3 mb-2 w-50",attrs:{type:"submit"}},[t._v(" "+t._s(t._f("t")("create"))+" ")])])])])},o=[],u=(n("a4d3"),n("e01a"),n("2b0e")),l=n("2fe1"),d=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.category={},e.api=i["a"].instance,e.id="",e.title="",e.description="",e}return Object(s["c"])(e,t),e.prototype.onSubmit=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t,e;return Object(s["d"])(this,(function(n){switch(n.label){case 0:console.log("categoryUpdate:: create"),n.label=1;case 1:return n.trys.push([1,3,,4]),t=this,[4,i["a"].instance.categoryCreate({id:this.id})];case 2:return t.category=n.sent(),console.log(this.category),this.api.open({path:"/admin/category/edit/"+this.category.id}),[3,4];case 3:return e=n.sent(),"error_category_exists"==e?this.api.open({path:"/admin/category/edit/"+this.id}):this.api.error(e),[3,4];case 4:return[2]}}))}))},e=Object(s["b"])([Object(l["b"])({})],e),e}(u["default"]),h=d,f=h,p=n("2877"),b=Object(p["a"])(f,c,o,!1,null,null,null),g=b.exports,m=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.categories=[],e.limit=5,e.noOfPages=10,e.currentPage="1",e.total=0,e}return Object(s["c"])(e,t),e.prototype.linkGen=function(t){return 1===t?"?":"?page="+t},e.prototype.onPageChanged=function(t){this.currentPage=""+t,this.onSubmitSearch()},e.prototype.mounted=function(){this.onSubmitSearch()},e.prototype.onSubmitSearch=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t,e,n;return Object(s["d"])(this,(function(a){switch(a.label){case 0:return a.trys.push([0,3,,4]),t=this,[4,i["a"].instance.categorySearch({limit:this.limit,page:this.currentPage})];case 1:return t.categories=a.sent(),e=this,[4,i["a"].instance.categoryCount({})];case 2:return e.total=a.sent(),this.noOfPages=Math.ceil(this.total/this.limit),[3,4];case 3:return n=a.sent(),i["a"].instance.error(n),[3,4];case 4:return[2]}}))}))},e.prototype.onClickDelete=function(t){return Object(s["a"])(this,void 0,Promise,(function(){var e,n,a,r;return Object(s["d"])(this,(function(s){switch(s.label){case 0:if(e=confirm("Delete the category?"),!e)return[2];console.log(e),s.label=1;case 1:return s.trys.push([1,3,,4]),[4,i["a"].instance.categoryDelete({idx:t.idx})];case 2:return n=s.sent(),a=this.categories.findIndex((function(t){return t.idx==n.idx})),-1!=a&&this.categories.splice(a,1),console.log(n),[3,4];case 3:return r=s.sent(),i["a"].instance.error(r),[3,4];case 4:return[2]}}))}))},e.prototype.checkDefaultCategory=function(){return Object(s["a"])(this,void 0,Promise,(function(){var t,e,n,a,r;return Object(s["d"])(this,(function(s){switch(s.label){case 0:return s.trys.push([0,2,,3]),[4,i["a"].instance.cafeInitDefautMenu()];case 1:for(a in t=s.sent(),e=0,n=0,t)a?e++:n++;return i["a"].instance.alert("Default Menus",e+" Okay Menus. "+n+" Error Menus"),console.log(t),[3,3];case 2:return r=s.sent(),i["a"].instance.error(r),[3,3];case 3:return[2]}}))}))},e=Object(s["b"])([Object(l["b"])({components:{AdminCategoryCreate:g}})],e),e}(u["default"]),v=m,y=v,_=Object(p["a"])(y,a,r,!1,null,null,null);e["default"]=_.exports}}]);
//# sourceMappingURL=chunk-2d209baa.6989fb8e.js.map