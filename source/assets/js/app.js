$(document).ready(function(){
    var top = 0;
    
    var troll = $('.troll');
    var trollStart = Math.abs(parseInt(troll.css('top')));

    var camp = $('.camp');
    var campStart = Math.abs(parseInt(camp.css('bottom')));

    var bg = $('body');
    var pos = 0;
    
    var updateElements = function() {
        top = $(window).scrollTop();

        troll.css({'top': -trollStart-(top*1.5)});
        camp.css({'bottom': campStart+(top/1.5)-700});
        
        pos = '0 ' + (trollStart+(top*1.5)-700) + 'px';
        bg.css('backgroundPosition', pos);
    };

    updateElements();
    $(window).scroll(function(){
        updateElements();
    });

    var anchor = window.location.hash.substring(1);
    $('#tabs a[href="#' + anchor + '"]').tab('show');
    $('#tabs a').click(function (e) {
      // e.preventDefault();
      $(this).tab('show');
    })
});