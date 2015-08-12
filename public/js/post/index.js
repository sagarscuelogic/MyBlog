/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($, window, document) {
    $(document).ready(function () {
        var postId = $('#postId').val(),
            userId = $('#userId').val(),
            userName = $('#userName').val();
        if ($('#comments').length) {
            $.getJSON('/comment', {post: postId}, function (response) {
                if(!response.status) {
                    showMessage('warning', 'Something went wrong while posting comment');
                    return false;
                }
                if(response.rows.length) {
                    processComment(response.rows, 0);
                }
            });
        }

        if ($('.post-comment-form').length) {
            $('.post-comment-form textarea').on('keyup', function(event) {
                var code = event.which;
                if(code==13) {
                    event.preventDefault();
                    $(this).closest('.post-comment-form').submit();
                }
            });
            $('.post-comment-form').on('submit', function (event) {
                event.preventDefault();
                var data = $(this).serialize();
                data += '&postId=' + postId;
                $.post('/comment/add', data, function (response) {
                    console.log(data);
                    if(!response.status) {
                        showMessage('warning', 'Something went wrong while posting comment');
                        return false;
                    }
                    if (typeof data.commentId === 'undefined') {
                        data.commentId = 0;
                    }
                    postComment(response.id, data.comment, data.commentId);
                }, 'JSON');
            });
        }

        var postComment = function (id, content, parent) {
            console.log(id);
            console.log(content);
            console.log(parent);
            var commentRow = $('<div>').addClass('media'),
                userPicContainer = $('<div>')
                    .addClass('media-left')
                    .appendTo(commentRow),
                userLink = $('<a>')
                    .attr('href', '/user/' + userId)
                    .appendTo(userPicContainer),
                commentBody = $('<div>')
                    .addClass('media-body')
                    .text(content)
                    .attr('id', 'comment_' + id)
                    .appendTo(commentRow);
            
            $('<img>')
                    .attr('src', 'http://placehold.it/50?text=' + userName)
                    .appendTo(userLink);
            
            if(parent) {
                commentRow.appendTo('#comment_' + parent);
            }
            else {
                commentRow.appendTo('#comments');
            }
            appendReplyForm(commentBody, id);
        };
        
        var processComment = function(comments, parent) {
            if(comments.length) {
                $.each(comments, function(c, comment) {
                    postComment(comment.id, comment.content, parent);
                    if(comment.children.length) {
                        processComment(comment.children, comment.id);
                    }
                });
            }
        };
        
        var appendReplyForm = function(comment, id) {
            var replyForm = $('.post-comment-form').parent().first().clone();
            replyForm.appendTo(comment);
            replyForm
                    .find('.col-lg-10')
                    .removeClass('col-lg-10')
                    .addClass('col-lg-6');
            replyForm.find('textarea').attr('placeholder', 'Your reply here');
            $('<input>')
                    .attr({
                        type: 'hidden',
                        name: 'commentId'
                    })
                    .val(id)
                    .appendTo(replyForm);
        };
    });
})(jQuery, window, document);