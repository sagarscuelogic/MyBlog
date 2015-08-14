/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($, window, document) {
    $(document).ready(function () {
        if ($('#posts').length) {
            $.ajax({
                url: '/post',
                dataType: 'html',
                success: function (data, textStatus, jqXHR) {
                    $('#posts').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showMessage('danger', errorThrown);
                }
            });
        }

        if ($('.form-signup').length || $('.form-signin').length) {
            $('.form-signup, .form-signin').submit(function (event) {
                var form = $(this).hasClass('form-signup') ? 'signup' : 'signin';
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: (form === 'signup') ? '/user/add' : '/login',
                    data: $(this).serialize(),
                    success: function (data, textStatus, jqXHR) {
                        if (!data.status) {
                            showMessage('danger', data.message);
                           
                            if (data.errorFields.length) {
                                $.each(data.errorFields, function (ef, errorField) {
                                    $("#" + errorField).closest('.form-group').addClass('has-error');
                                })
                            }
                            return true;
                        }
                        if (form === 'signup') {
                            showMessage('success', 'Welcome to MyBlog! You\'ve successfully registered.');
                            $('.form-signup, .form-signin').trigger('reset');
                            window.location.href = '/login';
                        }
                        window.location.href = '/';
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showMessage('danger', errorThrown);
                    }
                });
                return false;
            });
        }
    });
})(jQuery, window, document);