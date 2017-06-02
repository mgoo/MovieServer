/**
 * Created by mgoo on 19/05/17.
 */
var pluginsLoaded = $.getScript('js/background/background.js', function(){
    $.fn.background = function(options){
        $(window).resize(function(){
            this.width = window.innerWidth;
            this.height = window.innerHeight;
            new background.Background(this[0], options);
        });
        return new background.Background(this[0], options);
    };
});