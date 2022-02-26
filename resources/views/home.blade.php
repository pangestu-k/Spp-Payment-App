@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"  style="background-color: lightgrey">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>

            <div class="card p-4">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><i class="fas fa-user-astronaut fa-4x float-left m-2"></i> Selamat <b>{{auth()->user()->name}}</b>, Anda berhasil Login</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
