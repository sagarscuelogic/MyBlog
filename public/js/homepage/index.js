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
                dataType: 'JSON',
                success: function (data, textStatus, jqXHR) {
                    if (!data.status) {
                        $('#messageBox > #messageContent')
                                .addClass('alert-warning')
                                .text(data.message);
                        $('#messageBox').removeClass('hide');
                        return false;
                    }
                    if (!data.count) {
                        $('#messageBox > #messageContent')
                                .addClass('alert-warning')
                                .text('Nothing to show yet!');
                        $('#messageBox').removeClass('hide');
                        return false;
                    }
                    if (data.count) {
                        $.each(data.rows, function (p, post) {
                            var postLineContainer = $('<article>').appendTo('#posts');

                            var postLine = $('<blockquote>').appendTo(postLineContainer);

                            var postTitle = $('<h1>').appendTo(postLine);

                            $('<a>').text(post.title)
                                    .attr('href', '/post/' + post.id)
                                    .appendTo(postTitle);

                            var postContents = $('<p>')
                                    .text(post.content)
                                    .appendTo(postLine);

                            var postFooter = $('<footer>')
                                    .text('On ' + post.created_on)
                                    .appendTo(postLine);

                            var postCite = $('<cite>')
                                    .attr('title', post.author)
                                    .text(' By ')
                                    .appendTo(postFooter);

                            $('<a>').text(post.author)
                                    .attr('href', '/user/' + post.created_by)
                                    .appendTo(postCite);
                        });
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#messageBox > #messageContent')
                            .addClass('alert-danger')
                            .text(errorThrown);
                    $('#messageBox').removeClass('hide');
                }
            });
        }

        if ($('.form-signup').length || $('.form-signin').length) {
            $('.form-signup, .form-signin').submit(function (event) {
                event.preventDefault();
                if ($(this).hasClass('form-signup')) {
                    $.ajax({
                        type: "POST",
                        dataType: 'JSON',
                        url: '/user/add',
                        data: $(this).serialize(),
                        success: function (data, textStatus, jqXHR) {
                            if (!data.status) {
                                $('#messageBox > #messageContent')
                                        .addClass('alert-danger')
                                        .text(data.message);
                                $('#messageBox').removeClass('hide');
                                return false;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#messageBox > #messageContent')
                                    .addClass('alert-danger')
                                    .text(errorThrown);
                            $('#messageBox').removeClass('hide');
                        }
                    });
                }
                return false;
            });
        }
    });
})(jQuery, window, document);