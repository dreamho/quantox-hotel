@extends('app')

@section('content')

    <div><h2><span id="msg" style="color:green"></span></h2></div>
    <h2>You are in the View: application/view/song/index.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
        <div id="save_form">
            <h3>Add a song</h3>
            <form action="" method="POST">
                <label>Artist</label>
                <input class="form-control" type="text" name="artist" value="" />
                <label>Track</label>
                <input class="form-control" type="text" name="track" value="" />
                <label>Link</label>
                <input class="form-control" type="text" name="link" value=""/>
                <label>Length</label>
                <input class="form-control" type="text" name="length" value=""/>
                <input type="hidden" name="user_id" value="1">
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
        <h3>Amount of songs (data from second model)</h3>
        <div>
            <strong></strong>
        </div>
        <h3>Amount of songs (via AJAX)</h3>
        <div>
            <button id="javascript-ajax-button">Click here to get the amount of songs via Ajax (will be displayed in
                #javascript-ajax-result-box)
            </button>
            <div id="javascript-ajax-result-box"></div>
        </div>
        <hr>
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
        var tbody = document.getElementById('rows');
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
                    getSongs();
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    for(var i in errors.errors){
                        $('#msg').append("<p>"+errors.errors[i][0]+"</p>");
                    }
                    clearMsg();
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
            song.user_id = form.user_id.value;
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

                },
                error: function(data) {
                    var errors = data.responseJSON;
                    for(var i in errors.errors){
                        $('#msg').append("<p>"+errors.errors[i][0]+"</p>");
                    }
                    clearMsg();
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
                error: function(data) {
                    var errors = data.responseJSON;
                    for(var i in errors.errors){
                        $('#msg').append("<p>"+errors.errors[i][0]+"</p>");
                    }
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
                    $('#edit-form')[0].reset();
                    edit_form.style.display = "none";
                    save_form.style.display= "block";
                    getSongs();
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    for(var i in errors.errors){
                        $('#msg').append("<p>"+errors.errors[i][0]+"</p>");
                    }
                    clearMsg();
                }
            });
        }
        // Get all songs
        function getSongs(){
            $.ajax({
                type: "GET",
                url: "api/getsongs",
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
                }

            });
        }

        // Clear message
        function clearMsg(){
            setTimeout(function () {
                msg.innerHTML = "";
            }, 3000);
        }
        getSongs();
    </script>
@stop
