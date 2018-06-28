<table class="main-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created by</th>
            <th>Game Jam</th>
            <th>Cover</th>
            <th>Description</th>
            <th>Dates</th>
            <th>Views</th>
            <th>Downloads</th>
            <th>Rating</th>
            <th>Is Winner</th>
            <th class="text-center">Block</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idGameSubmission }}">
            <td class="table-cell-id">{{ $item->idGameSubmission }}</td>
            <td>{{ $item->title }}</td>
            <td class="text-center"><a href="{{ asset('/user/' . $item->username) }}">{{ $item->username }}</a></td>
            <td class="text-center"><a href="{{ asset('/game-jams/' . $item->idGameJam) }}">{{ $item->gameJam }}</a></td>
            <td><img class="data-cover" src="{{ asset($item->cover) }}"/></td>
            <td title="{{ $item->description }}">{{ strlen($item->description) > 13 ? substr($item->description, 0, 10) . "..." : $item->description }}</td>
            <td>
                <p>{{ date("d/m/Y h:i A", $item->createdAt) }}</p>
                <p>{{ date("d/m/Y h:i A", $item->editedAt) }}</p>
            </td>
            <td class="text-center">{{ $item->numOfViews }}</td>
            <td class="text-center">{{ $item->numOfDownloads }}</td>
            <td class="text-center">{{ round($item->rating, 1) }}</td>
            <td class="text-center">{{ $item->isWinner === 1 ? "Yes" : "No" }}</td>
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="checkbox-block" autocomplete="off" data-id="{{ $item->idGameSubmission }}" {{ $item->isBlocked == 1 ? "checked" : "" }}/>
                    <span class="checkmark"></span>
                </label>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>