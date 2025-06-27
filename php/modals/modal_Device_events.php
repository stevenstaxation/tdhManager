<!-- EDIT DEVICE NOTES DIALOG -->
<div class="modal" id="modalDeviceEvents" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 id='events31Modal' class="modal-title">Events in last 31 days</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <!-- <form method='POST' id='deviceEventParameters' class='deviceEventParameters form-block'>
                    <div class='form-group'> -->
                        <!-- <div class='row' style='margin-bottom: 3px;'>
                            <div class='col-lg-1 col-md-3'>
                                <label class='control-label' for='maxDevices' style='padding-top:8px;'><strong>No. Events</strong></label>
                            </div>
                            <div class='col-lg-2 col-md-3'>
                                <div class='input-group'>
                                    <input type='number' id='maxDevices' name='maxDevices' min='1' class='form-control maxDevices' value='10'>
                                </div>
                            </div>
                        </div> -->
                     
                        <!-- <div class='row' style='margin-bottom: 3px;'>
                            <div class='col-lg-1 col-md-3'>
                                <label class='control-label' for='eventDateTo' style='padding-top:8px;'><strong>To</strong></label>
                            </div>
                            <div class='col-lg-2 col-md-3'>
                                <div class='input-group'>     
                                    <input type='date' id='eventDateTo' class='form-control dateTo'>
                                </div>
                            </div>
                        </div>   -->
                    <!-- </div>
                </form> -->
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenDeviceEventsID' style='display: none'></div>
                <div id='editDeviceEventsID' style='display: none'></div>
                <div id='editDeviceEventsCustomerID' style='display: none'></div>
                <table class='table table-sm' id='eventListTable'>
                    <thead>
                        <tr>
                            <th class='text-center'>Date</th>
                            <th class='text-center'>Time</th>
                            <th class='text-center'>Event</th>
                            <th class='text-center'>Location</th>
                            <th class='text-center'>Severity</th>
                        </tr>
                        <tbody id='eventListBody'></tbody>
                    </thead>

                </table>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>