@extends('app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div id="msg" style="color:red"></div>
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
                console.log(data);
                window.localStorage.setItem('jwt-token', data.token);
                window.localStorage.setItem('role', data.user.role);
                window.localStorage.setItem('user_id', data.user.id);
                window.location="http://quantox-hotel.local/songs";
            },
            error: function(data) {
                $('#msg').empty();
                var errors = data.responseJSON;
                for(var i in errors.errors){
                    for(var j=0;j<errors.errors[i].length;j++){
                        $('#msg').append("<p>"+errors.errors[i][j]+"</p>");
                    }
                }
            }
        });
    }
</script>
@stop
