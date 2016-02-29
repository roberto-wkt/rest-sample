<!DOCTYPE html>
<html>
  <head>
    <title>Usuarios</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
    <style>
      body { background: #333; color: #fff; font-size: 1.5rem; font-family: lato; }
      form label { display: inline-block; width: 4.5rem; }
      form input { background: transparent; border: #aaa solid 1px; color: #fff; padding: .5rem; font-size: 1rem; }
      form button { display: inline-block; font-size: 1rem; padding: 0 8rem; }
      ul a { color: #f66; }
    </style>
  </head>
  <body>
    <form>
      <div><label>id:</label><input name="id"></div>
      <div><label>name:</label><input name="name"></div>
      <div><label>email:</label><input name="email"></div>
      <button>send</button>
    </form>
    <ul></ul>
    <script>
      $(function () {

        $(this).on('submit', 'form', function (e) {
          e.preventDefault();
          var params = { };
          $.each($(this).serializeArray(), function (idx, field) {
            params[field.name] = field.value;
          });
          if (params.name) Ajax.saveUser(params);
        });

        $(this).on('click', 'ul a', function (e) {
          Ajax.destroy({ id: this.rel });
        });

        var Ajax = new function () {

          this.getUsers = function () {
            console.log('function %o', 'getUsers()');
            requestData({ }, { }, printList);
          };

          this.saveUser = function (params) {
            console.log('function %o %o', 'saveUser()', params);
            requestData({ type: 'POST' }, params, printList);
          };

          this.destroy = function (params) {
            console.log('function %o %o', 'destroy()', params);
            requestData({ type: 'DELETE' }, params, printList);
          };

          function requestData(customConfig, data, callback) {
            var config = $.extend({ // valores por default
              type: 'GET',
              url: '/rest-sample/public/api/users'
            }, customConfig);
            if (config.type.toUpperCase() == 'DELETE') config.url += '/' + data.id;
            console.log('requesting: %o %o', config.type, config.url);
            $.ajax({
              type: config.type,
              url: config.url,
              data: data,
              dataType: 'json',
              success: callback,
              error: function (jqXHR, textStatus, errorThrown) {
                console.error('------ RESPONSE ERROR ------\n%o', jqXHR.responseText);
                var w = window.open();
                $(w.document.body).html(jqXHR.responseText);
              }
            });
          }

          function printList(data, textStatus, jqXHR) {
            console.log('response data: %o', data);
            if (data.users) {
              $('ul').html('');
              $.each(data.users, function (i, ob) {
                $('ul').append("<li>[" + ob.id + "] " + ob.name + " | " + ob.email + " <a href='#' rel='" + ob.id + "'>remove</a></li>");
              });
            }
          }

        };

        Ajax.getUsers();

      });
    </script>
  </body>
</html>
