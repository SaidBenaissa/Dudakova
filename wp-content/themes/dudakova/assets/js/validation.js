jQuery(document).ready(function($) {

//jQuery validate
    jQuery.validator.addMethod("digits", function (value, element) {
        return this.optional(element) || /^[-+() 0-9]{1,20}$/.test(value);
    }, "Телефон должен состоять только из цифр");

    function initFormValidate(id) {
        $(id).validate({
            rules: {
                clientsName: {
                    required: true,
                    minlength: 3
                },
                company: {
                    required: true,
                    minlength: 3
                },
                mail: {
                    required: true,
                    email: true
                },
                phone: {
                    digits: true,
                    required: true,
                    minlength: 8
                },
                employees: {
                    required: true,
                    minlength: 1
                }
            },

            messages: {
                clientsName: {
                    required: "Введите ваше имя",
                    minlength: jQuery.validator.format("Минимальная длина {0} символов!")
                },
                company: {
                    required: "Введите название вашей компании",
                    minlength: jQuery.validator.format("Минимальная длина {0} символов!")
                },
                mail: {
                    required: "Введите электронный адрес",
                    email: "Похоже, что email введен с ошибкой"
                },
                phone: {
                    required: "Введите номер телефона",
                    minlength: jQuery.validator.format("Минимальная длина {0} символов!")
                },
                employees: {
                    required: "Введите количество сотрудников",
                    minlength: jQuery.validator.format("Минимальная длина {0} символов!")
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    // url: 'http://mandarinki.new/wp-content/themes/mandarinki/form.php',
                    url: 'form.php',
                    type: 'POST',
                    data: $(id).serialize(),
                    beforeSend: function () {
                        $(id).addClass('sending');
                    },
                    success: function (res) {
                        if (res == 1) {
                            //alert( res );
                        } else {
                            //alert( res );
                        }
                        $('#popUpForm').removeClass('active');
                        setTimeout(function () {
                            $('#popUpForm').removeClass('to-front');
                        }, 100);
                        $('.tnx-msg,.pop-up-overlay').addClass('to-front');
                        setTimeout(function () {
                            $('.tnx-msg,.pop-up-overlay').addClass('active');
                            $(id).removeClass('sending');
                        }, 300);
                    },
                    error: function () {
                        alert('Error');
                    }
                });
            }

        });
    }

    initFormValidate('#mainForm');
    initFormValidate('#subscribeForm');

});