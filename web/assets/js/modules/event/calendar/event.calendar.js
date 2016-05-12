$(document).ready(function () {
    $('#calendar-event').on('click', '.arrow', function () {
        var left = $(this).hasClass('text-left');
        var current_date = {
            'month': $(this).parents('table').data('month'),
            'year': $(this).parents('table').data('year')
        };

        if (left) {
            current_date.month--;
            if (current_date.month < 1) {
                current_date.month = 12;
                current_date.year--;
            }
        } else {
            current_date.month++;
            if (current_date.month > 12) {
                current_date.month = 1;
                current_date.year++;
            }
        }

        $.get(Routing.generate('event_calendar', current_date))
        .done(function (data) {
            $('#calendar-event').html(data);
        });
    });
});
