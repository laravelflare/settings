@extends('flare::admin.sections.wrapper')

@section('page_title', 'Settings')

@section('content')

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ $panel->title() }}
            </h3>
        </div>
        <form action="" method="post">
            <div class="box-body">
                @if(count($panel->fields()))
                    @foreach ($panel->fields() as $attribute => $field)
                        {{ $field->render('edit') }}
                    @endforeach
                @else
                    <p>
                        This settings panel does not have any options defined.
                    </p>
                @endif
            </div>
            <div class="box-footer">
                {!! csrf_field() !!}
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-cog"></i>
                    Update Settings
                </button>
            </div>
        </form>
    </div>

@endsection
