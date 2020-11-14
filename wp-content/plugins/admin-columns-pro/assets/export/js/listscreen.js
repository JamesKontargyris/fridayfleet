!function(e){var t={};function n(i){if(t[i])return t[i].exports;var r=t[i]={i:i,l:!1,exports:{}};return e[i].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,i){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(i,r,function(t){return e[t]}.bind(null,r));return i},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=5)}([function(e,t,n){var i=n(2),r=n(3),o=n(1);function s(e){if(!(this instanceof s))return new s(e);this._name=e||"nanobus",this._starListeners=[],this._listeners={}}e.exports=s,s.prototype.emit=function(e){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.emit: eventName should be type string or symbol");for(var t=[],n=1,i=arguments.length;n<i;n++)t.push(arguments[n]);var s=r(this._name+"('"+e.toString()+"')"),a=this._listeners[e];return a&&a.length>0&&this._emit(this._listeners[e],t),this._starListeners.length>0&&this._emit(this._starListeners,e,t,s.uuid),s(),this},s.prototype.on=s.prototype.addListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.on: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.on: listener should be type function"),"*"===e?this._starListeners.push(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].push(t)),this},s.prototype.prependListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependListener: listener should be type function"),"*"===e?this._starListeners.unshift(t):(this._listeners[e]||(this._listeners[e]=[]),this._listeners[e].unshift(t)),this},s.prototype.once=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.once: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.once: listener should be type function");var n=this;return this.on(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},s.prototype.prependOnceListener=function(e,t){o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.prependOnceListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.prependOnceListener: listener should be type function");var n=this;return this.prependListener(e,(function i(){t.apply(n,arguments),n.removeListener(e,i)})),this},s.prototype.removeListener=function(e,t){return o.ok("string"==typeof e||"symbol"==typeof e,"nanobus.removeListener: eventName should be type string or symbol"),o.equal(typeof t,"function","nanobus.removeListener: listener should be type function"),"*"===e?(this._starListeners=this._starListeners.slice(),n(this._starListeners,t)):(void 0!==this._listeners[e]&&(this._listeners[e]=this._listeners[e].slice()),n(this._listeners[e],t));function n(e,t){if(e){var n=e.indexOf(t);return-1!==n?(i(e,n,1),!0):void 0}}},s.prototype.removeAllListeners=function(e){return e?"*"===e?this._starListeners=[]:this._listeners[e]=[]:(this._starListeners=[],this._listeners={}),this},s.prototype.listeners=function(e){var t="*"!==e?this._listeners[e]:this._starListeners,n=[];if(t)for(var i=t.length,r=0;r<i;r++)n.push(t[r]);return n},s.prototype._emit=function(e,t,n,i){if(void 0!==e&&0!==e.length){void 0===n&&(n=t,t=null),t&&(n=void 0!==i?[t].concat(n,i):[t].concat(n));for(var r=e.length,o=0;o<r;o++){var s=e[o];s.apply(s,n)}}}},function(e,t){function n(e,t){if(!e)throw new Error(t||"AssertionError")}n.notEqual=function(e,t,i){n(e!=t,i)},n.notOk=function(e,t){n(!e,t)},n.equal=function(e,t,i){n(e==t,i)},n.ok=n,e.exports=n},function(e,t,n){"use strict";e.exports=function(e,t,n){var i,r=e.length;if(!(t>=r||0===n)){var o=r-(n=t+n>r?r-t:n);for(i=t;i<o;++i)e[i]=e[i+n];e.length=o}}},function(e,t,n){var i,r=n(4)(),o=n(1);s.disabled=!0;try{i=window.performance,s.disabled="true"===window.localStorage.DISABLE_NANOTIMING||!i.mark}catch(e){}function s(e){if(o.equal(typeof e,"string","nanotiming: name should be type string"),s.disabled)return a;var t=(1e4*i.now()).toFixed()%Number.MAX_SAFE_INTEGER,n="start-"+t+"-"+e;function u(o){var s="end-"+t+"-"+e;i.mark(s),r.push((function(){var r=null;try{var a=e+" ["+t+"]";i.measure(a,n,s),i.clearMarks(n),i.clearMarks(s)}catch(e){r=e}o&&o(r,e)}))}return i.mark(n),u.uuid=t,u}function a(e){e&&r.push((function(){e(new Error("nanotiming: performance API unavailable"))}))}e.exports=s},function(e,t,n){var i=n(1),r="undefined"!=typeof window;function o(e){this.hasWindow=e,this.hasIdle=this.hasWindow&&window.requestIdleCallback,this.method=this.hasIdle?window.requestIdleCallback.bind(window):this.setTimeout,this.scheduled=!1,this.queue=[]}o.prototype.push=function(e){i.equal(typeof e,"function","nanoscheduler.push: cb should be type function"),this.queue.push(e),this.schedule()},o.prototype.schedule=function(){if(!this.scheduled){this.scheduled=!0;var e=this;this.method((function(t){for(;e.queue.length&&t.timeRemaining()>0;)e.queue.shift()(t);e.scheduled=!1,e.queue.length&&e.schedule()}))}},o.prototype.setTimeout=function(e){setTimeout(e,0,{timeRemaining:function(){return 1}})},e.exports=function(){var e;return r?(window._nanoScheduler||(window._nanoScheduler=new o(!0)),e=window._nanoScheduler):e=new o,e}},function(e,t,n){"use strict";function i(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}n.r(t);var r=n(0),o=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.element=t,this.events=r(),this.initEvents()}var t,n,o;return t=e,(n=[{key:"disable",value:function(){this.element.classList.add("disabled")}},{key:"enable",value:function(){this.element.classList.remove("disabled")}},{key:"isEnabled",value:function(){return!this.element.classList.contains("disabled")}},{key:"initEvents",value:function(){var e=this;this.element.addEventListener("click",(function(t){t.preventDefault(),e.isEnabled()&&(e.disable(),e.events.emit("export"))}))}}])&&i(t.prototype,n),o&&i(t,o),e}();function s(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var a=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,n,i;return t=e,i=[{key:"enable",value:function(){window.onbeforeunload=function(){return ACP_Export.i18n.leaving}}},{key:"disable",value:function(){window.onbeforeunload=function(){}}}],(n=null)&&s(t.prototype,n),i&&s(t,i),e}(),u=function(e){for(var t=arguments.length,n=new Array(t>1?t-1:0),i=1;i<t;i++)n[i-1]=arguments[i];return e.replace(/{(\d)}/g,(function(e,t){return n[Number(t)]}))};function c(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function l(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}function d(e,t,n){return t&&l(e.prototype,t),n&&l(e,n),e}var p=function(){function e(){c(this,e),this.element=this.createElement(),this.data={processed:0,total:ACP_Export.total_num_items,download_url:"#"},this.updateData()}return d(e,[{key:"createElement",value:function(){var e=document.createElement("div");return e.classList.add("acp-export-notice","notice","updated"),e.innerHTML=h,e}},{key:"setError",value:function(e){this.element.classList.add("error"),this.element.innerHTML="<p>".concat(e,"</p>"),this.makeDismissible()}},{key:"addProcessed",value:function(e){this.data.processed+=e,this.updateData()}},{key:"setProcessed",value:function(e){this.data.processed=e}},{key:"setTotal",value:function(e){this.data.total=e}},{key:"calcPercentage",value:function(){return Math.ceil(this.data.processed/this.data.total*100)}},{key:"render",value:function(){var e=this;document.querySelectorAll(".wp-header-end").forEach((function(t){var n,i;n=e.element,(i=t).parentNode.insertBefore(n,i.nextSibling)}))}},{key:"updateData",value:function(){this.element.querySelector(".num-processed").innerText=this.data.processed,this.element.querySelector(".total-num-items").innerText=this.data.total,this.element.querySelector(".percentage-processed").innerText=this.calcPercentage(),this.element.querySelector("[data-download]").setAttribute("href",this.data.download_url)}},{key:"setDownloadUrl",value:function(e){this.data.download_url=e,this.updateData()}},{key:"complete",value:function(){this.makeDismissible(),this.element.querySelector(".exporting").style.display="none",this.element.querySelector(".export-completed").style.display="block"}},{key:"makeDismissible",value:function(){var e=this,t=new f;this.element.classList.add("is-dismissible"),this.element.appendChild(t.get()),t.get().addEventListener("click",(function(t){t.preventDefault(),e.element.remove()}))}}]),e}(),f=function(){function e(){c(this,e),this.element=this._create()}return d(e,[{key:"_create",value:function(){var e=document.createElement("button");return e.classList.add("notice-dismiss"),e.innerHTML='<span class="screen-reader-text"> '.concat(ACP_Export.i18n.dismiss,"</span>"),e}},{key:"get",value:function(){return this.element}}]),e}(),h='\n\t          <div class="exporting">\n\t            <p>\n\t              <span class="spinner is-active"></span>\n\t              '.concat(ACP_Export.i18n.exporting,"\n\t              ").concat(u(ACP_Export.i18n.processed,'<span class="num-processed"></span>','<span class="total-num-items"></span>','<span class="percentage-processed"></span>'),'\n\t            </p>\n\t          </div>\n\t          <div class="export-completed hidden">\n\t            <p>\n\t              ').concat(u(ACP_Export.i18n.export_completed,'<span class="total-num-items"></span>'),'\n\t              <a href="#" class="button button-secondary" data-download>').concat(ACP_Export.i18n.download_file,"</a>\n\t            </p>\n\t          </div>\n\t      ");function m(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var v=n(0),y="completed",b=function(){function e(){var t;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.events=v(),this.message=new p,this.counter=0,this.hash=(t=function(){return(65536*(1+Math.random())|0).toString(16).substring(1)})()+t()+"-"+t()+"-"+t()+"-"+t()+"-"+t()+t()+t()}var t,n,i;return t=e,(n=[{key:"start",value:function(){this.message.render(),this.counter=0,this.run()}},{key:"continue",value:function(){this.counter++,this.run()}},{key:"run",value:function(){var e=this;this.call().success((function(t){if(!t.success){var n=t.data?t.data:ACP_Export.i18n.export_error;return e.message.setError(n),e.message.makeDismissible(),void e.events.emit(y)}t.data.num_rows_processed>0?(e.message.addProcessed(t.data.num_rows_processed),e.continue()):e.complete(t.data)}))}},{key:"complete",value:function(e){this.events.emit(y),this.message.setDownloadUrl(e.download_url),this.message.complete(),window.location.href=e.download_url}},{key:"call",value:function(){var e={_wpnonce:ACP_Export.nonce,acp_export_action:"acp_export_listscreen_export",acp_export_hash:this.hash,acp_export_counter:this.counter};return jQuery.ajax({method:"get",url:window.location.href,data:e})}}])&&m(t.prototype,n),i&&m(t,i),e}();function _(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var w=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.element=t}var t,n,i;return t=e,(n=[{key:"init",value:function(){var e=this;this.element.querySelector("input").addEventListener("click",(function(){e.isActive()?e.activate():e.deactivate()}))}},{key:"activate",value:function(){this.element.querySelector("input").checked=!0,this.persist(),document.body.classList.remove("ac-hide-export-button"),jQuery(".ac-table-actions-buttons").trigger("update")}},{key:"deactivate",value:function(){this.element.querySelector("input").checked=!1,this.persist(),document.body.classList.add("ac-hide-export-button"),jQuery(".ac-table-actions-buttons").trigger("update")}},{key:"isActive",value:function(){return this.element.querySelector("input").checked}},{key:"persist",value:function(){return jQuery.post(ajaxurl,{action:"acp_export_show_export_button",value:this.isActive(),layout:AC.layout,list_screen:AC.list_screen,_ajax_nonce:AC.ajax_nonce})}}])&&_(t.prototype,n),i&&_(t,i),e}();function g(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var k=n(0);document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelector(".ac-table-button.-export");AdminColumns.Export={Exporter:new x(e)};var t=document.querySelector("#acp_export_show_export_button");t&&(AdminColumns.Export.ScreenOption=new w(t),AdminColumns.Export.ScreenOption.init())}));var x=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),t&&(this.events=k(),this._button=new o(t),this._init())}var t,n,i;return t=e,(n=[{key:"_init",value:function(){var e=this;this._button.events.on("export",(function(){e.export()})),this.events.on("completed",(function(){a.disable(),e._button.enable()}))}},{key:"export",value:function(){var e=this;a.enable();var t=new b;t.events.on(y,(function(){e.events.emit("completed")})),t.start()}}])&&g(t.prototype,n),i&&g(t,i),e}()}]);