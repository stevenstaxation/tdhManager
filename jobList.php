<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sqlFILTER = ($_POST['SQLFilter']);

$returnString = "
<div id='hiddenCustomerID' style='display: none'></div>
<div id='jobFilter' style='display: none'> " . $sqlFILTER . "</div>

<div id='deviceLongList' class='listHeader'>
  <h4><strong>Job Requests</strong></h4>";

  if ($_SESSION['isInstaller']== '0' && $_SESSION['isEngineer']== '0') {
   $returnString .="
    <btn class='btn btn-success' id='addJobRequest' onclick='addJobRequest(\"job\")' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/></svg> Add New Job </btn>";
  }
    
  if (($sqlFILTER & 1)==1) {
    $returnString .="
    <btn class='btn btn-primary' id='togglePendingJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Show Pending Jobs</btn>";
  } else {
    $returnString .="
    <btn class='btn btn-outline-primary' id='togglePendingJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Hide Pending Jobs</btn>";    
  }
  if (($sqlFILTER & 4)==4) {
    $returnString .="
    <btn class='btn btn-primary' id='toggleDatePassedJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Show Date Passed Jobs</btn>";
  } else {
    $returnString .="
    <btn class='btn btn-outline-primary' id='toggleDatePassedJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Hide Date Passed Jobs</btn>";      
  }
  if (($sqlFILTER & 16)==16) {
    $returnString .="
    <btn class='btn btn-primary' id='toggleCompletedJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Show Completed Jobs</btn>";
  } else {
    $returnString .="
    <btn class='btn btn-outline-primary' id='toggleCompletedJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Hide Completed Jobs</btn>";    
  }
  if (($sqlFILTER & 32)==32) {
    $returnString .="
    <btn class='btn btn-primary' id='toggleCancelledJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Show Cancelled Jobs</btn>";
  } else {
    $returnString .="
    <btn class='btn btn-outline-primary' id='toggleCancelledJobs' style='margin: 10px 10px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg>Hide Cancelled Jobs</btn>";    
  }


  if ($_SESSION['isInstaller']== '0' && $_SESSION['isEngineer']== '0') {
    $returnString .="
     <btn class='btn btn-danger' style='margin: 10px 10px;' id='PDFJobsList' data-toggle='modal' data-target='#modalGetJobReportParameters' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-pdf-fill' viewBox='0 0 16 16'><path d='M5.523 10.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.035 21.035 0 0 0 .5-1.05 11.96 11.96 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.888 3.888 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 4.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z'/><path fill-rule='evenodd' d='M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm.165 11.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.64 11.64 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.707 19.707 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z'/></svg>Export List as PDF</btn>";
   }

  $returnString .= "
    <btn class='btn btn-warning' style='margin: 10px 10px;' id='showJobMap' onclick='showJobMap()'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-geo-alt-fill' viewBox='0 0 16 16'><path d='M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z'/></svg>Job Map</btn>";

  $returnString .="


  <div class='container-fluid'>
  <div id='jobListFilter'>
    <form id='deviceForm' class='filterBox' style='display: none'><div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%'>
      <div class='input-group'>
        <input type='text' style='padding: 5px;' id='byOther' value=''/>
      </div>
    </form>
  </div>
</div>
";

  $sql = 'SELECT tblJobs.ID, tblJobs.ownerID,  tblJobs.date, tblJobs.dateAdded, tblJobs.PriorityIsUrgent, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status, tblDeviceDescription.description as CameraType 
  
  FROM tblJobs INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID = tblJobs.cameratypeID';

$hidePending = ($sqlFILTER & 1);
$hideBooked = ($sqlFILTER & 2);
$hideDatePassed = ($sqlFILTER & 4);
$hideAwaitApproval = ($sqlFILTER & 8);
$hideCompleted = ($sqlFILTER & 16);
$hideCancelled = ($sqlFILTER & 32);


