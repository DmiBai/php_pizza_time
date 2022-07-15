$( document ).ready(function() {
    $('#submit_btn').click(
		function(){
			sendAjaxForm('result', 'ajax_form', 'select.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(result, ajax_form, url) {
    $.ajax({
        url:     url,
        type:     'POST',
        dataType: 'html',
        data: $('#'+ajax_form).serialize(),
        success: function(response) {
        	result = $.parseJSON(response);
            selected = 'Ваш заказ оформлен! <br>Пицца: ' + $('#select_pizza_type option:selected').text() + ' ' + $('#select_pizza_size option:selected').text() + ' см';
            selected += '<br>Соус: ' + $('#select_sause_type option:selected').text() + ' ' + '<br>Цена: ';
        	$('#result').html(selected + '' + result.price + ' рублей');
    	},
    	error: function(response) {
            $('#result').html('Ошибка. Данные не отправлены.');
    	}
 	});
}