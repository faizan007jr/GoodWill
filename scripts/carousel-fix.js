function carouselNormalization() {
    var items = $('#carouselOffers .carousel-item'),
        heights = [],
        tallest;

    if (items.length) {
        function normalizeHeights() {
            items.each(function() {
                heights.push($(this).height());
            });
            tallest = Math.max.apply(null, heights);
            items.each(function() {
                $(this).css('min-height', tallest + 'px');
            });
        };
        normalizeHeights();

        $(window).on('resize orientationchange', function() {
            tallest = 0, heights.length = 0;
            items.each(function() {
                $(this).css('min-height', '0');
            });
            normalizeHeights();
        });
    }
}

window.onload = function() { carouselNormalization(); }