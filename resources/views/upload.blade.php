@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="/drive/upload" method="post" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <input type="submit" class="" value="Submit">
                            {{csrf_field()}}
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
