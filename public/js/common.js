/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($, window, document) {
    $(document).ready(function () {
        $("#logout").click(function (event) {
            event.preventDefault();
            $.getJSON('/logout', function (response) {
                if (response.status)
                    window.location.reload();
                else {
                    $('#messageBox > #messageContent')
                            .addClass('alert-warning')
                            .removeClass('alert-success')
                            .text('Something went wrong!');
                    $('#messageBox').removeClass('hide');
                }
            });
        });

        function showMessage(type, message) {
            $('#messageBox > #messageContent')
                    .removeClass('alert-success')
                    .removeClass('alert-info')
                    .removeClass('alert-warning')
                    .removeClass('alert-danger')
                    .removeClass('alert-error')
                    .addClass('alert-' + type)
                    .text(message);
            $('#messageBox').removeClass('hide');
        }
    });
})(jQuery, window, document);