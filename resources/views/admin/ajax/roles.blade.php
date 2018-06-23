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
            <th>Text</th>
            <th>Is Available For User</th>
            <th>Description</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idRole }}">
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="chb-select-row" data-id="{{ $item->idRole }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="table-cell-id">{{ $item->idRole }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->text }}</td>
            <td>{{ $item->isAvailableForUser === 1 ? "Yes" : "No" }}</td>
            <td>{{ $item->description }}</td>
            <td class="data-edit text-center"><a href="#" data-id="{{ $item->idRole }}"><i class="far fa-edit"></i></a></td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $item->idRole }}"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>