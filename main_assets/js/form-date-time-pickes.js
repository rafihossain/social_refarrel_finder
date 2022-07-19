$(function() {
	"use strict";

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'yyyy-mm-dd'
    }),
    $('.timepicker').pickatime()


   
        $('#date-time').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#date').bootstrapMaterialDatePicker({
            time: false
        });
        $('#time').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:mm'
        });
   


});