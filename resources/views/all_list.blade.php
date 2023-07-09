@extends('layout')

@section('bodyContent')
    <h3 class="mb-3"><i class="bi bi-view-list"></i> All List</h3>

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
                            // showPageSizeSelector: true,
                            showNavigationButtons: true,
                            pageSize: 10,
                            showInfo: true,
                        },
                        pager: {
                            showPageSizeSelector: true,
                            showNavigationButtons: true,
                            allowedPageSizes: [10, 15],
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
                                    $('<button>')
                                    .addClass('btn btn-sm btn-secondary')
                                    .text('Edit')
                                    .on('dxclick', function() {
                                        // Redirect to another page
                                        const editurl = '/update_kangaroo/' + options.data.hashedId;
                                        window.location.href = editurl;
                                    })
                                    .appendTo(container);
                                }
                            },
                        ],
                        filterRow: {
                            visible: true, // Set to true to enable the filter row
                            applyFilter: "auto",
                            operationDescriptions: {
                                equal: "Equals",
                                notEqual: "Does not equal",
                                lessThan: "Less than",
                                lessThanOrEqual: "Less than or equal to",
                                greaterThan: "Greater than",
                                greaterThanOrEqual: "Greater than or equal to",
                                startsWith: "Starts with",
                                contains: "Contains",
                                notContains: "Does not contain",
                                endsWith: "Ends with",
                                between: "Between"
                            }
                        }
                    });
                }
            };

            allList.init();

        });
    </script>
@endsection
