@extends('FsView::commons.layout')

@section('body')
    @include('FsView::commons.header')

    <div class="container-fluid">
        <div class="row">
            @include('FsView::app-center.sidebar')

            <div class="col-lg-10 ps-lg-0">
                <iframe src="{{ $url }}" width="100%" height="100%" class="iframe-sidebar-preview"></iframe>
            </div>
        </div>
    </div>
@endsection
