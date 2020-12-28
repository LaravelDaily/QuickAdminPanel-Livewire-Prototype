@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-row">
                <h6 class="card-title">{{ trans('cruds.project.title_singular') }} {{ trans('global.list') }}</h6>
                @can('project_create')
                    <a class="card-button" href="{{ route('admin.livewire-projects.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @livewire('projects.index')
            </div>
        </div>
    </div>
@endsection
