(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0cf888"],{"63b7":function(t,e,n){"use strict";n.r(e);var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"cafe-create p-2"},[n("h1",{staticClass:"alert alert-info"},[t._v(t._s(t._f("t")("create_cafe")))]),n("form",{on:{submit:function(e){return e.preventDefault(),t.onSubmit.apply(null,arguments)}}},[0==t.isCountryDomain?n("div",[n("div",[t._v(t._s(t._f("t")("country")))]),t.countries?n("select",{directives:[{name:"model",rawName:"v-model",value:t.form.countryCode,expression:"form.countryCode"}],on:{change:function(e){var n=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.form,"countryCode",e.target.multiple?n:n[0])}}},[n("option",{attrs:{value:""}},[t._v(t._s(t._f("t")("select_country")))]),t._l(t.countries,(function(e,r){return n("option",{key:r,domProps:{value:r}},[t._v(" "+t._s(e)+" ")])}))],2):t._e(),n("hr")]):t._e(),t._v(" https://"),n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.domain,expression:"form.domain"}],attrs:{size:"10"},domProps:{value:t.form.domain},on:{input:function(e){e.target.composing||t.$set(t.form,"domain",e.target.value)}}}),t._v("."+t._s(t.app.rootDomain)+" "),n("button",[t._v(t._s(t._f("t")("Create")))])]),t._v(" "+t._s(t.cafeSettings)+" ")])},o=[],a=(n("caad"),n("2532"),n("d3b7"),n("99af"),n("9ab4")),i=n("d68b"),s=n("2b0e"),c=n("2fe1"),u=function(t){function e(){var e=null!==t&&t.apply(this,arguments)||this;return e.app=i["a"].instance,e.countries={},e.cafeSettings={},e.form={countryCode:"",domain:"",rootDomain:""},e}return Object(a["c"])(e,t),Object.defineProperty(e.prototype,"isCountryDomain",{get:function(){var t;return!!(null===(t=this.cafeSettings.countryDomains)||void 0===t?void 0:t.includes(this.app.rootDomain))},enumerable:!1,configurable:!0}),e.prototype.mounted=function(){return Object(a["a"])(this,void 0,Promise,(function(){var t,e,n,r,o,i,s,c,u;return Object(a["d"])(this,(function(a){switch(a.label){case 0:return a.trys.push([0,3,,4]),t=this,n=(e=Object).assign,r=[{}],[4,this.app.api.loadCafeSettings()];case 1:return t.cafeSettings=n.apply(e,r.concat([a.sent()])),o=this,s=(i=Object).assign,c=[{}],[4,this.app.api.countryAll()];case 2:return o.countries=s.apply(i,c.concat([a.sent()])),[3,4];case 3:return u=a.sent(),this.app.error(u),[3,4];case 4:return[2]}}))}))},e.prototype.onSubmit=function(){return Object(a["a"])(this,void 0,Promise,(function(){var t;return Object(a["d"])(this,(function(e){switch(e.label){case 0:this.isCountryDomain&&(this.form.countryCode=this.cafeSettings.mainCafeSettings[this.app.rootDomain].countryCode),this.form.rootDomain=this.app.rootDomain,e.label=1;case 1:return e.trys.push([1,3,,4]),[4,this.app.createCafe(this.form)];case 2:return e.sent(),[3,4];case 3:return t=e.sent(),this.app.error(t),[3,4];case 4:return[2]}}))}))},e=Object(a["b"])([Object(c["b"])({})],e),e}(s["default"]),p=u,l=p,f=n("2877"),m=Object(f["a"])(l,r,o,!1,null,null,null);e["default"]=m.exports}}]);
//# sourceMappingURL=chunk-2d0cf888.f8261551.js.map