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

        init: function() {
            var body = document.body,
                controller = body.getAttribute("data-controller"),
                action = body.getAttribute("data-action");
            App.Main.exec(controller);
            App.Main.exec(controller, action);
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
            var $preview = $('#preview'),
                $ta = $("#estina_bundle_homebundle_registertalk_description");

            var empty = function() {
                $preview.html('<em>Čia bus aprašymo peržiūra.</em>');
            };

            $ta.bind('input propertychange', function() {
                var html = $.trim($(this).val());
                if (0 === html.length) {
                    empty();
                } else {
                    $preview.html(markdown.toHTML($(this).val()));
                }
            });
            empty();
        }
    };

    App.Main.init();

})(jQuery);
