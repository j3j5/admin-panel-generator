@extends('vivifyideas/admin-panel-generator::main-layout')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h2>{{ ucwords(str_replace('_', ' ', str_plural($tableName))) }} <a class="btn btn-primary pull-right" href="/{{ packageConfig('prefix') }}/{{ $tableName }}/create">{{ packageTranslation('vivify.create') }}</a></h2>

      @if ($filters)
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{{ packageTranslation('vivify.filter-noun') }}</h3>
          </div>
          <div class="panel-body">
            <form class="form-inline" method="GET">
              @foreach($filters as $name => $options)
                <div class="form-group">
                  {!! Form::label($name, $options['label'], [ 'class' => 'control-label' ]) !!}
                  {!! Form::$options['type']($name, @$filterValue[$name], ['class'=>'form-control']) !!}
                </div>
              @endforeach
              <button class="btn btn-default" type="submit">{{ packageTranslation('vivify.filter-verb') }}</button>
              <a href="/{{ packageConfig('prefix') }}/{{ $tableName }}" class="btn btn-warning">{{ packageTranslation('vivify.reset') }}</a>
            </form>
          </div>
        </div>
      @endif

      @if (count($rows) == 0)
        <div class="alert alert-info" role="alert">{{ packageTranslation('vivify.no-records') }}</div>
      @else
        <table class="table table-hover">
          <thead>
            <tr>
              @foreach($columns as $col)
                <th style="{{ ($col == $orderColumn)? 'text-decoration: underline' : '' }}">
                  {{ ucfirst($col) }}
                  <a href="{{ $sortHref . '&column=' . $col }}">
                    <span class="glyphicon glyphicon-sort-by-alphabet{{ ($col == $orderColumn && $direction == 'desc')? '' : '-alt' }}"></span>
                  </a>
                </th>
              @endforeach
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($rows as $row)
              <tr>
                @foreach($columns as $col)
                  <td>{{ $row->$col }}</td>
                @endforeach
                <td class="text-right">

                  <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                      {{ packageTranslation('vivify.actions') }} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <a href="/{{ packageConfig('prefix') }}/{{ $tableName }}/edit/{{ $row->id }}">{{ packageTranslation('vivify.edit') }}</a>
                      </li>
                      <li>
                        <a onclick="return confirm('{{ packageTranslation('vivify.confirmation') }}')" href="/{{ packageConfig('prefix') }}/{{ $tableName }}/delete/{{ $row->id }}">{{ packageTranslation('vivify.remove') }}</a>
                      </li>
                    </ul>
                  </div>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="text-center">
          {!! $rows->appends(\Request::all())->render() !!}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
