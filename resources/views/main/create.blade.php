@extends('vivifyideas/admin-panel-generator::main-layout')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h2>New {{ ucwords(str_replace('_', ' ', str_singular($tableName))) }}</h2>

      <form method="POST" action="/{{ packageConfig('prefix') }}/{{ $tableName }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @foreach($form as $name => $options)
          @if ($name == 'hasMany')
            @foreach($options as $hasManyName => $hasManyOptions)
              <div class="form-group {{ $errors->has($hasManyName)? 'has-error' : '' }}">
                {!! Form::label($hasManyName, $hasManyOptions['label'], [ 'class' => 'control-label' ]) !!}
                {!! Form::select("hasMany[{$hasManyName}][]", $hasMany[$hasManyName], null, ['multiple' => 'multiple', 'class' => 'form-control']) !!}
              </div>
            @endforeach
          @elseif ($name == 'belongsTo')
            @foreach($options as $belongsToName => $belongsToOptions)
              <div class="form-group {{ $errors->has($belongsToName)? 'has-error' : '' }}">
                {!! Form::label($belongsToName, $belongsToOptions['label'], [ 'class' => 'control-label' ]) !!}
                {!! Form::select($belongsToOptions['column'], $belongsTo[$belongsToName], null, ['class' => 'form-control']) !!}
              </div>
            @endforeach
          @else
            <div class="form-group {{ $errors->has($name)? 'has-error' : '' }}">
              {!! Form::label($name, $options['label'], [ 'class' => 'control-label' ]) !!}
              {!! Form::$options['type']($name, null, ['class'=>'form-control']) !!}
              @if ($errors->has($name))
                <p class="help-block">{{ $errors->first($name) }}</p>
              @endif
            </div>
          @endif
        @endforeach
        <button class="btn btn-success" type="submit">Insert</button>
        <a class="btn btn-default" href="/{{ packageConfig('prefix') }}/{{ $tableName }}">Cancel</a>
      </form>

    </div>
  </div>
</div>
@endsection
