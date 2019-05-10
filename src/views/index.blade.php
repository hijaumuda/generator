@extends ('backend.layouts.i28')

@section ('title', trans('labels.backend.modules.management'))

@section('page-header')
    <h2>{{ trans('labels.backend.modules.management') }}</h2>
@endsection


@section('action-button')
    <div class="title-action">
        @include('generator::partials.modules-header-buttons')
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content"> 
                    <div class="table-responsive  data-table-wrapper">
                        <table id="modules-table" class="table table-condensed table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ trans('labels.backend.modules.table.name') }}</th>
                                    <th>{{ trans('labels.backend.modules.table.view_permission_id') }}</th>
                                    <th>{{ trans('labels.backend.modules.table.url') }}</th>
                                    <th>{{ trans('labels.backend.modules.table.created_by') }}</th>
                                </tr>
                            </thead>
                            <thead class="filters">
                                <tr>
                                    <th>
                                        {!! Form::text('name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.modules.table.name')]) !!}
                                        <a class="reset-data" href="javascript:void(0)" style="display: none;"><i class="fa fa-times" onClick="$(this).parent().hide()"></i></a>
                                    </th>
                                    <th>
                                        {!! Form::text('permission', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.modules.table.view_permission_id')]) !!}
                                        <a class="reset-data" href="javascript:void(0)" style="display: none;"><i class="fa fa-times" onClick="$(this).parent().hide()"></i></a>
                                    </th>
                                    <th>
                                        {!! Form::text('route', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.modules.table.url')]) !!}
                                        <a class="reset-data" href="javascript:void(0)" style="display: none;"><i class="fa fa-times" onClick="$(this).parent().hide()"></i></a>
                                    </th>
                                    <th>
                                        {!! Form::text('created_by', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.modules.table.created_by')]) !!}
                                        <a class="reset-data" href="javascript:void(0)" style="display: none;"><i class="fa fa-times" onClick="$(this).parent().hide()"></i></a>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div><!--table-responsive-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    
    <script>
        $(function() {
            var dataTable = $('#modules-table').dataTable({
                autoWidth: false,
                processing: true,
                stateSave: true,
                "sPaginationType": "full_numbers",
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.modules.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: '{{config('module.table')}}.name', sortable: false},
                    {data: 'view_permission_id', name: '{{config('module.table')}}.view_permission_id'},
                    {data: 'url', name: '{{config('module.table')}}.url'},
                    {data: 'created_by', name: '{{config('access.users_table')}}.first_name'}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: "<'centerprocess'r><'pagination-info'<'pagination-count'l>B<'pagination-links'f>>t <'pagination-info'<'pagination-count'i><'pagination-links'p><'toolbar'>>",
                initComplete: function(){
                  $("div.toolbar").html('<span class="jumto-label">Jump to</span><input id="input_page_number" class="inputnumber" autocomplete="off" onchange="JumpToPage(this.id)">');           
                },

                buttons: {
                    buttons: [
                        {
                            text: '<i class="fa fa-refresh"></i>',
                            className: "btn btn-warning btnrefresh",
                            action: function ( e, dt, node, config ) {
                                $('input').val('');
                                $('.reset-data').hide();
                                dt
                                .search( '' )
                                .columns().search( '' )
                                .draw();
                            }
                        }
                    ]
                },
                language: {
                    @lang('datatable.strings')
                },

                "fnDrawCallback": function( oSettings ) {
                    var api = this.api();

                    //change input value JumpPageNumber after draw/click page (statesave = on).
                    $('#input_page_number').val(api.page.info().page+1);
                }
            });
            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection