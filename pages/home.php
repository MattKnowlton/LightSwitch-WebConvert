
<form >
    <div style="background-color: white; border-radius: 8px; border: 1px solid #84B0DA; padding:10px; min-height:485px;">
        <table style="width:100%;">
            <tr>
                <td style="width:180px;">
                    <a href="coming_soon">
                        <button class="largeBttn blueBttn">Time Clock</button>
                    </a>
                    <br/><br/>
                    <a href="coming_soon">
                        <button class="largeBttn yellowBttn">Check My Hours</button>
                    </a>
                    <br/><br/>
                    <a href="incident_report">
                        <button class="largeBttn orangeBttn">Create Incident Report</button>
                    </a>
                    <br/><br/>
                    <a href="coming_soon">
                        <button class="largeBttn purpleBttn">Create Store Inspection</button>
                    </a>
                    <br/><br/>
                    <a href="coming_soon">
                        <button class="largeBttn greyBttn">Create New Message</button>
                    </a>
                    <br/><br/>
                    <a href="coming_soon">
                        <button class="largeBttn greenBttn">Read Messages</button>
                    </a>
                    <br/>
                </td>
                <td style="vertical-align: top; text-align:left;">
                    <table style="width:100%;">
                        <tr>
                            <td style="width:192px;">
                                <img src="images/logoStore.png" style="width:192px;"/>
                            </td>
                            <td style="padding-left:10px;">
                                <table>
                                    <tr>
                                        <td>Last Name, First Name:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Full_Name" disabled/></td>
                                    </tr>
                                    <tr>
                                        <td>Main Address:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Address_1" /></td>
                                    </tr>
                                    <tr>
                                        <td>Zip:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Zip_Code" /></td>
                                    </tr>
                                    <tr>
                                        <td>Hire Date:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Hire_Date" disabled/></td>
                                    </tr>
                                    <tr>
                                        <td>Main Phone:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Phone_1" /></td>
                                    </tr>
                                    <tr>
                                        <td>Main Email:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Email_1" /></td>
                                    </tr>
                                    <tr>
                                        <td>Company:</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Company" disabled/></td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td>&nbsp;&nbsp;&nbsp;<input name="Location" disabled/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                           <td colspan="2">
                               <br/><br/>
                               <table style="border:1px solid #717171; border-radius:8px; width:573px;" id="msgList">
                                   <tr>
                                       <th style="padding:6px;">Latest Messages and Announcements</th>
                                   </tr>
                                   <tr>
                                       <th></th>
                                   </tr>
                                   <tr>
                                       <td style="height:200px; color:#717171; vertical-align: top; padding:6px;">
                                           Feature not yet implemented... Coming Soon
                                       </td>
                                   </tr>
                               </table>
                           </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <?php $footerButtons = ['Refresh', 'Save']; ?>
    <?php include('footer.php'); ?>
</form>