if (isset($sqlFILTER) && $sqlFILTER!=-1) {
  $sql .= " WHERE (tblJobs.status <> '$hidePending' AND tblJobs.status <> '$hideBooked' AND tblJobs.status <> '$hideDatePassed' AND tblJobs.status <> '$hideAwaitApproval' AND tblJobs.status <> '$hideCompleted' AND tblJobs.status <> '$hideCancelled')";
} 

  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) !=0) {
      
      $returnString .= "<div id = 'deviceSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
      <table id='jobListTable' class='table cell-border compact'>
      <thead>
        <tr>
          <th class='text-center align-middle'>Date Added</th>
          <th class='text-left align-middle'>Customer</th>
          <th class='text-center align-middle'>Job Type</th>
          <th class='align-middle'>Camera Type</th>
          <th class='text-center align-middle'>Registration(s)</th>
          <th class='text-center align-middle'>Date/Time Booked</th> 
          <th class='text-center align-middle'>Priority</th>
          <th class='text-center align-middle'>Status</th>
          <th class='align-middle'>Notes</th>  
          <th class='text-center align-middle'>Edit</th>
        
        </tr>
      </thead>
    
      <tbody>";
  while ($row= mysqli_fetch_array($result)) {
    
    switch ($row['status']) {
      case 1:
        $rowBackground = "Pending";
        $rowColour = '#CCCC55';
      break;
      case 2:
        $bookedDate = strtotime($row['date']);
        $today = strtotime(date('Y-m-d H:i:s'));
        $diffInSeconds = $today - $bookedDate;
        
        if ($diffInSeconds<0) {
          $rowBackground = "Booked";
          $rowColour = '#888888';
        } else {
          $rowBackground = "Booked - Date Passed";
          $rowColour = '#b60000';
          $sql = "UPDATE tblJobs SET status='4'";
          $sql .= " WHERE ID = '" . $row['ID'] . "'";
          $update = mysqli_query($link, $sql);
          break;  
        }
        break;
      case 4:
        $rowBackground = "Booked - Date Passed";
        $rowColour = '#b60000';
        break;
      case 8:
        $rowBackground = "Awaiting Approval";
        $rowColour = '#1e90ff';
        break;
      case 16:
        $rowBackground = "Complete";
        $rowColour = '#55CC55';
        break; 
      case 32:
        $rowBackground = "Cancelled";
        $rowColour = '#FF00FF';
        break; 
      default:
        $rowBackground = "UNKNOWN";
        $rowColour = '#B60000';
    }

    if ($row['PriorityIsUrgent']==2) {
      $jobPriority = "Urgent";
    } else {
      $jobPriority = "Standard";
    }

    $returnString .= "<tr class = ''>
    <td class='text-center align-middle' style='padding:0 3px;' data-order=" . date('Y-m-d', strtotime($row['dateAdded']))  . ">" . date('d/m/Y', strtotime($row['dateAdded'])) . "</td> 
    <td class='align-middle' style='padding:0 3px;'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['CameraType'] ."</td>
    
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>";

      if (date('d/m/Y', strtotime($row['date']))=='01/01/1970') {
        $returnString .="<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
      } else {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) .">" . date('d/m/Y (D) H:i', strtotime($row['date'])) . "</td>";
      }

      $returnString .="    
    <td class='text-center align-middle' style='padding:0 3px;'>" . $jobPriority. "</td>
    <td class='text-center align-middle' style='font-size: 85%; color: " . $rowColour . "'><b>" . $rowBackground . "</b></td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['notes']. "</td>";
    
    // if ($row['status']==1) {
      $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."editj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
      <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
      </svg></btn></td>";
//     } else {
//       $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."viewj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
//   <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
// </svg></btn></td>";
// }

// if ($row['notes'] && $row['notes']!="") {
//   $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showJobNotes(\"" . $row[0]."job\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
// } else {
//   $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showJobNotes(\"" . $row[0]."job\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
// }
  $returnString .="
    </tr>";
  } 




  $returnString .="</tbody>
  <tfoot>
  <tr>
    <th class='text-center align-middle'>Date Added</th>
    <th class='text-left align-middle'>Customer</th>
    <th class='text-center align-middle'>Job Type</th>
    <th class='align-middle'>Camera Type</th>
    <th class='text-center align-middle'>Registration</th>
    <th class='text-center align-middle'>Date/Time Booked</th> 
    <th class='text-center align-middle'>Priority</th>
    <th class='text-center align-middle'>Status</th>
    <th class='align-middle'>Notes</th>  
    <th class='text-center align-middle'>Edit</th>
  
  </tr>
</tfoot>

  </table>

</div>
<div id='hiddenJobID' style='display: none'></div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

    $(document).ready(function() {
      $('#jobListTable').DataTable({
        columnDefs: [
          {orderable: false, targets: [9] },
          {searchable: false, targets: [9] }
        ],
        colReorder: true,
        order: [[5, 'asc']],
        processing: true,
        paging: false,
        responsive: true,
        stateSave: true,
        dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
        rowCallback: function(row, data, dataIndex) {
          if ($('body').hasClass('dark')) {
            $(row).css('background-color', 'rgba(68,68,68,1)')
                  .css('color', 'white')
                  .css('border-color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)')
                  .css('border-color', 'rgba(68,68,68,1)');
        }
      },
      initComplete: function () {
        count = 0;
        this.api().columns([0,1,2,3,4,5,6,7,8]).every( function () {
            var title = this.header();
            title = $(title).html().replace(/[\W]/g, '-');
            var column = this;
            var lineBreak = $('<br>')
                .appendTo( $(column.header()));

            var select = $('<select id=\"' + title + '\" style=\"width:100%\" class=\"select2\" ></select>')
                .appendTo( $(column.header()))
                .on( 'change', function () {
                  var data = $.map( $(this).select2('data'), function( value, key ) {
                    return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                             });       
                  if (data.length === 0) {
                    data = [\"\"];
                  }
                  var val = data.join('|');
                  column
                        .search( val ? val : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value=\"'+d+'\">'+d+'</option>' );
            } );
          
          //use column title as selector and placeholder
          $('#' + title).select2({
            multiple: true,
            closeOnSelect: false,
            placeholder: \"\"
          });
          
          //initially clear select otherwise first option is selected
          $('.select2').val(null).trigger('change');
        } );
    },
    });
  });
    </script>
";
  } else {
    $returnString .= "<p class='text-center'>No results found</p>";
  }


echo $returnString;

?>
