/*! Fabrik */

function CloneObject(a,b,c){return"object"!==typeOf(a)?a:($H(a).each(function(a,d){"object"!==typeOf(a)||!0!==b||c.contains(d)?this[d]=a:this[d]=new CloneObject(a,b,c)}.bind(this)),this)}function fconsole(a){void 0!==window.console&&console.log(a)}String.implement({toObject:function(){var a={};return this.split("&").each(function(b){var c=b.split("=");a[c[0]]=c[1]}),a}});var mHide=Element.prototype.hide,mShow=Element.prototype.show,mSlide=Element.prototype.slide;Element.implement({findClassUp:function(a){if(this.hasClass(a))return this;for(var b=document.id(this);b&&!b.hasClass(a);){if("element"!==typeOf(b.getParent()))return!1;b=b.getParent()}return b},up:function(a){a=a||0;for(var b=this,c=0;c<=a;c++)b=b.getParent();return b},within:function(a){for(var b=this;null!==b.parentNode;){if(b===a)return!0;b=b.parentNode}return!1},cloneWithIds:function(a){return this.clone(a,!0)},down:function(a,b){var c=this.getChildren();return 0===arguments.length?c[0]:c[b]},findUp:function(a){if(this.get("tag")===a)return this;for(var b=this;b&&b.get("tag")!==a;)b=b.getParent();return b},mouseInside:function(a,b){var c=this.getCoordinates(),d=c.left,e=c.left+c.width,f=c.top,g=c.bottom;return a>=d&&a<=e&&b>=f&&b<=g},getValue:function(){return this.get("value")},hide:function(){return"2.x"!==Fabrik.bootstrapVersion("modal")?this:this.hasClass("mootools-noconflict")?this:void mHide.apply(this,arguments)},show:function(a){if(this.hasClass("mootools-noconflict"))return this;mShow.apply(this,a)},slide:function(a){if(this.hasClass("mootools-noconflict"))return this;mSlide.apply(this,a)}});