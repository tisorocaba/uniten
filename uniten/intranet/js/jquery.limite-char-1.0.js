(function($){$.fn.extend({limit:function(limit,element,campo){var interval,f;var self=$(this);$(element).hide();$(this).focus(function(){interval=window.setInterval(substring,100); $(element).show()});$(this).blur(function(){clearInterval(interval);$(element).hide()});substringFunction="function substring(){ var val = $(self).val();var length = val.length; if(length > limit){if (campo!= undefined){alert('O campo ' + campo + ' pode exceder ' + limit + ' caracteres'); }$(self).val($(self).val().substring(0,limit));}";if(typeof element!='undefined')substringFunction+="if($(element).html() != limit-length){$(element).html((limit-length<=0)?length + ' de ' + limit:length + ' de ' + limit);}";substringFunction+="}";eval(substringFunction);substring()}})})(jQuery);