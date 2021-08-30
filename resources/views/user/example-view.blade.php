@extends('layouts.admin')
@section('title', __('user.List User') )
@section('content')
    <link rel="stylesheet" href="{{ asset('css/user/main.css') }}">
{{--    @php--}}
{{--        $gridData = [--}}
{{--            'dataProvider' => $dataProvider,--}}
{{--            'title' => 'List user ',--}}
{{--            'useFilters' => true,--}}
{{--            'rowsPerPage' => 10,--}}

{{--            'columnFields' => [--}}
{{--                'username',--}}
{{--                'phone_number',--}}
{{--                'full_name',--}}
{{--                'center_name',--}}
{{--                [--}}
{{--                    'label' => '',--}}
{{--                    'filter' => false,--}}
{{--                    'value' => function ($data) {--}}
{{--                        if(auth()->id() !== $data->id) {--}}
{{--                            $button = '';--}}
{{--                            if ($data->trashed()){--}}
{{--                                $button ='<button type="button" name="active" data-id="' . $data->id . '" class="active-user btn btn-success btn-sm">'.__('common.Active').'</button>';--}}
{{--                            }--}}
{{--                            else {--}}
{{--                                $button ='<button type="button" name="trash" data-id="' . $data->id . '" class="trash btn btn-secondary btn-sm">'.__('common.Disable').'</button>';--}}
{{--                            }--}}
{{--                            return '<button type="button" name="delete" data-id="' . $data->id . '" class="delete btn btn-danger btn-sm">'.__('common.Delete').'</button>'.--}}
{{--                               '<a href="' . route('user.getEdit', $data->id) . '" class="btn btn-primary btn-sm ml-2 mr-2">'.__('common.Edit').'</a>'. $button;--}}
{{--                        }--}}
{{--                    },--}}
{{--                    'format' => 'html',--}}
{{--                    'htmlAttributes' => [--}}
{{--                        'width' => '20%', // Width of table column.--}}
{{--                    ],--}}
{{--                ],--}}
{{--            ]--}}
{{--        ];--}}
{{--    @endphp--}}
{{--    @gridView($gridData)--}}
    <script src="{{ asset('vendor/grid-view/grid-view.bundle.js')}}"></script>
    {!! grid([
        'dataProvider' => $dataProvider,
        'rowsPerPage' => 10,
        'columns' => [
            'id',
            'username',
        ]
    ]) !!}
    @include('common.data-table')
    @if(Session::get('info'))
        <script>
            let message = '{{Session::get('info')}}'
        </script>
    @else
        <script>
            let message ='';
        </script>
    @endif

    <script src="{{ asset('js/user/index.js') }}"></script>
@endsection

