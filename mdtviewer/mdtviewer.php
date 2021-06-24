<?php
session_start();
?>
<!DOCTYPE HTML>

<HTML>
<HEAD>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>    
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script src='https://polyfill.io/v3/polyfill.min.js?features=default'></script>
    
    <link rel="stylesheet" href="styles/index.css">
    
    <script src='scripts/upload.js'></script>


    <title>MDT Viewer</title>

    
</HEAD>
    
<BODY>   
    <div class='pageHeader container' style='white-space: nowrap'>
        <img src ='imageAssets/logo.png' align='left'>
     </div>
    

    <div class='container'>
        <div id = 'toggleUpload' class='btn btn-link' style='display: none'>show upload panel</div>
        <div id="drop_file_zone" style='display: visible' ondrop="upload_file(event)" ondragover="return false">
            <img src="imageAssets/draganddrop.png" style="display: block; margin-left: auto; margin-right: auto; margin-top: 10px; width: 180px;">
            <div id="drag_upload_file">
                <p style='margin-top: 5px;'>Drop MDT file here</p>
                <p>or</p>
                <p><input type="button" value="Select File" onclick="file_explorer();"></p>
                <input type="file" id="selectfile">
            </div>
        </div>
    </div>
    

    <div id = "status" class='container' style='text-align: center;'></div>
    <div id = 'contentArea' class='container'></div>
    
    
    
 
    </BODY>
    
    <script>
    $('#toggleUpload').on('click', function() {
        var btnText = $('#toggleUpload').text();
      
        if (btnText == 'show upload panel') {
              $('#drop_file_zone').css('display', '');
                $('#toggleUpload').text('hide upload panel');  
                $('#status').html('');
        } else {
                $('#drop_file_zone').css('display', 'none');
                $('#toggleUpload').text('show upload panel');    
        }
    });
        
    function collapseUploadPanel() {
        x = document.getElementById('drop_file_zone');
        y = document.getElementById('toggleUpload');
        $('#status').html('');
        
        x.style.display = 'none';
        y.style.display = 'block';
    }    
        
    </script>
    

    
</HTML>


 