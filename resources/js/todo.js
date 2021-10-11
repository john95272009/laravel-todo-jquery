const { thisTypeAnnotation } = require("@babel/types");
const { ajax } = require("jquery");

var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
    keyboard: false
})

todoObject = {
    init :function(){
        this.getList();
        this.create();
        this.changeStatus();
        this.openModal();
        this.update();
        this.delete();
    },    
    /**
     * 抓取所有task
     */
    getList:function(){
        $.ajax({
            type: "get",
            url: "api/todo",
            data: '',
            dataType: "html",
            contentType: false,
            processData: false,
            success: function (response) {
                $('#list').html(response);

            }
        });
    },
    /**
     * 建立task
     */
    create:function() {
        $('#createBtn').click(function(e) {
            e.preventDefault();
            var fd = new FormData();
            fd.append('task', $('#task').val());
            $.ajax({
                type: "post",
                url: "api/todo",
                data: fd,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(r) {
                    if (r.success) {
                        alert(r.message);
                        todoObject.getList();

                    } else {
                        alert(r.message);
                    }
                }
            });
        });
    },
    /**
     * 更改狀態顯示已完成
     * method:patch
     * @param tr 為該表格的列 || id 為該task的id
     */
    changeStatus: function() {
        $('#list').on('click', 'button[role="patchBtn"]', function(e){
            e.preventDefault();
            var tr = $(this).closest('tr');
            var id = $(tr).data('id');
            var fd = new FormData();
            fd.append('_method', 'patch');
            $.ajax({
                type: "post",
                url: 'api/todo/' + id,
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(r) {
                    if (r.success) {
                        alert(r.message);
                        todoObject.getList();
                    } else {
                        alert(r.message);
                    }
                }
            });
        });
    },
    /**
     * 更新資料
     * method:put 
     * @param fd 為formdata 抓取modal資料
    */
        update: function() {
        $('#updateBtn').click(function(e){
            e.preventDefault();
            var fd = new FormData($('#editForm')[0]);
            fd.append('_method', 'put');
            $.ajax({
                type: "post",
                url: "api/todo/" + $('#modalId').val(),
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (r) {
                    if (r.success) {
                        alert(r.message);
                        todoObject.getList();
                        myModal.hide();
                    } else {
                        alert(r.message);
                    }
                }
            });
        });
    },
    /**
     * 抓取要被編輯的資料
     * @param tr 為表格該列 || id 該task的id
    */
    openModal: function() {
        $('#list').on('click', 'button[role="editBtn"]', function(e){
            myModal.show();
            var tr = $(this).closest('tr');
            var id = $(tr).data('id');
            var fd = new FormData();
            fd.append('id', id);
            $.ajax({
                type: "get",
                url: "api/todo/" + id + '/edit',
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (r) {
                    $('#modalComplete').prop('checked', r.is_completed);
                    $('#modalTask').val(r.task);
                    $('#modalId').val(r.id);
                }
            });
        })
    },
    delete: function () {
        $('#list').on('click', 'button[role="deleteBtn"]', function(e) {
            e.preventDefault();
            if (! confirm('確定刪除嗎?')) {
                return false;
            }
            tr = $(this).closest('tr');
            id = tr.data('id');
            
            var fd = new FormData();
            fd.append('_method', 'delete');
            $.ajax({
                type: "post",
                url: "api/todo/" + id,
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (r) {
                    if (r.success) {
                        alert(r.message);
                        todoObject.getList();
                    } else {
                        alert(r.message);
                    }
                }
            });

        });
    }

}
todoObject.init();



// $('button[role="updateBtn"]').click(function(e) {
//     e.preventDefault();
//     var tr = $(this).closest('tr');
//     var task = $(tr).find('input[role="task"]').val();
//     var id = $(this).data('id');

//     var fd = new FormData();

//     fd.append('id', id);
//     fd.append('task', task);
//     fd.append('_method', 'put');
//     $.ajax({
//         type: "post",
//         url: 'todo/' + $(this).data('id'),
//         data: fd,
//         dataType: "json",
//         contentType: false,
//         processData: false,
//         success: function(r) {
//             if (r.success) {
//                 alert(r.message);
//                 location.reload();
//             }
//         }
//     });

// });
// $('button[role="deleteBtn"]').click(function(e) {
//     console.log(456);
//     var fd = new FormData();
//     fd.append('id', $(this).data('id'));
//     fd.append('_method', 'delete');
//     $.ajax({
//         type: "post",
//         url: "todo/" + $(this).data('id'),
//         data: fd,
//         dataType: 'json',
//         contentType: false,
//         processData: false,
//         success: function(r) {
//             if (r.success) {
//                 alert(r.message);
//                 location.reload();
//             }
//         }
//     });
// });

// $('button[role="completeBtn"]').click(function(e) {
//     var fd = new FormData();
//     fd.append('id', $(this).data('id'));
//     fd.append('_method', 'patch');
//     $.ajax({
//         type: "post",
//         url: "todo/" + $(this).data('id'),
//         data: fd,
//         dataType: 'json',
//         contentType: false,
//         processData: false,
//         success: function(r) {
//             if (r.success) {
//                 alert(r.message);
//                 todoObject.getList();
//                 myModal.hide();
//             } else {
//                 alert(r.message);
//             }
//         }
//     });
// });