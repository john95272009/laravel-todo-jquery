<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Todo-List</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->
    <style>
        table button {
            margin-left: 5px
        }

    </style>
</head>

<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
          <h1>TodoList</h1>
        </div>
    </nav>
    <div class="container">

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Task</h5>
                <form class="form-inline">
                    <div class="form-group col-md-10 col-lg-10 col-sm-10">
                        <input id="task" type="text" class="form-control col-md-12 col-sm-12" id="task"
                            placeholder="Task Name">
                    </div>
                    <button id="createBtn" type="button" class="btn btn-primary">save</button>
                </form>
            </div>
        </div>
        <!-- Current Tasks -->
        <div class="card card-default">
            <div class="card-body">
                <h5 class="card-title">Tasks</h5>
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>標題</th>
                            <th>狀態</th>
                            <th>完成時間</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="list">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">編輯資料</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editForm">
                <input type="hidden" id="modalId" value="">
              <div class="mb-3">
                <input class="form-check-input" type="checkbox" value="on" name="complete" id="modalComplete">
                <label class="form-check-label" for="flexCheckDefault">
                確認完成
                </label>
   
            </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Task:</label>
                <textarea class="form-control" name="task" id="modalTask"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <button type="button" class="btn btn-primary" id="updateBtn">修改</button>
          </div>
        </div>
      </div>
    </div>


    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/todo.js') }}"></script>
</body>

</html>
