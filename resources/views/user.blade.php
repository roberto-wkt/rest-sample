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
      ul a { color: #fc6; }
    </style>
  </head>
  <body>
    <form>
      <div><label>id:</label><input id="txtId"></div>
      <div><label>name:</label><input id="txtName"></div>
      <div><label>email:</label><input id="txtEmail"></div>
      <button>send</button>
    </form>
    <ul></ul>
    <script>
      $(function () {

        $(this).on('submit', 'form', function (e) {
          e.preventDefault();
          rest.ajax('get', { id: $('#txtId').val() });
        });

        var rest = {
          show: function (data) {
            if (data) {
              $.each(data, function (i, ob) {
                //$('ul').append("<li>[" + ob.id + "] " + ob.name + " | " + ob.email + " <a href='#' rel='" + ob.id + "'>remove</a></li>");
              });
            }
          },
          store: function () {

          },
          update: function () {

          },
          destroy: function () {

          },
          ajax: function (type, param) {
            var params = $.extend({ // valores por default
              id: '',
              callback: 'show'
            }, param);
            $.ajax({
              type: type,
              url: '/rest-sample/public/api/user' + ((params.id > 0) ? '/' + params.id : ''),
              param: params,
              dataType: 'json',
              success: function (data, textStatus, jqXHR) {
                rest[params.callback](data); // redirigir a callback
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.error(jqXHR.responseText);
              }
            });
          }
        };

        rest.ajax('get');

      });
    </script>
  </body>
</html>
