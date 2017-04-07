// Datatable'ları yükle
$.each(sm.datatables.list, function () {
    _funct = this.id;
    _url = this.ajaxUrl;
    _params = this.params;

    initDataTables[_funct](_url,_params);
})

// Datepicker'ları yükle
$.each(sm.datepickers.list, function () {
    _funct = this.id;
    _url = this.ajaxUrl;

    initDatepickers[_funct](_url);
})

// Fancbox
$.each(sm.fancybox.list, function () {
    _cn = this.class;

    $('.'+_cn).fancybox();
})

// charts
$.each(sm.charts.list, function () {
    _funct = this.id;
    _data1 = this.data1;
    _data2 = this.data2;
    _data3 = this.data3;

    initCharts[_funct](_data1,_data2,_data3);
})