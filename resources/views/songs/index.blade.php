@extends('app')

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@stop

@section('content')

    <div><h4><span id="msg" style="color:red"></span></h4></div>
    <h2>Songs administration</h2>
    <!-- add song form -->
        <div id="save_form">
            <h3>Add a song</h3>
            <form action="" method="POST" id="save-form">
                <label>Artist</label>
                <input class="form-control" type="text" name="artist" value="" />
                <label>Track</label>
                <input class="form-control" type="text" name="track" value="" />
                <label>Link</label>
                <input class="form-control" type="text" name="link" value=""/>
                <label>Length</label>
                <input class="form-control" type="text" name="length" value=""/>
                <input class="btn btn-block btn-primary" style="margin:20px 0px;" type="button" onclick='saveSong(this.form)' name="submit_add_song" value="Save"/>
            </form>
        </div>
    <div id="edit_form" class="box" style="display:none">
        <h3>Edit song</h3>
        <form action="" method="POST" id="edit-form">
            <input class="form-control" type="hidden" name="id" value="" />
            <label>Artist</label>
            <input class="form-control" type="text" name="artist" value="" />
            <label>Track</label>
            <input class="form-control" type="text" name="track" value="" />
            <label>Link</label>
            <input class="form-control" type="text" name="link" value=""/>
            <label>Length</label>
            <input class="form-control" type="text" name="length" value=""/>
            <input class="btn btn-block btn-primary" style="margin:20px 0px;" type="button" onclick='editSong(this.form)' name="submit_add_song" value="Edit"/>
        </form>
    </div>

    <!-- main content output -->
    <div>
        <h3>List of songs (data from first model)</h3>
        <table class="table">
            <thead>
            <tr>
                <td>Id</td>
                <td>Artist</td>
                <td>Track</td>
                <td>Link</td>
                <td>Length</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody id="rows">

            </tbody>
        </table>
    </div>
    </div>
    <div id="paginate"></div>
    <script type="text/javascript">

        var token = window.localStorage.getItem('jwt-token');
        var user_id = window.localStorage.getItem('user_id');
        var edit_form = document.getElementById('edit_form');
        var save_form = document.getElementById('save_form');
        var msg = document.getElementById('msg');

        // Delete song
        function deleteSong(id){
            $.ajax({
                type: "GET",
                url: "api/delete/"+id,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data){
                    alert('Deleted');
                    $('#' + data).remove();
                }
            });
        }
        // Save song
        function saveSong(form){
            var song = {};
            song.artist = form.artist.value;
            song.track = form.track.value;
            song.link = form.link.value;
            song.length = form.length.value;
            song.user_id = user_id;
            $.ajax({
                type: "POST",
                url: "api/savesong",
                data: song,
                dataType: "json",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data){
                    alert('Saved');
                    var song = data.data;
                    var tr = $("<tr />");
                    tr.append("<td>"+ song.id +"</td><td>"+ song.artist +"</td><td>"+ song.track +"</td><td>"+ song.link +"</td><td>"+ song.length +"</td>");
                    tr.append("<td><a onclick='deleteSong(" + song.id + ")' href='#'>Delete</a><td><a onclick='editForm(" + song.id + ")' href='#'>Edit</a></td>");
                    tr.attr('id', song.id);
                    $('#rows').append(tr);
                    $('#save-form')[0].reset();

                },
                error: function(xhr) {
                    switch(xhr.status){
                        case 403:
                            var error = xhr.responseJSON.error;
                            $('#msg').append("<p>"+error+"</p>");
                            clearMsg();
                        break;
                        case 422:
                            var errors = xhr.responseJSON.errors;
                            for(var i in errors){
                                $('#msg').append("<p>"+errors[i][0]+"</p>");
                            }
                            clearMsg();
                        break; 
                    }
                }
            });
        }

        // Fillling the form for editing
        function editForm(id){
            edit_form.style.display = "block";
            save_form.style.display = "none";
            $.ajax({
                type: "GET",
                url: "api/getbyid/"+id,
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data){
                    var song = data.data;
                    var form = $('#edit-form')[0];
                    form.id.value = song.id;
                    form.artist.value = song.artist;
                    form.track.value = song.track;
                    form.link.value = song.link;
                    form.length.value = song.length;
                },
                error: function(xhr){
                    var error = xhr.responseJSON.error;
                    $('#msg').append("<p>"+error+"</p>");
                    clearMsg();
                }
            });
        }

        // Edit song
        function editSong(form){

            var song = {};
            song.id = form.id.value;
            song.artist = form.artist.value;
            song.track = form.track.value;
            song.link = form.link.value;
            song.length = form.length.value;
            $.ajax({
                type: "POST",
                url: "api/editsong",
                data: song,
                dataType: "json",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data){
                    alert('Updated');
                    var song = data.data;
                    var tr = $('#' + song.id).empty();
                    for(var j in song){
                        tr.append("<td>" + song[j] + "</td>");
                    }
                    tr.append("<td><a onclick='deleteSong(" + song.id + ")' href='#'>Delete</a><td><a onclick='editForm(" + song.id + ")' href='#'>Edit</a></td>");
                    tr.attr('id', song.id);

                    $('#edit-form')[0].reset();
                    edit_form.style.display = "none";
                    save_form.style.display= "block";
                },
                error: function(xhr) {
                    switch(xhr.status){
                        case 403:
                            var error = xhr.responseJSON.error;
                            $('#msg').append("<p>"+error+"</p>");
                            clearMsg();
                        break;
                        case 422:
                            var errors = xhr.responseJSON.errors;
                            for(var i in errors){
                                $('#msg').append("<p>"+errors[i][0]+"</p>");
                            }
                            clearMsg();
                        break; 
                    }
                }
            });
        }
        // Get all songs
        function getSongs(){
            $.ajax({
                type: "GET",
                url: "api/getsongs",
                dataType: "json",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data){
                    console.log(data);
                    $("#rows").html("");
                    var songs = data.data;
                    for(var i=0;i<songs.length;i++) {
                        var tr = $("<tr />");
                        var song = songs[i];
                        for(var j in song){
                            tr.append("<td>" + song[j] + "</td>");
                        }
                        tr.append("<td><a onclick='deleteSong(" + song.id + ")' href='#'>Delete</a><td><a onclick='editForm(" + song.id + ")' href='#'>Edit</a></td>");
                        tr.attr('id', song.id);
                        $('#rows').append(tr);
                    }
                },
                error: function(data){
                    $('#msg').append("<p>"+data.responseJSON.error+"</p>");
                }

            });
        }

        // Clear message
        function clearMsg(){
            setTimeout(function () {
                msg.innerHTML = "";
            }, 5000);
        }
        getSongs();
    </script>
@stop
