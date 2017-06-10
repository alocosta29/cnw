<style>
            #box-widget{
               border-style: solid;
                border-width: 1px;
              
            }
    
            #box-widget h2{
                width: 100%;
                background-color: #34495e;
                padding-top: 2px;
                padding-bottom: 2px;
                color: #ecf0f1;
                font-weight: bold;
                
            }
            #topside_box{
                min-width: 263px;
                
            }
            
            
            
            
            
    
</style>
<script type="text/javascript">
//<![CDATA[
(function($) {
var defaults = {
topSpacing: 0,
bottomSpacing: 0,
className: 'is-sticky',
wrapperClassName: 'sticky-wrapper'
},
$window = $(window),
$document = $(document),
sticked = [],
windowHeight = $window.height(),
scroller = function() {
var scrollTop = $window.scrollTop(),
documentHeight = $document.height(),
dwh = documentHeight - windowHeight,
extra = (scrollTop > dwh) ? dwh - scrollTop : 0;
for (var i = 0; i < sticked.length; i++) {
var s = sticked[i],
elementTop = s.stickyWrapper.offset().top,
etse = elementTop - s.topSpacing - extra;
if (scrollTop <= etse) {
if (s.currentTop !== null) {
s.stickyElement
.css('position', '')
.css('top', '')
.removeClass(s.className);
s.stickyElement.parent().removeClass(s.className);
s.currentTop = null;
}
}
else {
var newTop = documentHeight - s.stickyElement.outerHeight()
- s.topSpacing - s.bottomSpacing - scrollTop - extra;
if (newTop < 0) {
newTop = newTop + s.topSpacing;
} else {
newTop = s.topSpacing;
}
if (s.currentTop != newTop) {
s.stickyElement
.css('position', 'fixed')
.css('top', newTop)
.addClass(s.className);
s.stickyElement.parent().addClass(s.className);
s.currentTop = newTop;
}
}
}
},
resizer = function() {
windowHeight = $window.height();
},
methods = {
init: function(options) {
var o = $.extend(defaults, options);
return this.each(function() {
var stickyElement = $(this);
stickyId = stickyElement.attr('id');
wrapper = $('<div></div>')
.attr('id', stickyId + '-sticky-wrapper')
.addClass(o.wrapperClassName);
stickyElement.wrapAll(wrapper);
var stickyWrapper = stickyElement.parent();
stickyWrapper.css('height', stickyElement.outerHeight());
sticked.push({
topSpacing: o.topSpacing,
bottomSpacing: o.bottomSpacing,
stickyElement: stickyElement,
currentTop: null,
stickyWrapper: stickyWrapper,
className: o.className
});
});
},
update: scroller
};
if (window.addEventListener) {
window.addEventListener('scroll', scroller, false);
window.addEventListener('resize', resizer, false);
} else if (window.attachEvent) {
window.attachEvent('onscroll', scroller);
window.attachEvent('onresize', resizer);
}
$.fn.sticky = function(method) {
if (methods[method]) {
return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
} else if (typeof method === 'object' || !method ) {
return methods.init.apply( this, arguments );
} else {
$.error('Method ' + method + ' does not exist on jQuery.sticky');
}
};
$(function() {
setTimeout(scroller, 0);
});
})(jQuery);

//]]>
</script>
<script>
$(document).ready(function(){
$("#rbtSocialFloat").sticky({topSpacing:0});
$("#topside_box").sticky({topSpacing:6});
});
</script>
<div class="sticky-wrapper" id="topside_box-sticky-wrapper" style="height: 222px;text-align:center;">
  <div id="topside_box-sticky-wrapper" class="sticky-wrapper" style="height: 112px;">
      <div class="" id="topside_box" style="">
          <div id="box-widget">
              
              <h2>FIQUE POR DENTRO</h2>
              
              
          </div>  


      </div>
  </div>
</div>