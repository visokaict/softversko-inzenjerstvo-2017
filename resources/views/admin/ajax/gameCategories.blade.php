<table class="main-table">
    <thead>
        <tr>
            <th>
                <label class="checkbox-cell">
                    <input type="checkbox" id="chbSelectAll"/>
                    <span class="checkmark"></span>
                </label>
            </th>
            <th>ID</th>
            <th>Name</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idGameCategory }}">
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="chb-select-row" data-id="{{ $item->idGameCategory }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="table-cell-id">{{ $item->idGameCategory }}</td>
            <td>{{ $item->name }}</td>
            <td class="data-edit text-center"><a href="#" data-id="{{ $item->idGameCategory }}"><i class="far fa-edit"></i></a></td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $item->idGameCategory }}"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>