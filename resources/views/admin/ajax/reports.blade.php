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
            <th>Reason</th>
            <th>User</th>
            <th>Created at</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idReport }}">
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="chb-select-row" data-id="{{ $item->idReport }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td>{{ $item->idReport }}</td>
            <td>{{ $item->reason }}</td>
            <td><a href="{{ asset('/user/' . $item->username) }}">{{ $item->username }}</a></td>
            <td>{{ date("d/m/Y h:i A", $item->createdAt) }}</td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $item->idReport }}"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>