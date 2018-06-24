<table class="main-table poll-table">
    <thead>
        <tr>
            <th>
                
            </th>
            <th>ID</th>
            <th>Text</th>
            <th class="text-center">Active</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tableData as $key => $item)
        <tr data-id="{{ $item->idPollQuestion }}" class="table-poll-question-row @if($key % 2 === 1) table-odd-row @endif">
            <td>
                <span class="expand-poll-question"></span>
            </td>
            <td class="table-cell-id">{{ $item->idPollQuestion }}</td>
            <td>{{ $item->text }}</td>
            <td class="table-cell-70 text-center">
                <label class="checkbox-cell">
                    <input type="radio" autocomplete="off" name="poll-question-id" class="select-active-question" data-id="{{ $item->idPollQuestion }}" @if($item->active === 1) checked @endif/>
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="data-edit text-center"><a href="#" data-id="{{ $item->idPollQuestion }}" data-poll-type="question"><i class="far fa-edit"></i></a></td>
            <td class="data-delete text-center"><a href="#" data-id="{{ $item->idPollQuestion }}" data-poll-type="question"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
        <tr class="table-poll-answers">
            <td colspan="6">
                <div class="inner-table-wrap" data-poll-question-id="{{ $item->idPollQuestion }}">
                    <table class="inner-table">
                        <tbody>
                        @foreach($item->answers as $key => $item)
                            <tr>
                                <td>#{{ $key + 1 }}</td>
                                <td>{{ $item->text }}</td>
                                <td class="data-edit text-center"><a href="#" data-id="{{ $item->idPollAnswer }}" data-poll-type="answer"><i class="far fa-edit"></i></a></td>
                                <td class="data-delete text-center"><a href="#" data-id="{{ $item->idPollAnswer }}" data-id-question="{{ $item->idPollQuestion }}" data-poll-type="answer"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        @endforeach
                        <tr class="add-new-answer">
                            <td class="add-new-answer-cell" colspan="4">
                                <form action="" method="POST" id="dataAnswerForm">
                                    <div class="form-group">
                                        <input type="text" name="text" id="text" class="form-control" placeholder="Answer">
                                    </div>
                                    <input type="hidden" name="idPollQuestion" value="{{ $item->idPollQuestion }}"/>
                                    {{ csrf_field() }}
                                </form>
                                <a href="#" class="add-new-answer-btn" id="createNewAnswer"><i class="fas fa-plus"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>