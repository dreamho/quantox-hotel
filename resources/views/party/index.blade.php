@extends('app')

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@stop

@section('content')

    <div id="error" style="color:red"></div>
    <div id="success" style="color:green"></div>
    <h2>Parties Organization</h2>

    <div class="box">
        <form action="" method="POST" id="form-save" enctype="multipart/form-data">
            <input class="form-control" type="hidden" name="id" value="" />
            <label>Name</label>
            <input class="form-control" type="text" name="name" value="" />
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
            <label>Date</label>
            <input class="form-control" type="date" name="date" value=""/>
            <label>Length(hours)</label>
            <input class="form-control" type="text" name="length" value=""/>
            <label>Capacity</label>
            <input class="form-control" type="text" name="capacity" value=""/>
            <label>Tags</label>
            <input class="form-control" type="text" name="tags" value=""/>
            <label>Image</label>
            <input type="file" name="image" value="" id="img"/>

            <input class="btn btn-primary" style="margin:20px 0px;" type="button" onclick="saveParty(this.form)" name="submit_save_song" value="Save"/>
        </form>



    </div>

    <script type="text/javascript">

        $( document ).ready(function() {
            if(!getToken())
                $('#popUpWindow').modal('show');
        });

        function saveParty(form){
            var user_id = window.localStorage.getItem('user_id');
            var fd = new FormData();
            fd.append('name', $('[name="name"]').val());
            fd.append('description', $('[name="description"]').val());
            fd.append('date', $('[name="date"]').val());
            fd.append('length', $('[name="length"]').val());
            fd.append('capacity', $('[name="capacity"]').val());
            fd.append('tags', $('[name="tags"]').val());
            fd.append('image', document.getElementById('img').files[0]);
            fd.append('user_id', user_id);

            $.ajax({
                url: "api/parties",
                type: "POST",
                data: fd,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + getToken());
                },
                success: function(data)
                {
                    $('#error').empty();
                    console.log(data);
                },
                error: function(xhr) {
                    $('#error').empty();
                    var error = xhr.responseJSON.error;
                    switch(xhr.status){
                        case 400:
                            $('#error').append("<p>"+error+"</p>");
                            break;
                        case 401:
                            if(error!='token_expired'){
                                $('#error').append("<p>"+error+"</p>");
                            }
                            else{
                                window.localStorage.removeItem("jwt-token");
                                window.localStorage.removeItem("name");
                                window.localStorage.removeItem("user_id");
                                window.location = "/";
                            }
                            break;
                        case 403:
                            var error = xhr.responseJSON.error;
                            $('#error').append("<p>"+error+"</p>");
                            showLoginModal();
                            break;
                        case 422:
                            var errors = xhr.responseJSON.errors;
                            for(var i in errors){
                                $('#error').append("<p>"+errors[i][0]+"</p>");
                            }
                            break;
                    }
                }
            });
        }


    </script>

@stop
