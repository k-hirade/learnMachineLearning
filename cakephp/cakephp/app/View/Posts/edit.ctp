<h2>Edit Post</h2>

<input id="post_id" name="title" value="<?php echo $post['Post']['id'] ?>" type="hidden">
<input id="edit_input" name="title" value="<?php echo $post['Post']['title'] ?>">
<textarea id="edit_textarea" name="body" rows="3" cols="30"><?php echo $post['Post']['body'] ?></textarea>
<a href="#" class="edit_submit">Save!</a>






<div class="wrapper">
  <h1 style="font-size:20px;display:inline;">編集画面</h1>
  <div class="item-box">
    <div style="margin: 10px;">
      <legend>テキストを入力</legend>
      <div class="edit-box">
        <form>
          <textarea class="form-control" style="width: 90%; height: 50px; margin-bottom:10px;"></textarea>
          <div>
            <input class="btn btn-primary item_submit" type="button" value="保存する">
            <input class="btn btn-default" type="reset" value="キャンセル">
          </div>
        </form>
      </div>
      <div id="sortable">


        <?php if ($items) : ?>
          <?php foreach ($items as $item) : ?>
            <div class="item text-item">
              <input type="hidden" class="item_list_content" name="data[Item][id]" value="<?php echo $item['Item']['id'] ?>">
              <!-- <h2 class="item_id" style="display: none;"><?php echo $item['Item']['id'] ?></h2> -->
              <p style="margin: 0px;"><?php echo $item['Item']['comment'] ?></p>
              <ul class="editpager clearfix unvisible">
                <li class="first-order">一番上へ</li>
                <li class="minus-order">上へ</li>
                <li class="plus-order">下へ</li>
                <li class="last-order">一番下へ</li>
                <li class="edit-item">編集</li>
                <li class="delete-item">削除</li>
                <li class="add-item">下に追加</li>
              </ul>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>


