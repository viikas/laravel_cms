(function($) {
    $.fn.pageSearch = function(options) {
    var settings = $.extend({
            //ID of main holder element
    element: "divContent",
            //class of repeatable child items
    child: "item",
            //ID of element to show result in
            result: "filterCount"
        }, options);

        $(this).keyup(function() {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(), count = 0;

            // Loop through the comment list
            $("#" + settings.element + " ." + settings.child).each(function() {

                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();
                } else {
                    $(this).show();
                    count++;
                }
            });

            $("#" + settings.result).html("Total <i>" + count + "</i> items");
            return;
        });

    };

} (jQuery));