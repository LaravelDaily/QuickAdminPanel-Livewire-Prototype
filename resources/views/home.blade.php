@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="card w-full">
            <div class="card-header">
                <div class="card-row">
                    <h6 class="card-title">
                        Dashboard
                    </h6>
                    {{--                    <button--}}
                    {{--                            class="card-button"--}}
                    {{--                            type="button"--}}
                    {{--                    >--}}
                    {{--                        Settings--}}
                    {{--                    </button>--}}
                </div>
            </div>

            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!

                <br/>
                <br/>
                <br/>
                <br/>
                <br/>

                <ul>
                    <li class="font-bold">Pages that were changed!</li>
                    <li>Homepage (currently open)</li>
                    <li>Change password page (to display multi-box layout)</li>
                    <li>Livewire projects (table, forms)</li>
                    <li>TBD.... Auth pages</li>
                </ul>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent

@endsection