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
            <th>Username</th>
            <th>E-mail</th>
            <th class="text-center">Avatar</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th class="text-center">Banned</th>
            <th class="text-center">Roles</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $user)
        <tr data-id="{{ $user->idUser }}">
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="chb-select-row" data-id="{{ $user->idUser }}"/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="table-cell-id">{{ $user->idUser }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td class="data-user-image text-center"><img src="{{ asset($user->avatarImagePath) }}" alt="User image"/></td>
            <td class="data-date">{{ date("d/m/Y h:i A", $user->createdAt) }}</td>
            <td class="data-date">{{ date("d/m/Y h:i A", $user->updatedAt) }}</td>
            <td class="text-center">{{ $user->isBanned ? "Yes" : "No" }}</td>
            <td class="data-user-role text-center">
            @if(count($user->roles))
                @foreach($user->roles as $role)
                    @if($role->name == 'admin')
                        <i class="fas fa-user-cog has-tooltip" data-role="{{ $role->text }}"><span class="tooltip">Administrator</span></i>
                    @elseif($role->name == 'jamMaker')
                        <i class="fas fa-user-tie has-tooltip" data-role="{{ $role->text }}"><span class="tooltip">Jam maker</span></i>
                    @else
                        <i class="fas fa-user-astronaut has-tooltip" data-role="{{ $role->text }}"><span class="tooltip">Game developer</span></i>
                    @endif
                @endforeach
            @else
                <i class="fas fa-user has-tooltip" title="User"><span class="tooltip tooltip-small">User</span></i>
            @endif
            </td>
            <td class="data-edit text-center"><a href="#" data-id="{{ $user->idUser }}"><i class="far fa-edit"></i></a></td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $user->idUser }}"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>