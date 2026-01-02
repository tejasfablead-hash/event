@extends('index')
@section('container')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h5 class="page-title pr-5">
                    <div id="message" class="alert alert-success text-center d-none" role="alert"></div>
                </h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Basic elements</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Event</h4>
                        <br>
                        <form class="form-sample" id="eventform" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="form-control" value="{{ $event->id }}"
                                    placeholder="enter title">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $event->title }}" placeholder="enter title">
                                            <span class="text-danger error" id="title_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="price" value="{{ $event->price }}"
                                                class="form-control" placeholder="enter price" />
                                            <span class="text-danger error" id="price_error"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">

                                            <select class="form-control" name="city">
                                                @foreach ($city as $cities)
                                                    <option value="{{ $cities->id }}"
                                                        {{ isset($event) && $cities->id == $event->city ? 'selected' : '' }}>
                                                        {{ $cities->city_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error" id="city_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="{{ $event->desc }}" name="description"
                                                class="form-control" placeholder="enter description">
                                            <span class="text-danger error" id="description_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="category">
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($event) && $item->id == $event->category ? 'selected' : '' }}>
                                                        {{ $item->category_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error" id="category_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Capacity</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="capacity" value="{{ $event->capacity }}"
                                                class="form-control" placeholder="enter capacity">
                                            <span class="text-danger error" id="capacity_error"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">

                                            <input type="file" id="imageFile" name="image[]" accept="image/*"
                                                multiple /><br>
                                            @php
                                                $images = json_decode($event->image, true);
                                            @endphp
                                            @if (is_array($images) && count($images) > 0)
                                                @foreach ($images as $path)
                                                    <img src="{{ asset('/storage/' . $path) }}" alt="img"
                                                        height="50px" width="50px" class="border rounded mt-2" />
                                                @endforeach
                                            @else
                                                <img src=" {{ asset('images/faces/face1.jpg') }}"height="50px"
                                                    width="50px"class="border rounded mt-2" />
                                            @endif
                                            <span class="text-danger error" id="image_error"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <input type="submit" class="btn btn-gradient-primary mr-2" value="Update">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ajax.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#eventform').submit(function(e) {
                    e.preventDefault();
                    var data = $('#eventform')[0];
                    var formData = new FormData(data);

                    $('.error').text('');
                    var url = "{{ route('EventUpdatePage') }}";
                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        console.log(response.message);
                        if (response.status == true) {
                            $('#message').removeClass('d-none').html(response.message).fadeIn();
                            setTimeout(function() {
                                $('#message').addClass('d-none').html('').fadeOut();
                                window.location.href = "{{ route('EventViewPage') }}";
                            }, 4000);
                        }
                        $('#eventform')[0].reset();
                        $(".error").empty();
                    }, function(error) {
                        console.log(error);
                    });

                });
            });
        </script>

    @endsection
