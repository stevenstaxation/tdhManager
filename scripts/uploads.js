function uploadFileToServer(file_obj, editOrAdd) {
    if (file_obj !=undefined) {
        var form_data = new FormData();
        form_data.append('file', file_obj);
        $.ajax ({
            type: "POST",
            url: "uploads.php",
            contentType: false,
            processData: false,
            data: form_data,
            success: function(response) {
                // add filename to table/
                if (response.includes('success')) {
                    var fileName = {};
                    fileName = response.replace('success', '');
                    var data = '';
                    if (editOrAdd== 'Add') {
                        // data = '<tr><td>' + fileName + '</td></tr>'
                        // $('#footageFileTableBody').append(data);
                        data = '<tr><td>' + fileName + "</td><td><btn class= 'btn btn-success btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td></td>";
                        data = data + "<td class='text-center align-middle'><btn class= 'btn btn-danger btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td></tr>'";
                        $('#footageFileTableBody').append(data);
                    } else if (editOrAdd == 'Edit') {
                        data = '<tr><td>' + fileName + "</td><td><btn class= 'btn btn-success btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td></td>";
                        data = data + "<td class='text-center align-middle'><btn class= 'btn btn-danger btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td></tr>'";
                        $('#footageEditFileTableBody').append(data);
                    }
                } else {
                    window.alert(response);
                }
            },
            error: function() {

            }
        });
    }
}

function fileExplorer(editOrAdd) {
    if (editOrAdd == 'Add') {
        document.getElementById('footageFileName').onchange = function() {
            fileObj = document.getElementById('footageFileName').files[0];
            uploadFileToServer(fileObj, editOrAdd);
        }
    } else if (editOrAdd == 'Edit') {
        document.getElementById('footageEditFileName').onchange = function() {
            fileObj = document.getElementById('footageEditFileName').files[0];
            uploadFileToServer(fileObj, editOrAdd);
        }
    }
}

$(document).ready(function() {
    $(document).on('change', '#file', function() {
        var fileProperty = document.getElementById('file').files[0];
        var issueImageFileName = fileProperty.name;
        var issueImageExtension = issueImageFileName.split('.').pop().toLowerCase();
        // is it an allowed extenstion?
        if(jQuery.inArray(issueImageExtension, ['png', 'jpg', 'jpeg', 'gif']) == -1) {
            swal ('Invalid Image File','Only PNG, JPEG and GIF allowed', 'error');
            return
        }
        var issueImageSize = fileProperty.size;
        if (issueImageSize > 2000000) {
            swal ('File is too large to upload','Maximum file size is 2Mb', 'error');
            return
        } else {
            var form_data = new FormData();
            form_data.append("file", fileProperty);
            $.ajax({
                url: "upload.php",
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#uploaded_image').html("<label class='text-success'>Screenshot Uploading...</label>")
                },
                success: function(data) {
                    $('#uploaded_image').html(data);
                }
            })
        }

    });
})

