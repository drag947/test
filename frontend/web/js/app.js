function formAlert(alert, message) {
    var block = $('.message');
    block.empty().append('<div class="alert alert-' + alert + ' alert-dismissible form_pay-message" role="alert">');
    block.find('.alert').append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    block.find('.alert').append(message);
    block.append('</div>');
}
function submitClick() {
    $('#js-submit').on('click', function(e){
        e.preventDefault();
        var button = $(this);
        button.prop("disabled", true);
        var data = $('#form_pay').serialize();
        $.ajax({
            url: '/frontend/web/form-pay/save-form',
            type: 'POST',
            data: data,
            success: function(res){
                var answer = JSON.parse(res);
                formAlert(answer.result, answer.message);
                button.prop("disabled", false);
            },
            error: function(){
                formAlert('danger', 'Ошибка!');
                button.prop("disabled", false);
            }
        });
    });
}

submitClick();

function getForm(data) {
    
    $.ajax({
        url: '/frontend/web/form-pay/get-form',
        type: 'POST',
        data: {form:data, _csrf: yii.getCsrfToken()},
        success: function(res){
            $('.js-form').empty().append(res);
            submitClick();
            $('.js-status_bill').on('change', function(){
                if(this.value == 'new') {
                    getForm('cashless');
                }else{
                    $.ajax({
                        url: '/frontend/web/form-pay/get-bill',
                        type: 'POST',
                        data: {id: this.value, _csrf: yii.getCsrfToken()},
                        success: function(res){
                            $('.js-remove-bill').remove();
                            $('#js-submit').parent().before(res);
                        },
                        error: function(){
                            formAlert('danger', 'Ошибка!');
                        }
                    });
                }
            });
            setEventForm('ldt');
            $('.js-type_buyer').on('change', function() {
                if(this.value == 'ldt') {
                    setEventForm('ldt');
                    $('.js-sp').hide();
                    $('.js-ldt').show();
                }else if(this.value == 'sp') {
                    setEventForm('sp');
                    $('.js-sp').show();
                    $('.js-ldt').hide();
                }
            });
        },
        error: function(){
            formAlert('danger', 'Ошибка!');
        }
    });
}

$('#js-type-form').on('change', function() {
    getForm(this.value);
});



function setEventForm(e) {
    var form = $('#form_pay');
    if(e == 'ldt') {
        form.off('beforeValidateAttribute');
        form.on('beforeValidateAttribute', function (event, attribute, messages, deferreds) {
            if (attribute.name == 'full_name_user' || attribute.name == 'phone') {
                return false;
            }
        });
    }else if(e == 'sp') {
        form.off('beforeValidateAttribute');
        form.on('beforeValidateAttribute', function (event, attribute, messages, deferreds) {
            if (attribute.name == 'full_name' || attribute.name == 'inn') {
                return false;
            }
        });
    }
}