<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Quantox Hotel</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript">
        // Login Modal
        function showLoginModal() {
            $('#popUpWindow').modal('show');
        }

        function setUser (email, password) {
            $('.modal input[name=email]').val(email);
            $('.modal input[name=password]').val(password);
        }

        // Login user from the modal
        function login(event) {
            event.preventDefault();

            var form = $('#modal-form');
            var user = {};
            user.email = $(form.find('[name=email]')).val();
            user.password = $(form.find('[name=password]')).val();
            request('/api/login', 'POST', user, function (data){
                window.localStorage.setItem('jwt-token', data.token);
                window.localStorage.setItem('name', data.data.name);
                window.localStorage.setItem('user_id', data.data.id);
                window.location = "/songs";
            });
        }

        // Logout user
        function logout(){
            $.ajax({
                type: "POST",
                url: "/api/logout",
                dataType: 'json',
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + window.localStorage.getItem('jwt-token'));
                },
                complete: function(xhr){
                    if (xhr.status==200){
                        window.localStorage.removeItem("jwt-token");
                        window.localStorage.removeItem("name");
                        window.localStorage.removeItem("user_id");
                        window.location = "/";
                    }
                }
            });
        }

        function getToken() {
            if (token) {
                return token;
            }
        }

        function request(url, method, data, successCallback) {
            $.ajax({
                type: method,
                url: url,
                data: data ? data : null,
                dataType: "json",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + getToken());
                },
                success: function (data) {
                    if (successCallback) {
                        successCallback(data);
                    }
                },
                error: function(xhr) {
                    var error = xhr.responseJSON.error;
                    switch(xhr.status){
                        case 400:
                            $('#error').append("<p>"+error+"</p>");
                            break;
                        case 401:
                            $('#error').append("<p>"+error+"</p>");
                            break;
                        case 403:
                            var error = xhr.responseJSON.error;
                            $('#error').append("<p>"+error+"</p>");
                            clearMsg();
                            showLoginModal();
                            break;
                        case 422:
                            var errors = xhr.responseJSON.errors;
                            for(var i in errors){
                                $('#error').append("<p>"+errors[i][0]+"</p>");
                            }
                            clearMsg();
                            break;
                    }
                }
            });
        }
    </script>

</head>