<header>
Hello, <?PHP echo $data['username'] .' '. $data['log_button'] ?>
</header>

<section>
    <div class="table-container">
      <table class="table-bordered">
          <tr>
            <th class="sort_name">имя пользователя</th>
            <th class="sort_email">Email</th>
            <th>текст задачи</th>
            <th class="sort_status">Статус</th>
            <th>Опции</th>
          </tr>
          <?php 
            echo $data['htmlTableBody'];
          ?>
      </table>
</section>

<section>
      <div class="btn-toolbar">
          <?php 
            echo $data['htmlButtonToolbar'];
          ?>
           | <button class="create_btn" type="button">СОЗДАТЬ</button>
      </div>
    </div>  
</section>

<section>
  <div class='add_form_container'>
    <div class="new_task_container">
        <h3>ДОБАВЛЕНИЕ</h3>
        <form class="add_form" action="">
          <button type="button" class="add_close_btn">X</button><br />
          <input class="add_form" type="text" name="username" placeholder="Username"><br />
          <input class="add_form" type="text" name="email" placeholder="Email"><br />
          <textarea class="add_form" name="text_task"
              rows="5" cols="33"></textarea><br />
          <button type="button" class="add_form btn_edit" >Send</button>
        </form>
      <div class="message">
      </div>
    </div>
  </div>
</section>

<section>
    <div class="admin_edit_container">
      <div class="status_snd">test</div>
      <button type="button" class="edit_close_btn">X</button><br />
      <input type="hidden" disabled name="taskID" class="taskID">
      <textarea class="admin_edit_task" name="admin_edit_task" rows="5" cols="33"></textarea><br />
      <button type="button" class="send_edit" >Save</button>
    </div>
</section>

<script>
  var userName = document.cookie.replace(/(?:(?:^|.*;\s*)userName\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/, "$1");
  //скрипт не выносил намеренно из за хостингов
  $(".send_edit").click(function() {
    let url = '/home/edit';
    let data_obj = {
      'id': $('.taskID')[0].value,
      'text': $('.admin_edit_task')[0].value,
      'token': token,
    };
    let res = sendPost(data_obj, url);
    $('.status_snd').text(res);
    if (res == 'OK') {
    }
  });

  $(".edit_close_btn").click(function() {
    $(".admin_edit_container").hide(100);
  });

  $(".edit_admin_btn").click(function() {
    let id = $(this).attr("data-id");
    let text = $('.tsk_' + id).text();
    $(".taskID").val(id);
    $(".admin_edit_task").val(text);
    $(".admin_edit_container").show(100);
  });

  $(".create_btn").click(function() {
      $(".add_form_container").show(500);
  });

  $(".check_admin_btn").click(function() {
      let id = $(this).attr("data-id");
      let url = '/home/check/' + id + '/' + token;
      let res = sendPost({}, url);
      location.reload();
  });

  $(".add_close_btn").click(function() {
    $(".add_form_container").hide(500);
  });
  
  $(".btn_edit").click(function() {
    var data_obj = {
      'email': $("input[name*='email']")[0].value,
      'username': $("input[name*='username']")[0].value,
      'text': $("textarea[name*='text_task']")[0].value,
    };

    var url = '/home/add';
    var msg = sendPost(data_obj, url);
    if (msg == 'OK') {
          location.reload(1000);
        }
        $(".message").text(msg);
        $(".message").show();

  });

  $('.sort_name').click(function() {
    sort('username');
  });

  $('.sort_email').click(function() {
    sort('email');
  });

  $('.sort_status').click(function() {
    sort('status');
  });

  function sort(sortBy) {
    let data_obj = {
      'sort': sortBy,
    };
    let url = '/home';
    sendPost(data_obj, url);
    location.reload();
  };

  function sendPost(data_obj, url) {
    let value = '';
    $.ajax({
    type: 'POST',
    async: false,
    url: url,
    data: data_obj,
    success: function(data) {
            value = data;
        }
    });
    return value;
  }; 
  
</script>