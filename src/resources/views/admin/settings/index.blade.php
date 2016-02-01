@extends('flare::admin.sections.wrapper')

@section('page_title', 'Settings')

@section('content')

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">
                Other Settings
            </h3>
        </div>
        <form action="" method="post">
            <div class="box-body">
                @if(false)
                    @foreach ($modelAdmin->getFields() as $attribute => $field)
                        {!! \Flare::renderAttribute('edit', $attribute, $field, $modelItem, $modelAdmin) !!}
                    @endforeach
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
