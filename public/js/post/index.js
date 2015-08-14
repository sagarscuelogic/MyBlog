/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($, window, document) {
    $(document).ready(function () {
        var postId = $('#postId').val(),
                userId = $('#userId').val(),
                userName = $('#userName').val(),
                isAdmin = Boolean($('#isAdmin').val()),
                isAuthor = Boolean($('#isAuthor').val()),
                isCommentEditAllowed = Boolean($('#isCommentEditAllowed').val()),
                isCommentDeleteAllowed = Boolean($('#isCommentDeleteAllowed').val());
                
                console.log(isAdmin);
                console.log(isAuthor);
                console.log(isCommentEditAllowed);
                console.log(isCommentDeleteAllowed);
        if ($('#comments').length) {
            $.getJSON('/comment', {post: postId}, function (response) {
                if (!response.status) {
                    showMessage('warning', 'Something went wrong while posting comment');
                    return false;
                }
                if (response.rows.length) {
                    processComment(response.rows, 0);
                }
            });
        }

        if ($('.post-comment-form').length) {
            $(document).on('keydown', '.post-comment-form textarea', function (event) {
                var code = event.which;
                if (code == 13) {
                    event.preventDefault();
                    if ($(this).val()) {
                        $(this).closest('.post-comment-form').submit();
                    }
                    return false;
                }
            });
            $(document).on('submit', '.post-comment-form', function (event) {
                event.preventDefault();
                var data = $(this).serializeArray(),
                        commentId = 0,
                        comment = '',
                        param = '';
                data.push({name: 'postId', value: postId});
                for (param in data) {
                    if (data[param].name === 'comment')
                        comment = data[param].value;
                    else if (data[param].name === 'commentId')
                        commentId = data[param].value;
                }
                $.post('/comment/add', data, function (response) {
                    if (!response.status) {
                        showMessage('warning', 'Something went wrong while posting comment');
                        return false;
                    }
                    postComment(response.id, comment, commentId, response.created_by, userName);
                    $('.post-comment-form').trigger('reset');
                }, 'JSON');
            });
        }

        var postComment = function (id, content, parent, commentorId, commentorName) {
            var isCommentor = Boolean(commentorId == userId);
            var commentRow = $('<div>').addClass('media'),
                    userPicContainer = $('<div>')
                    .addClass('media-left')
                    .appendTo(commentRow),
                    userLink = $('<a>')
                    .attr('href', '/user/' + commentorId)
                    .appendTo(userPicContainer),
                    commentBody = $('<div>')
                    .addClass('media-body')
                    .text(content)
                    .attr('id', 'comment_' + id)
                    .appendTo(commentRow);

            $('<img>')
                    .attr('src', 'http://placehold.it/30?text=' + commentorName)
                    .appendTo(userLink);

            if (isAdmin || (isAuthor || isCommentor || (isCommentEditAllowed || isCommentDeleteAllowed))) {
                var commentActions = $('<div>').prependTo(commentBody);

                if (isAdmin || isCommentEditAllowed || isCommentor) {
                    var editLink = $('<a>')
                            .attr('href', 'javascript:void(0);')
                            .addClass('edit-link')
                            .click(function () {
                                editComment();
                            })
                            .appendTo(commentActions);
                    $('<i>')
                            .addClass('glyphicon')
                            .addClass('glyphicon-pencil')
                            .appendTo(editLink);

                    commentActions.html(commentActions.html() + '&nbsp;');
                }
                
                if (isAdmin || isAuthor || isCommentDeleteAllowed || isCommentor) {
                    var deleteLink = $('<a>')
                            .attr('href', 'javascript:void(0);')
                            .addClass('delete-link')
                            .click(deleteComment)
                            .appendTo(commentActions);
                    $('<i>')
                            .addClass('glyphicon')
                            .addClass('glyphicon-trash')
                            .appendTo(deleteLink);

                    commentActions.html(commentActions.html() + '&nbsp;');
                }
            }

            if (parent) {
                commentRow.appendTo('#comment_' + parent);
            }
            else {
                commentRow.appendTo('#comments');
            }
            appendReplyForm(commentBody, id);
        };

        var processComment = function (comments, parent) {
            if (comments.length) {
                $.each(comments, function (c, comment) {
                    postComment(comment.id, comment.content, parent, comment.created_by, comment.author);
                    if (comment.children.length) {
                        processComment(comment.children, comment.id, comment.children.created_by, comment.children.author);
                    }
                });
            }
        };

        var appendReplyForm = function (comment, id) {
            var replyForm = $('.post-comment-form').parent().first().clone();
            replyForm.appendTo(comment);
            replyForm
                    .find('.col-lg-10')
                    .removeClass('col-lg-10')
                    .addClass('col-lg-6');
            replyForm.find('textarea').attr('placeholder', 'Your reply here');
            if (!replyForm.find('.post-comment-form input[name="commentId"]').length) {
                $('<input>')
                        .attr({
                            type: 'hidden',
                            name: 'commentId'
                        })
                        .appendTo(replyForm.find('.post-comment-form'));
            }
            replyForm.find('.post-comment-form input[name="commentId"]').val(id);
        };

        var editComment = function () {
            console.log('edit comment');
        };

        var deleteComment = function () {
            console.log('delete comment');
        };
    });
})(jQuery, window, document);