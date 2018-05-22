$(function(){
    $('.feed-list').imagesLoaded(function(){
        var masonry = new Masonry( $('.feed-list')[0], {
            itemSelector: '.feed-element',
            percentPosition: true
        });
    });
});