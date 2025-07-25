/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
 (function(d){"function"===typeof define&&define.amd?define(["jquery"],d):"object"===typeof exports?module.exports=d(require("jquery")):d(jQuery)})(function(d){function p(b){b=e.json?JSON.stringify(b):String(b);return e.raw?b:encodeURIComponent(b)}function n(b,g){var a;if(e.raw)a=b;else a:{var c=b;0===c.indexOf('"')&&(c=c.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{c=decodeURIComponent(c.replace(l," "));a=e.json?JSON.parse(c):c;break a}catch(h){}a=void 0}return d.isFunction(g)?g(a):
a}var l=/\+/g,e=d.cookie=function(b,g,a){if(1<arguments.length&&!d.isFunction(g)){a=d.extend({},e.defaults,a);if("number"===typeof a.expires){var c=a.expires,h=a.expires=new Date;h.setMilliseconds(h.getMilliseconds()+864E5*c)}return document.cookie=[e.raw?b:encodeURIComponent(b),"=",p(g),a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":""].join("")}for(var c=b?void 0:{},h=document.cookie?document.cookie.split("; "):[],
m=0,l=h.length;m<l;m++){var f=h[m].split("="),k;k=f.shift();k=e.raw?k:decodeURIComponent(k);f=f.join("=");if(b===k){c=n(f,g);break}b||void 0===(f=n(f))||(c[k]=f)}return c};e.defaults={};d.removeCookie=function(b,e){d.cookie(b,"",d.extend({},e,{expires:-1}));return!d.cookie(b)}});