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
            <th>Path</th>
            <th>Name</th>
            <th>Position</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idNavigation }}">
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="chb-select-row" data-id="{{ $item->idNavigation }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="table-cell-id">{{ $item->idNavigation }}</td>
            <td>{{ $item->path }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->position }}</td>
            <td class="data-edit text-center"><a href="#" data-id="{{ $item->idNavigation }}"><i class="far fa-edit"></i></a></td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $item->idNavigation }}"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>