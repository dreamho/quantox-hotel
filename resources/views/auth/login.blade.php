@extends('app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div id="error" style="color:red"></div>
        <form method="POST" action="">
            <label>Email:</label><br>
            <input type="email" name="email" class="form-control"><br>
            <label>Password:</label><br>
            <input type="password" name="password" class="form-control"><br>
            <input onclick="SubmitForm(this.form)" type="button" name="btn-submit" value="Submit" class="btn btn-info btn-block">
        </form>
    </div>
</div>

<script type="text/javascript">

    function SubmitForm(form){
        var user = {};
        user.email = form.email.value;
        user.password = form.password.value;
        $.ajax({
            type: "POST",
            url: "/api/login",
            data: user,
            dataType: "json",
            success: function (data){
                window.localStorage.setItem('jwt-token', data.token);
                window.localStorage.setItem('name', data.data.name);
                window.localStorage.setItem('user_id', data.data.id);
                window.location = "/songs";
            },
            error: function(xhr) {
                var error = xhr.responseJSON.error;
                $('#error').empty();
                switch (xhr.status) {
                    case 401:
                        $('#error').append("<p>" + error + "</p>");
                    break;
                    case 422:
                        var errors = xhr.responseJSON.errors;
                        for (var i in errors) {
                            $('#error').append("<p>" + errors[i][0] + "</p>");
                        }
                    break;
                }
            }
        });
    }
</script>
@stop
