<table class="main-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Reason</th>
            <th>Created at</th>
            <th class="text-center">Close?</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idReport }}">
            <td>{{ $item->idReport }}</td>
            <td><a href="{{ asset('/user/' . $item->username) }}">{{ $item->username }}</a></td>
            <td>{{ $item->reason }}</td>
            <td>{{ date("d/m/Y h:i A", $item->createdAt) }}</td>
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="checkbox-block" autocomplete="off" data-id="{{ $item->idReport }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>