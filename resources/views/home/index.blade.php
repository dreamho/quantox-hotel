@extends('app')
@section('content')
    <div class="row">

        <div class="col-md-12 text-center"><h1>Quantox Hotel</h1></div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="images/1.jpg" alt="...">
                        <div class="carousel-caption">

                        </div>
                    </div>
                    <div class="item">
                        <img src="images/2.jpg" alt="...">
                        <div class="carousel-caption">

                        </div>
                    </div>
                    <div class="item">
                        <img src="images/3.jpg" alt="...">
                        <div class="carousel-caption">

                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6"><h3>Contact us</h3></div>
        <div class="col-md-6"><h3>Visit us</h3></div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <form>
                <label>Your name</label><br>
                <input type="text" name="name" class="form-control" ><br>
                <label>Your Email</label><br>
                <input type="email" name="email" class="form-control"><br>
                <label>Your Phone</label><br>
                <input type="number" name="phone" class="form-control"><br>
                <input type="submit" name="btn-submit" value="Submit" class="btn btn-default btn-block">

            </form>
        </div>
        <div class="col-md-6" id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2869.779476370681!2d20.900138215847058!3d44.005284479110856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4757211a385cd97d%3A0x954fc66e4e527eed!2sQuantox+Technology!5e0!3m2!1sen!2srs!4v1528207994113" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>

    </div>
    <div class="row">

        <div class="col-md-6"></div>
        <div class="col-md-6">
            <h5>Address: Kneza Mihaila 112</h5>
        </div>
    </div>
    <hr>

    <script type="text/javascript">
        console.log(window.localStorage.getItem('jwt-token'));
    </script>

@stop

@section('scripts')
    {{--<script>--}}
    {{--// Initialize and add the map--}}
    {{--function initMap() {--}}
    {{--// The location of Uluru--}}
    {{--var uluru = {lat: 44.0052845, lng: 20.9001382};--}}
    {{--// The map, centered at Uluru--}}
    {{--var map = new google.maps.Map(--}}
    {{--document.getElementById('map'), {zoom: 17, center: uluru});--}}
    {{--// The marker, positioned at Uluru--}}
    {{--var marker = new google.maps.Marker({position: uluru, map: map});--}}
    {{--}--}}
    {{--</script>--}}
    {{--<script async defer--}}
    {{--src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJa_GOv1s97tPO4NJLvVxj3hHySHZILtM&callback=initMap">--}}
    {{--</script>--}}
@stop