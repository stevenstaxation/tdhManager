<!-- ADD NEW CUSTOMER -->
<div class="modal" id="modalAddNewCustomer" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add new customer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='addNewCustomer' class='addNewCustomer form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='newCustomerName' style='width: 40%; padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Business name..." name='newCustomerName' id='newCustomerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Address line 1..." name='customerAddress1' id='customerAddress1'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Address line 2..." name='customerAddress2' id='customerAddress2'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Town/City..." name='customerAddress3' id='customerAddress3'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="County..." name='customerAddress4' id='customerAddress4'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Post code..." name='customerAddress5' id='customerAddress5'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerPhone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Telephone..." name='customerPhone' id='customerPhone' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerEmail' style='padding-top:8px;'><strong>Email</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Email address..." name='customerEmail' id='customerEmail'>
                                </div>
                            </div>
                        </div>
                        <!-- <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerRegNo' style='padding-top:8px;'><strong>Registered No.</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Company Reg No..." name='customerRegNo' id='customerRegNo' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerVATNo' style='padding-top:8px;'><strong>VAT Reg No.</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="VAT Registration No..." name='customerVATNo' id='customerVATNo' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div> -->
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='getInsurer' style='padding-top:8px;'><strong>Insurer</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select style='font-size: 80%' id='getInsurer' name='getInsurer' class='custom-select getInsurer'>
                                        <?php
                                        $sql = "SELECT * FROM tblInsurer ORDER BY insurerName ASC";
                                        $result = mysqli_query($link, $sql);

                                        while ($insurerRow = mysqli_fetch_array($result)) {
                                            echo "<option value = " . $insurerRow['ID'] . ">" . $insurerRow['insurerName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='getBroker' style='padding-top:8px;'><strong>Broker</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select style='font-size: 80%' id='getBroker' name='getBroker' class='custom-select getBroker'>
                                        <?php
                                        $sql = "SELECT * FROM tblBroker ORDER BY brokerName ASC";
                                        $result = mysqli_query($link, $sql);

                                        while ($brokerRow = mysqli_fetch_array($result)) {
                                            echo "<option value = " . $brokerRow['ID'] . ">" . $brokerRow['brokerName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='customerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='newCustomerIDNumber' style='display: none'></div>
                <button type="button" id='addNewCustomerButton' onclick='addCustomer()' class="btn btn-success">Add Customer</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>