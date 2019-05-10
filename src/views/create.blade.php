@extends ('backend.layouts.app')

@section ('title', trans('generator::labels.modules.management') . ' | ' . trans('generator::labels.modules.create'))

@section('page-header')
    <h2>{{ trans('generator::labels.modules.create') }}</h2>
@endsection

@section('action-button')
    <div class="title-action">
        @include('generator::partials.modules-header-buttons')
    </div>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.modules.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-module', 'files' => true]) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>{{ trans('generator::labels.modules.create') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="get">
                            <div class="form-group now">
                                @include("generator::form")
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    {{ link_to_route('admin.modules.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-white btn-md']) }}
                                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection
