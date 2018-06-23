@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('commands')
    <a href="#" id="createNew" class="has-tooltip"><i class="fas fa-plus"></i><span class="tooltip">Create new</span></a>
    <a href="#" id="deleteSelected" class="has-tooltip"><i class="fas fa-trash-alt"></i><span class="tooltip">Delete selected</span></a>
@endsection

@section('content')
    @if(count($tableData))
        @include('admin.ajax.users')
    @else
        <p class="no-data-found">No data found.</p>
    @endif
@endsection

@section('dataForm')
<form action="" method="POST" id="dataForm" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" name="tbUsername" id="tbUsername" class="form-control" placeholder="Username">
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="tbEmail" id="tbEmail" placeholder="E-mail">
    </div>
    <div class="form-group">
        <input type="password" name="tbPassword" class="form-control" id="tbPassword" placeholder="Password">
    </div>
    <p>Upload avatar image:</p>
    <div class="form-group user-edit-file">
        <input type="file" accept="image/*" class="user-edit-upload-file-control" id="userUploadAvatar" name="fAvatarImage"/>
        <div class="drag-and-drop-overlay" id="drag-and-drop-overlay">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Click or Drag &amp; Drop Your File Here</p>
        </div>
        <img id="uploadedImage" />
        <p class="image-filename" id="image-filename">Filename.jpg</p>
    </div>
    <div class="form-group user-edit-roles">
        <div class="user-roles-checkboxes float-left">
            <p>Roles:</p>
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="userRole1" name="userRoles[]" value='1'> Admin
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="userRole2" name="userRoles[]" value='2'> Jam Maker
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="userRole3" name="userRoles[]" value='3'> Jam Developer
                </label>
            </div>
        </div>
        <div class="is-banned-form float-right">
            <p>Banned:</p>
            <label><input type="checkbox" id="chbIsBanned" name="chbIsBanned"/>Yes</label>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <input type="hidden" name="hiddenId" id="hiddenId"/>
    
    {{ csrf_field() }}
</form>
@endsection

@section('jsfiles')
<script>
    $(document).ready(function () {

        function changeUploadImage(val, src, innerHtml) {
            var img = document.getElementById('uploadedImage');
            var imgFilename = document.getElementById("image-filename");
            img.src = src;
            img.style.opacity = val;
            imgFilename.style.opacity = val;
            imgFilename.innerHTML = innerHtml;
            document.getElementById("drag-and-drop-overlay").style.opacity = val === 0 ? 1 : 0;
        }

        // clear form before insert or update
        function clearForm(title, operation, btn) {
            changeUploadImage(0, "", "");

            $("#form-title").html(title);
            $("#modal-confirm-yes").attr("data-operation", operation);
            $("#modal-confirm-yes").html(btn);

            $("#form-errors span").html("");
            $("#form-errors").hide();

            $("#tbPassword").val("");
            $("#tbUsername").val("");
            $("#tbEmail").val("");
            $("#userUploadAvatar").val("");
            $(".user-roles-checkboxes input[type='checkbox']").prop("checked", false);
            $("#chbIsBanned").prop("checked", false);
        }

        // drag and drop avatar
        document.getElementById("userUploadAvatar").addEventListener("change", function(){
            changeUploadImage(1, window.URL.createObjectURL(this.files[0]), this.files[0].name);
        });

        // create new
        $("#createNew").on("click", function (e) {
            e.preventDefault();

            clearForm("Create new user", "insert", "Create");

            $(".modal-box").css("display", "block");
            $(".modal-box").animate({
                opacity: 1
            }, 150);

            return false;
        });

        // get by id for update => fill form
        $("#content").on("click", ".main-table .data-edit a", function (e) {
            e.preventDefault();

            clearForm("Edit user", "update", "Save");

            var id = $(this).attr("data-id");
            var table = "{{ $tableName }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $("#hiddenId").val(id);

            $.ajax({
                url: "{{ asset('/admin/get-by-id') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: csrfToken,
                    id: id,
                    tableName: table,
                },
                success: function(data) {
                    var item = JSON.parse(data);

                    $(".modal-box").css("display", "block");
                    $(".modal-box").animate({
                        opacity: 1
                    }, 150);

                    $("#tbUsername").val(item.username);
                    $("#tbEmail").val(item.email);
                    
                    for(var i = 0; i < item.roles.length; i++){
                        $("#userRole" + item.roles[i].idRole).prop("checked", true);
                    }

                    $("#chbIsBanned").prop("checked", item.isBanned === 1 ? true : false);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })

            return false;
        });

        // update or insert

        var url = "";

        $("#modal-confirm-yes").on("click", function (e) {
            e.preventDefault();

            var op = $(this).attr("data-operation");

            if(op == "update") {
                url = "{{ asset('/admin/update/users') }}";
            }
            else {
                url = "{{ asset('/admin/insert/users') }}";
            }
            
            $('#dataForm').submit();
        });

        $('#dataForm').submit(function (e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);
            formData.append('file', $('#userUploadAvatar')[0].files[0]);

            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                data: formData,
                beforeSend: function(data) {
                    $("#loading-overlay").css("display", "block");
                },
                success: function (data) {
                    $("#content").html(data);

                    $(".modal-box").animate({
                        opacity: 0
                    }, 150, function () {
                        $(".modal-box").css("display", "none");
                    });
                },
                complete: function() {
                    $("#loading-overlay").css("display", "none");
                },
                error: function (xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $("#form-errors span").html(err.message);
                    $("#form-errors").show();
                },
            });
        });
    });
</script>
@endsection