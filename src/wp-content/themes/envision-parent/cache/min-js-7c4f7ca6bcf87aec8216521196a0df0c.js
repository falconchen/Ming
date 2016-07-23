var TFE=new(function()
{var $=jQuery;var eventsBox=$('<div></div>');this.logsEnabled=false;this.log=function(message,data)
{if(!this.logsEnabled){return;}
if(data!==undefined){console.log('[TFE] '+getIndentation()+message,'◼',data);}else{console.log('[TFE] '+getIndentation()+message);}};this.on=function(event,callback)
{eventsBox.on(event,callback);this.log('✚ '+event);};this.off=function(event)
{eventsBox.off(event);this.log('✖ '+event);};this.trigger=function(event,data)
{data=data||{};this.log('╭╼▓ '+event,data);changeIndentation(+1);try{eventsBox.trigger(event,data);}catch(e){console.log('[TFE] Exception ',{exception:e});}
changeIndentation(-1);this.log('╰╼░ '+event,data);};this.getAttachedEvents=function()
{return $._data(eventsBox[0],'events');};var getIndentation=function()
{return new Array(currentIndentation).join('│   ');};var currentIndentation=1;var changeIndentation=function(increment)
{if(increment!==undefined){currentIndentation+=(increment>0?+1:-1);}
if(currentIndentation<0){currentIndentation=0;}};})();
/* end of /whb/wp-content/themes/envision-parent/framework/static/javascript/TFE.js */
