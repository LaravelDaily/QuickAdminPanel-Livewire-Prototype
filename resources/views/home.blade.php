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
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent

@endsection