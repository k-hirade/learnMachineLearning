<h2><?php echo h($post['Post']['title']); ?></h2>

<p><?php echo h($post['Post']['body']); ?></p>

<h2>Comments</h2>

<ul>
<?php foreach ($post['Comment'] as $comment): ?>
<li id="comment_<?php echo h($comment['id']); ?>">
<?php echo h($comment['body']) ?> by <?php echo h($comment['commenter']); ?> 
<a href="#" class="delete" data-comment-id="<?php echo h($comment['id']); ?>">削除</a>
</li>
<?php endforeach; ?>
</ul>

<h2>Add Comment</h2>

<form action="/comments/add" id="CommentAddForm" method="post" accept-charset="utf-8">
<div style="display:none;">
<input type="hidden" name="_method" value="POST"></div>
<div class="input text">
<label for="CommentCommenter">Commenter</label>
<input name="data[Comment][commenter]" maxlength="255" type="text" id="CommentCommenter"></div>
<div class="input textarea"><label for="CommentBody">Body</label>
<textarea name="data[Comment][body]" rows="3" cols="30" id="CommentBody"></textarea></div>
<input type="hidden" name="data[Comment][post_id]" value="3" id="CommentPostId">
<div class="submit"><input type="submit" value="post comment"></div>
</form>

<script>
$('a.delete').click(function(e) {
        if (confirm('sure?')) {
            $.post('/comments/delete/'+$(this).data('comment-id'), {}, function(res) {
                $('#comment_'+res.id).fadeOut();
            }, "json");
        }
        return false;
    });
</script>