<script>
  function get_item_order() {
    return $(".item_list_content").map(function() {
      return $(this).val();
    }).get().join(",");
  };


  $('a.edit_submit').click(function(e) {
    if (confirm('sure?')) {
      let url = `/posts/edit/` + $('#post_id').val();
      let data = {
        'title': $('#edit_input').val(),
        'body': $('#edit_textarea').val()
      };
      $.post(url, {
        data
      }, function(res) {

      }, "json");
    }
    return false;
  });


  //
  // ↓↓   ここからは課題1のJQueryのやつ
  //

  $('.item_submit').click(function(e) {
    var formValue = $('.form-control').val();
    var postId = $('#post_id').val();

    console.log('新しいアイテムを保存！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/items/add`;
      let data = {
        'comment': formValue,
        'post_id': postId,
      };
      $.post(url, {
        data
      }, function(res) {
        console.log(res['itemId']);
        // confirm(res);
        var itemId = res['itemId'];
        var content = `<div class="item text-item">
    <input type="hidden" class="item_list_content" name="data[Item][id]" value="${itemId}">
     <p style="margin: 0px;">${formValue}</p>
     <ul class="editpager clearfix unvisible">
    <li class="first-order">一番上へ</li>
    <li class="minus-order">上へ</li>
    <li class="plus-order">下へ</li>
    <li class="last-order">一番下へ</li>
    <li class="edit-item">編集</li>
    <li class="delete-item">削除</li>
		<li class="add-item">下に追加</li>
    </ul>
    </div>`;
        // var p = $('<p>').text(formValue);
        $('#sortable').append(content);
        // p.appendTo($('#sortable'));
        $('.form-control').val('');
      }, "json");
    }
    return false;
    // var p = $('p').text($formValue);
  });


  // 関係ない処理
  $('#sortable').on({
    'mouseenter': function() {
      $(this).children('.editpager').removeClass("unvisible");
    },
    'mouseleave': function() {
      $(this).children('.editpager').addClass("unvisible");
    }
  }, ".item");
  // 関係ない処理


  // 一番上にする
  $('#sortable').on('click', '.first-order', function() {
    $('#sortable').prepend($(this).parent().parent());
    // ↑ここで最初に順番を入れ替えているから後はこの順番通りにteam_idの値を取ってくればいい！

    var postId = $('#post_id').val();

    console.log('クリックされたアイテム一番上に！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/posts/item_order_update/` + postId;


      var item_order = get_item_order();
      console.log(item_order);

      let data = {
        'item_order': item_order,
      };
      $.post(url, {
        data
      }, function(res) {
        console.log(res);
      }, "json");
    }
    return false;

  });
  // 一番上にする


  // 一つ上にする
  $('#sortable').on('click', '.minus-order', function() {
    var prev = $(this).parent().parent().prev();
    prev.before($(this).parent().parent());
    var postId = $('#post_id').val();

    console.log('クリックされたアイテム一つ上に！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/posts/item_order_update/` + postId;

      // ここで<div id="sortable">の複数の子要素の<div class="item text-item">のこ要素の
      // <h2 class="item_id" style="display: none;">${itemId}</h2>をtext()を取ってきて配列を作る
      // var team_ids = [];
      // $(".item_id").each(function(i, elem) {
      //   team_ids.push($(elem).text());
      // });
      // // でその配列から'1,2,3,4'みたいな文字列を作る！
      // var item_order = team_ids.join(',');

      // console.log(team_ids);
      // console.log(item_order);

      var item_order = get_item_order();


      let data = {
        'item_order': item_order,
      };
      $.post(url, {
        data
      }, function(res) {
        console.log(res);
      }, "json");
    }
    return false;
  });
  // 一つ上にする


  // 一つ下にする
  $('#sortable').on('click', '.plus-order', function() {
    var next = $(this).parent().parent().next();
    next.after($(this).parent().parent());

    var postId = $('#post_id').val();

    console.log('クリックされたアイテム一つ下に！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/posts/item_order_update/` + postId;

      // ここで<div id="sortable">の複数の子要素の<div class="item text-item">のこ要素の
      // <h2 class="item_id" style="display: none;">${itemId}</h2>をtext()を取ってきて配列を作る
      // var team_ids = [];
      // $(".item_id").each(function(i, elem) {
      //   team_ids.push($(elem).text());
      // });
      // // でその配列から'1,2,3,4'みたいな文字列を作る！
      // var item_order = team_ids.join(',');

      // console.log(team_ids);
      // console.log(item_order);

      var item_order = get_item_order();


      let data = {
        'item_order': item_order,
      };
      $.post(url, {
        data
      }, function(res) {
        console.log(res);
      }, "json");
    }
    return false;
  });
  // 一つ下にする


  // 一番下にする
  $('#sortable').on('click', '.last-order', function() {
    $('#sortable').append($(this).parent().parent());

    var postId = $('#post_id').val();

    console.log('クリックされたアイテム一番下に！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/posts/item_order_update/` + postId;

      // ここで<div id="sortable">の複数の子要素の<div class="item text-item">のこ要素の
      // <h2 class="item_id" style="display: none;">${itemId}</h2>をtext()を取ってきて配列を作る
      // var team_ids = [];
      // $(".item_id").each(function(i, elem) {
      //   team_ids.push($(elem).text());
      // });
      // // でその配列から'1,2,3,4'みたいな文字列を作る！
      // var item_order = team_ids.join(',');

      // console.log(team_ids);
      // console.log(item_order);

      var item_order = get_item_order();


      let data = {
        'item_order': item_order,
      };
      $.post(url, {
        data
      }, function(res) {
        console.log(res);
      }, "json");
    }
    return false;
  });
  // 一番下にする




  // ↓↓ 削除処理

  $('#sortable').on('click', '.delete-item', function() {
    if (confirm('本当に削除してよろしいですか？')) {

      var item_id = $(this).parent().parent().find('input').val();

      // 削除処理
      $(this).parent().parent().remove();

      // ここでも順番入れ替えと同じ様に先にフロントで要素を削除してしまってその削除されたitem_idだけを取得する
      // でその状態の<h2 class="item_id" style="display: none;">${itemId}</h2>をtext()で配列を作り'1,2,3,4'の様な文字列を作る
      // でそのitem_idと'1,2,3,4'の文字列と$('#post_id').val()を使ってItems@deleteにaxios接続してそのitemレコードを削除するのと
      // Postの該当のレコードのitem_orderカラムを'1,2,3,4'文字列で更新する！
      var postId = $('#post_id').val();

      console.log('クリックされたアイテムを削除！');

      // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
      if (true) {
        let url = `/items/delete/` + item_id;

        // ここで<div id="sortable">の複数の子要素の<div class="item text-item">のこ要素の
        // <h2 class="item_id" style="display: none;">${itemId}</h2>をtext()を取ってきて配列を作る
        // var team_ids = [];
        // $(".item_id").each(function(i, elem) {
        //   team_ids.push($(elem).text());
        // });
        // var item_order = team_ids.join(',');

        // console.log(team_ids);
        // console.log(item_order);

        var item_order = get_item_order();


        // でその配列から'1,2,3,4'みたいな文字列を作る！
        let data = {
          'item_order': item_order,
          'postId': postId,
        };
        $.post(url, {
          data
        }, function(res) {
          console.log(res);
        }, "json");
      }
      return false;



    }
  });




  // ↓ ↓更新処理

  $('#sortable').on('click', '.edit-item', function() {
    var form = `<div class="edit-box">
    <form>
        <textarea class="edit-control edit-form" style="width: 90%; height: 50px; margin-bottom:10px;"></textarea>
        <div>
            <input class="btn btn-primary edit_submit" type="button" value="保存する">
            <input class="btn btn-default" type="reset" value="キャンセル">
        </div>
    </form>
</div>`;

    $(this).parent().parent().after(form);
  });

  $('#sortable').on('click', '.edit_submit', function() {

    var editValue = $('.edit-control').val();
    var item_id = $(this).parent().parent().parent().prev().find('input').val();
    var target = $(this);

    console.log('アイテムを更新！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = `/items/edit/` + item_id;

      let data = {
        'editValue': editValue,
      };
      $.post(url, {
        data
      }, function(res) {

        console.log(res);
        // console.log('editのresだよ');
        // console.log(editValue);

        $('.edit-control').val('');

        target.parent().parent().parent().prev().find('p').text(editValue);

        target.parent().parent().remove();

      }, "json");
    }
    return false;






  });

  $('#sortable').on('click', '.add-item', function() {
    var form = `<div class="edit-box">
    <form>
        <textarea class="edit-control edit-form" style="width: 90%; height: 50px; margin-bottom:10px;"></textarea>
        <div>
            <input class="btn btn-primary add_submit" type="button" value="保存する">
            <input class="btn btn-default" type="reset" value="キャンセル">
        </div>
    </form>
</div>`;

    $(this).parent().parent().after(form);
  });

  $('#sortable').on('click', '.add_submit', function() {

    var editValue = $('.edit-control').val();
    var item_id = $(this).parent().parent().parent().prev().find('input').val();
    var target = $(this);

		var prev = target.parent().parent().parent().prev();

    console.log('アイテムを更新！');

    // ここでaxios送信して保存してresでItemモデルから一番新しいカラムを引っ張ってきてそのidを入れる
    if (confirm('sure?')) {
      let url = '/items/add2';

      let form = {
				'post_id': "<?php echo $post['Post']['id'] ?>",
        'comment': editValue,
      };
      $.post(url, {
        form: form,
				index: $('.item').index(prev)
      }, function(res) {

        console.log(res);
        // console.log('editのresだよ');
        // console.log(editValue);
				var itemId = res.itemId;
        $('.edit-control').val('');

				target.parents('#sortable').append(``);
        var content = `<div class="item text-item">
					<input type="hidden" class="item_list_content" name="data[Item][id]" value="${itemId}">
					<p style="margin: 0px;">${editValue}</p>
					<ul class="editpager clearfix unvisible">
					<li class="first-order">一番上へ</li>
					<li class="minus-order">上へ</li>
					<li class="plus-order">下へ</li>
					<li class="last-order">一番下へ</li>
					<li class="edit-item">編集</li>
					<li class="delete-item">削除</li>
					<li class="add-item">下に追加</li>
					</ul>
					</div>`;
					target.parent().parent().remove();
			    prev.after(content);

      }, "json");
    }
    return false;
  });
</script>
<h2>Edit Post</h2>

<?php
echo $this->Form->create('Post', array('action'=>'edit'));
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows'=>3));
echo $this->Form->end('Save!');