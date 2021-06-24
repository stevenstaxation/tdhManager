/*eslint-env browser*/

var fileobj;

function upload_file(e) {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    $('#status').html("Uploading...");
    ajax_file_upload(fileobj);
}
 
function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function () {
        fileobj = document.getElementById('selectfile').files[0];
        ajax_file_upload(fileobj);
    };
}
 
function ajax_file_upload(file_obj) {
    if (file_obj != undefined) {
        var form_data = new FormData();
        form_data.append('file', file_obj);
        $.ajax({
            type: 'POST',
            url: 'upload.php',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                $('#status').html(response);
                parseFile();
                $('#selectfile').val('');
            }
        });
    }
}

function parseFile() {
    $.ajax({
        type: 'POST',
        url: 'parseFile.php',
        contentType: false,
        processData: false,
        data: '',
        success: function (response) {
            $('#contentArea').html(response);
        }
    });
}

