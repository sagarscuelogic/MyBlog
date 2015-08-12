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
                        showMessage('warning', data.message);
                        return false;
                    }
                    if (!data.count) {
                        showMessage('warning', 'Nothing to show yet!');
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