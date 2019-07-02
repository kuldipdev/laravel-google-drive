@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @include('snippets.notification')
                        You are logged in!
                        <br><br>
                        <a href="{{ route('upload') }}" class="btn btn-primary"> Upload File </a>

                        <hr>
                        <h3> Available Files  </h3>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($listFiles as $listFile)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td width="60%"> {!! ($listFile->name) ? $listFile->name : '' !!}</td>
                                        <td>
                                            <a href="{{ $listFile->webViewLink }}" target="_blank" class="btn btn-info">
                                                View </a>
                                            @if(!empty($listFile->webContentLink))
                                                <a href="{{ $listFile->webContentLink }}" class="btn btn-info">Download</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
