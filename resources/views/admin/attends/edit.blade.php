@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attend
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($attend, ['route' => ['admin.attends.update', $attend->id], 'method' => 'patch']) !!}

                        @include('admin.attends.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection