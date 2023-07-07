@extends('layout')

@section('bodyContent')
    <h3 class="text-center mb-3">All List</h3>

    <div id="all_kangaroos"></div>
@endsection

@section('customScripts')
    <script>
        $(function(){
            const allList = {
                url: '<?=env('APP_URL')."api/get_all_kangaroos"?>',
                init: function () {
                    this.loadTable()
                },
                loadTable: function () {
                    $('#all_kangaroos').dxDataGrid({
                        showBorders: true,
                        dataSource: {
                            store: {
                                type: 'odata',
                                url: allList.url,
                                key: 'id',
                            },
                            select: [
                                'name',
                                'birthday',
                                'weight',
                                'height',
                                'friendliness',
                            ],
                            remoteOperations: true,
                        },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: 'Search...',
                             searchEnabled: true,
                        },
                        paging: {
                            pageSize: 15,
                            showPageSizeSelector: true,
                            allowedPageSizes: [5, 10, 20],
                            showInfo: true,
                        },
                        pager: {
                            // showPageSizeSelector: true,
                            showNavigationButtons: true,
                            showInfo: true,
                        },
                        columns: [
                            {
                                dataField: 'name',
                                width: 250,
                            }, {
                                caption: 'Birthday',
                                dataField: 'birthday',
                                dataType: 'date',
                            }, {
                                dataField: 'weight',
                                caption: 'Weight',
                                dataType: 'number',
                            }, {
                                dataField: 'height',
                                caption: 'Height',
                                dataType: 'number',
                            }, {
                                dataField: 'friendliness',
                                caption: 'Friendliness',
                            }, {
                                caption: 'Actions',
                                cellTemplate: function(container, options) {
                                    $('<a>')
                                    .addClass('dx-link')
                                    .text('Edit')
                                    .on('dxclick', function() {
                                        // Redirect to another page
                                        const editurl = '/update_kangaroo/' + options.data.id;
                                        // window.open(editurl, '_blank');
                                        window.location.href = editurl;
                                    })
                                    .appendTo(container);
                                }
                            },
                        ],
                    });
                }
            };

            allList.init();

        });
    </script>
@endsection
