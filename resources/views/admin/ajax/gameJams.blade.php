<table class="main-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Cover</th>
            <th>Dates</th>
            <th>Content</th>
            <th>Lock Submissions</th>
            <th>Others Can Vote</th>
            <th>Created By</th>
            <th>Views</th>
            <th class="text-center">Block</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $item)
        <tr data-id="{{ $item->idGameJam }}">
            <td class="table-cell-id">{{ $item->idGameJam }}</td>
            <td>{{ $item->title }}</td>
            <td class="text-center" title="{{ $item->description }}">{{ strlen($item->description) > 13 ? substr($item->description, 0, 10) . "..." : $item->description }}</td>
            <td><img class="data-cover" src="{{ asset($item->cover) }}"/></td>
            <td><p>{{ date("d/m/Y h:i A", $item->startDate) }}</p>
            <p>{{ date("d/m/Y h:i A", $item->endDate) }}</p>
            <p>{{ date("d/m/Y h:i A", $item->votingEndDate) }}</p>
            </td>
            <td class="text-center" title="{{ $item->content }}">{{ strlen($item->content) > 13 ? substr($item->content, 0, 10) . "..." : $item->content }}</td>
            <td class="text-center">{{ $item->lockSubmissionAfterSubmitting === 1 ? "Yes" : "No"}}</td>
            <td class="text-center">{{ $item->othersCanVote === 1 ? "Yes" : "No" }}</td>
            <td class="text-center"><a href="{{ asset('/user/' . $item->username) }}">{{ $item->username }}</a></td>
            <td class="text-center">{{ $item->numOfViews }}</td>
            <td>
                <label class="checkbox-cell">
                    <input type="checkbox" class="checkbox-block" autocomplete="off" data-id="{{ $item->idGameJam }}" {{ $item->isBlocked == 1 ? "checked" : "" }}/>
                    <span class="checkmark"></span>
                </label>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>