$('#schoolSelect').change(function(){
    $('#plan_uri_input').text($('#schoolSelect option:checked').val());
});
$(function(){
    $('#plan_uri_input').text($('#schoolSelect option:checked').val());
});
