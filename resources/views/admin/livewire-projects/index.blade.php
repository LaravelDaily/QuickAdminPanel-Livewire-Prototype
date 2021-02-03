@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-header-container">
                <h3 class="card-title">
                    {{ trans('cruds.project.title_singular') }}
                    {{ trans('global.list') }}
                </h3>

                @can('project_create')
                    <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>
        @livewire('projects.index')

    </div>
@endsection
