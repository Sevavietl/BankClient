$(function () {
	initializeDatepicker();

	$('[name="card_number"]').mask('9999 9999 9999 9999');
});

var initializeDatepicker = function() {
    var inputDate = $('[name="card_expiration"]');

	if (!inputDate.hasClass('complited')) {
        inputDate.addClass('complited');
        var icon = $(".fa-calendar").parent();
        inputDate.mask('99/99');
        inputDate.datepicker({
            changeMonth: true,
            changeYear: true,
			showButtonPanel: true,
	        dateFormat: 'mm/y',
            defaultDate: '+1y',
            showOptions: { direction: "up" },
            onClose: function(dateText, inst){
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            	var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

				$(this).datepicker('setDate', new Date(year, month, 1));

				icon.removeClass('selected');
            }
        });
    }
};
