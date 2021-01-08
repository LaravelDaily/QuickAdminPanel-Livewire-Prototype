@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-row">
                <h6 class="card-title">{{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}</h6>
            </div>
        </div>

        <div class="card-body">
            @livewire('projects.create')
        </div>
    </div>
@endsection
