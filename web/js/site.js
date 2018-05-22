var App = App || {};

(function($){
    App.Main = {
        exec: function(controller, action) {

            var ns = App,
                action = ( action === undefined ) ? "init" : action;

            controller = controller.charAt(0).toUpperCase() + controller.slice(1);
            if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
                ns[controller][action]();
            }
        },

        setSmoothScrolling: function() {
            $('a.scroll').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }
            });
        },

        init: function() {
            var body = document.body,
                controller = body.getAttribute("data-controller"),
                action = body.getAttribute("data-action");
            
            App.Main.exec(controller);
            App.Main.exec(controller, action);
            App.Main.setSmoothScrolling();
        }
    };

    App.Default = {
        index: function() {
                var masonry = new Masonry( $('.feed-list')[0], {
                    itemSelector: '.feed-element',
                    percentPosition: true
                });
        }
    };

    App.Talk = {
        register: function() {
            App.Talk.markdownPreview($("#estina_bundle_homebundle_registertalk_description"));
        },

        edit: function() {
            App.Talk.markdownPreview($("#estina_bundle_homebundle_talk_description"));
        },

        markdownPreview: function($textarea) {
            var $preview = $('#preview');

            var empty = function() {
                $preview.html('<em>Description preview</em>');
            };

            $textarea.bind('input propertychange', function() {
                var html = $.trim($(this).val());
                if (0 === html.length) {
                    empty();
                } else {
                    $preview.html(markdown.toHTML($(this).val()));
                }
            });
            $textarea.trigger('input');
        }
    };

    App.Main.init();

})(jQuery);
