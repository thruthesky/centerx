(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0e2175"],{"7ce8":function(t,o,s){"use strict";s.r(o);var e=function(){var t=this,o=t.$createElement,s=t._self._c||o;return s("section",{attrs:{"data-cy":"push-notification-create-page"}},[s("h4",[t._v(t._s(t._f("t")("push_notification")))]),s("form",[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"status"}},[t._v(t._s(t._f("t")("sending_option")))]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.options.notify,expression:"options.notify"}],staticClass:"custom-select",attrs:{id:"notify",name:"notify"},on:{change:function(o){var s=Array.prototype.filter.call(o.target.options,(function(t){return t.selected})).map((function(t){var o="_value"in t?t._value:t.value;return o}));t.$set(t.options,"notify",o.target.multiple?s:s[0])}}},[s("option",{attrs:{value:"all"}},[t._v(t._s(t._f("t")("all")))]),s("option",{attrs:{value:"topic"}},[t._v(t._s(t._f("t")("topic")))]),s("option",{attrs:{value:"tokens"}},[t._v(t._s(t._f("t")("tokens")))]),s("option",{attrs:{value:"emails"}},[t._v(t._s(t._f("t")("emails")))])])]),"topic"==t.options.notify?s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"topic"}},[t._v(t._s(t._f("t")("topic")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.topic,expression:"options.topic"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("topic"),name:"topic",id:"topic"},domProps:{value:t.options.topic},on:{input:function(o){o.target.composing||t.$set(t.options,"topic",o.target.value)}}})]):t._e(),"tokens"==t.options.notify?s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"tokens"}},[t._v(t._s(t._f("t")("tokens")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.tokens,expression:"options.tokens"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("token"),name:"tokens",id:"tokens"},domProps:{value:t.options.tokens},on:{input:function(o){o.target.composing||t.$set(t.options,"tokens",o.target.value)}}})]):t._e(),"emails"==t.options.notify?s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"emails"}},[t._v(t._s(t._f("t")("emails")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.emails,expression:"options.emails"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("emails"),name:"emails",id:"emails"},domProps:{value:t.options.emails},on:{input:function(o){o.target.composing||t.$set(t.options,"emails",o.target.value)}}}),s("div",{staticClass:"text-muted"},[t._v(" "+t._s("push_notification_emails_help")+" ")])]):t._e(),"emails"==t.options.notify?s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"users"}},[t._v(t._s(t._f("t")("users")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.users,expression:"options.users"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("users"),name:"users",id:"users"},domProps:{value:t.options.users},on:{input:function(o){o.target.composing||t.$set(t.options,"users",o.target.value)}}}),s("div",{staticClass:"text-muted"},[t._v(" "+t._s("push_notification_idxs_help")+" ")])]):t._e(),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"idx"}},[t._v(t._s(t._f("t")("landing post idx")))]),s("div",{staticClass:"input-group"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.idx,expression:"options.idx"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("post idx"),name:"idx",id:"idx"},domProps:{value:t.options.idx},on:{input:function(o){o.target.composing||t.$set(t.options,"idx",o.target.value)}}}),s("div",{staticClass:"input-group-append"},[s("button",{staticClass:"btn btn-outline-secondary px-5",attrs:{type:"button"},on:{click:function(o){return t.loadPostIdx()}}},[t._v(" "+t._s(t._f("t")("load_post_idx"))+" ")])])])]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"title"}},[t._v(t._s(t._f("t")("title")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.title,expression:"options.title"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("title"),name:"title",id:"title"},domProps:{value:t.options.title},on:{input:function(o){o.target.composing||t.$set(t.options,"title",o.target.value)}}})]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"idx"}},[t._v(t._s(t._f("t")("content")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.body,expression:"options.body"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("content"),name:"body",id:"body"},domProps:{value:t.options.body},on:{input:function(o){o.target.composing||t.$set(t.options,"body",o.target.value)}}})]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"click_action"}},[t._v(t._s(t._f("t")("click_url")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.click_action,expression:"options.click_action"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("click_url"),name:"click_action",id:"click_action"},domProps:{value:t.options.click_action},on:{input:function(o){o.target.composing||t.$set(t.options,"click_action",o.target.value)}}})]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"imageUrl"}},[t._v(t._s(t._f("t")("icon_url")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.imageUrl,expression:"options.imageUrl"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("icon_url"),name:"imageUrl",id:"imageUrl"},domProps:{value:t.options.imageUrl},on:{input:function(o){o.target.composing||t.$set(t.options,"imageUrl",o.target.value)}}}),s("small",{staticClass:"form-text text-muted"},[t._v(" "+t._s("push_message_icon_url_help")+" ")])]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"sound"}},[t._v(t._s(t._f("t")("sound")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.sound,expression:"options.sound"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("sound"),name:"sound",id:"sound"},domProps:{value:t.options.sound},on:{input:function(o){o.target.composing||t.$set(t.options,"sound",o.target.value)}}}),s("div",{staticClass:"text-muted"},[t._v(" "+t._s("push_notification_sound_help")+" ")])]),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"channel"}},[t._v(t._s(t._f("t")("channel_id")))]),s("input",{directives:[{name:"model",rawName:"v-model",value:t.options.channel,expression:"options.channel"}],staticClass:"form-control",attrs:{type:"text",placeholder:t._f("t")("channel_id"),name:"channel",id:"channel"},domProps:{value:t.options.channel},on:{input:function(o){o.target.composing||t.$set(t.options,"channel",o.target.value)}}})]),s("div",{staticClass:"d-flex justify-content-between mt-2 mb-3"},[s("div",[s("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:function(o){return t.sendPushNotification()}}},[t.loading?t._e():s("span",[t._v(t._s(t._f("t")("send_notification")))]),t.loading?s("span",[t._v(t._s(t._f("t")("loading")))]):t._e()])])])])])},i=[],n=(s("d3b7"),s("9ab4")),a=s("9f3a"),l=s("20d6"),r=s("2b0e"),c=s("2fe1"),p=s("f6b1"),u=function(t){function o(){var o=null!==t&&t.apply(this,arguments)||this;return o.s=p["b"].instance,o.options={idx:"",notify:"all",topic:"",tokens:"",emails:"",users:"",title:"",body:"",click_action:"",imageUrl:"",sound:"telephoneringwav.wav",channel:"PUSH_NOTIFICATION"},o.loading=!1,o}return Object(n["c"])(o,t),o.prototype.mounted=function(){this.$route.params.postIdx&&(this.options.idx=this.$route.params.postIdx),this.loadPostIdx()},o.prototype.loadPostIdx=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,o,s;return Object(n["d"])(this,(function(e){switch(e.label){case 0:if(console.log(this.options.idx),""===this.options.idx)return[2];t={idx:this.options.idx},e.label=1;case 1:return e.trys.push([1,3,,4]),[4,a["a"].instance.postGet(t)];case 2:return o=e.sent(),this.options.title=o.title,this.options.body=o.content,this.options.click_action=o.url,o.files.length>0&&(this.options.imageUrl=o.files[0].url),this.loading=!1,[3,4];case 3:return s=e.sent(),this.loading=!1,this.s.error(s),[3,4];case 4:return[2]}}))}))},o.prototype.sendPushNotification=function(){return Object(n["a"])(this,void 0,Promise,(function(){var t,o,s,e,i;return Object(n["d"])(this,(function(n){switch(n.label){case 0:if(this.loading)return[2];this.loading=!0,t={title:this.options.title,body:this.options.body,click_action:this.options.click_action,imageUrl:this.options.imageUrl,sound:this.options.sound,channel:this.options.channel},this.options.idx&&(t["data"]={idx:this.options.idx,type:"post"}),n.label=1;case 1:return n.trys.push([1,10,,11]),o={},"all"!==this.options.notify?[3,3]:(t["topic"]=l["a"],[4,a["a"].instance.sendMessageToTopic(t)]);case 2:return o=n.sent(),[3,9];case 3:return"topic"!==this.options.notify?[3,5]:(t["topic"]=this.options.topic,[4,a["a"].instance.sendMessageToTopic(t)]);case 4:return o=n.sent(),[3,9];case 5:return"tokens"!==this.options.notify?[3,7]:(t["tokens"]=this.options.tokens,[4,a["a"].instance.sendMessageToTokens(t)]);case 6:return o=n.sent(),[3,9];case 7:return"emails"!==this.options.notify?[3,9]:(t["emails"]=this.options.emails,t["users"]=this.options.users,[4,a["a"].instance.sendMessageToUsers(t)]);case 8:o=n.sent(),n.label=9;case 9:return this.loading=!1,"tokens"===this.options.notify?(s=o.success.length,e=o.error.length,this.s.alert("Send Push Message to tokens: ",s+" Success, "+e+" Fail.")):this.s.alert("Send Push Message to topic : ","Success Sending push notification to topic."),[3,11];case 10:return i=n.sent(),this.loading=!1,this.s.error(i),[3,11];case 11:return[2]}}))}))},o=Object(n["b"])([Object(c["b"])({})],o),o}(r["default"]),d=u,m=d,f=s("2877"),_=Object(f["a"])(m,e,i,!1,null,null,null);o["default"]=_.exports}}]);
//# sourceMappingURL=chunk-2d0e2175.58140fd5.js.map