@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="">
                <label>Name:</label><br>
                <input type="text" name="name" class="form-control"><br>
                <label>Email:</label><br>
                <input type="email" name="email" class="form-control"><br>
                <label>Password:</label><br>
                <input type="password" name="password" class="form-control"><br>
                <input onclick='SubmitForm(this.form)' type="button" name="btn-submit" value="Submit" class="btn btn-info btn-block">
            </form>
        </div>
    </div>

    <script type="text/javascript">

        function SubmitForm(form){
            var user = {};
            user.name = form.name.value;
            user.email = form.email.value;
            user.password = form.password.value;
            $.ajax({
                type: "POST",
                url: "register",
                data: user,
                dataType: "json",
                success: function (data){
                    window.localStorage.setItem('jwt-token', data.token);
                    window.location="http://quantox-hotel.local/songs";
                }
            });
        }

    </script>
@stop