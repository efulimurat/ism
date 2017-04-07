/**
 * DataTable
 */

var initDataTables = {
    issueListTable: function (ajaxUrl) {
        var status = 1;
        var issueTable = $("#issueListTable").DataTable({
            /*"language": {
                "url": "/public/js/datatable_tr_TR.json"
            },*/
            dom: 'lrtip',
            responsive: true,
            bAutoWidth: false,
            select: true,
            
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                data: function (d) {
                    d.status = status;
                },
                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data
                }
            },
            "order": [[1, 'desc']],
            "columns": [
                {"data": "baslik",
                    "render": function (data, type, row) {
                        return '<a href="/edit_issue/' + row.id + '">' + data + '</a>';
                    },
                },
                {"data": "kayit_tarihi",
                    "render": function (data, type, row) {
                        var _date = new Date(data.date);
                        var rDate = moment(_date.toString()).format('DD/MM/YYYY HH:mm:ss');
                        return rDate;
                    }
                },
                {"data": "duzenleme_tarihi",
                    "render": function (data, type, row) {
                        var _date = new Date(data.date);
                        var rDate = moment(_date.toString()).format('DD/MM/YYYY HH:mm:ss');
                        return rDate;
                    }
                },
                {"data": "durum",
                    "render": function (data, type, row) {

                        if (row.durum == 1) {
                            return '<button type="button" class="btn btn-warning btn-xs">Open</button>';
                        } else {
                            return '<button type="button" class="btn btn-danger btn-xs">Closed</button>';
                        }
                    },
                    "orderable": false
                },
                {"data": "durum",
                    "render": function (data, type, row) {

                        if (row.durum == 1) {
                            return '<button data-issueid="' + row.id + '" type="button" class="changeIssueStatus btn btn-danger btn-xs">Close</button>';
                        } else {
                            return '';
                        }
                    },
                    "orderable": false
                }
            ]
        });
        $(document).on("click", ".changeIssueStatus", function () {
            if (confirm("Are you sure about closing the issue?")) {
                var issueId = $(this).data("issueid");
                $.ajax({
                    "type": "POST",
                    "dataType": "json",
                    "data": {"id": issueId},
                    "url": "/issues/updateStatus",
                    "success": function (e) {
                        if (e.result == "success") {
                            issueTable.ajax.reload();
                        }
                    }
                })
            }
        });
        function focusButton(eq) {
            if ($(".changeStatus").eq(eq).hasClass('btn-primary')) {
                return false;
            } else {
                $(".changeStatus").removeClass('btn-primary');
                $(".changeStatus").eq(eq).addClass('btn-primary');
                return true;
            }
        }

    },
}

var initDatepickers = {
}

var initCharts = {
}

var initMessage = {
    check: function (data) {
        if (data.message) {
            var msg = data.message;
            var msgType = msg.type;
            return this[msgType](msg.resultType, msg.title, msg.text)
        }
    },
    notify: function (result, title, message) {
        return new PNotify({
            title: title,
            text: message,
            type: result
        });
    }
}