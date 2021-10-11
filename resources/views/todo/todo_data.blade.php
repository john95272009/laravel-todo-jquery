@foreach ($datas as $v)
    <tr data-id="{{ $v->id }}">
        <td>{{ $v->id }}</td>
        <td>{{ $v->task }}</td>
        <td>{!! $v->is_completed ? '<button role="patchBtn" class="btn btn-success btn-sm" disabled>complete</button>':'<button role="patchBtn" class="btn btn-warning btn-sm">complete</button>' !!}</td>
        <td>{{ $v->completed_at }}</td>
        <td>
            <button role="editBtn" class="btn btn-sm btn-secondary">更新</button>
            <button role="deleteBtn" class="btn btn-sm btn-danger">刪除</button>
        </td>
    </tr>
@endforeach