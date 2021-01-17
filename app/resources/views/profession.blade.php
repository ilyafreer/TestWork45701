@extends('layouts.profession')

@section('content')
    <div class="container professions">
        <div class="row d-flex align-items-center">
            <profession-create></profession-create>
            <profession-list></profession-list>
        </div>
    </div>
@endsection
