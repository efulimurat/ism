var sm = {
    datatables: {
        list: [],
        add: function (id, ajaxUrl,params = {}) {
            var l = this.list;
            var nt = {'id': id, 'ajaxUrl': ajaxUrl,'params' : params}
            return l.push(nt);
        }
    },
    datepickers:{
        list: [],
        add: function (id) {
            var l = this.list;
            var nt = {'id': id}
            return l.push(nt);
        }
    },
    fancybox: {
        list: [],
         add: function (_class) {
            var l = this.list;
            var nt = {'class': _class}
            return l.push(nt);
        }
    },
    charts:{
        list: [],
        add: function (id,data1=[],data2 =[],data3 =[]){
            var l = this.list;
            var nt = {'id': id,'data1':data1,"data2":data2,"data3":data3}
            return l.push(nt);
        }
    }
}