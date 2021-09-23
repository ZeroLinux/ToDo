
const myApp = new Vue({
    el: '#app',
    data: {
        todo:{
            id: '',
            userId: '',
            title: '',
            completed: '',
        }
    },
    methods: {
        searchById: function () {
            var url = '/todos/get/id/';
            var me = this;

            axios.get(url + this.todo.id).then(function (response) {
                //Poblamos nuestro objeto 'todo' con los datos retornados
                me.todo = response.data;
                toastr.success('Se ha importado el To Do', {timeOut: 6000});
            }).catch(function (error) {
                console.log(error);
            });
        },
        modifyTodo: function (row) {
            this.todo = row;
        },
        save: function (){
            var url = '/todos/store/';
            var data = this.todo;

            console.log(data);

            //Validar formulario
            if ( ! $('#myForm')[0].checkValidity() ) return false;

            axios.put(url, data).then(function (response) {

                var res = JSON.stringify(response.statusText);
                myApp.dataTable.ajax.reload();
                toastr.success(res, 'Información', {timeOut: 6000});

                //limpiar formulario:
                Object.keys(data).forEach(key => { data[key] = ''; });

            }).catch(function (error) {
                console.log(error);
            });
        },
        deleteById: function (id) {
            var url = '/todos/del/id/' + id;
            axios.get(url).then(function (response) {
                myApp.dataTable.ajax.reload();
                toastr.info('se ha eliminado el registro', {timeOut: 6000});
            }).catch(function (error) {
                console.log(error);
            });
        },
        clear: function () {
            //Restablecemos el objeto 'todo' para una nueva búsqueda
            Object.keys(this.todo).forEach(key => { this.todo[key] = ''; });
        }
    },
    mounted: function () {
        let data = '/todos/list/';
        this.dataTable = $('#dataTable').DataTable({
            ajax: {
                url: data,
                dataSrc: ''
            },
            columns: [
                { data: "id" },
                { data: "title" },
                { data: "completed", 
                    render: function ( data, type, full, meta ) {
                        if(data == 0){
                            return 'Completado';
                        }else{
                            return 'Pendiente';
                        }
                    }
                },
                { /*Action buttons:*/ data: "id",
                    render: function ( data, type, full, meta ) {
                        dataObj = JSON.stringify(full);
                        return '<a onclick=\'myApp.modifyTodo('+dataObj+', 3);\' class="uk-button" uk-icon="icon: pencil"></a>';
                    }
                },
                { /*Action buttons:*/ data: "id",
                    render: function ( data, type, full, meta ) {
                        dataObj = JSON.stringify(full);
                        return '<a onclick=\'myApp.deleteById('+data+');\' class="uk-button" uk-icon="icon: trash"></a>';
                    }
                }
            ],
            columnDefs: [
                { width: '10%', targets: [3] }
            ],
            aaSorting: [[ 0, "asc" ]],
            language: {
                lengthMenu: 'Mostrar _MENU_ registros',
                search: '<span>Buscar</span> _INPUT_',
                searchPlaceholder: 'Criterio de busqueda...',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' },
                info: 'Mostrando _START_ a _END_ de _TOTAL_ registros'
            },
        });
        //limpiar formulario
        $('#myFormModal').on('hide.bs.modal', function (e) {
            myApp.dataClean();
        })
    }
});