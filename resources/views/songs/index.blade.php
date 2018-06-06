@extends('app')

@section('content')

<script type="text/javascript">
    var token = window.localStorage.getItem('jwt-token');
    function send(){
        $.ajax({
            type: "GET",
            url: "api/allsongs",
            beforeSend: function(request) {
                request.setRequestHeader("Authorization", token);
            },
            success: function (data){
                console.log(data);
            }

        });
    }
    send();
</script>

@stop