<style>
    legend {
        margin-bottom:0px;
        width:inherit;
        color: #333;
        border: 0;
        border-bottom: 1px solid #e5e5e5;
        margin-left: 10px;
        padding: 3px;
    }

    #formPolice input, #formPolice select{
        width: 100%;
    }
    #formPolice td{
        padding:2px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 13px;
    }

    #formPolice{
        width: 100%;
    }

    #formPolice tr td:nth-child(1){
        width: 165px;
    }
    #formPolice tr td:nth-child(3) {
        width: 115px;
    }
</style>

<fieldset style="margin:8px; border:1px solid #476971; border-radius: 6px; ">
    <legend style="font-size:14px; font-weight:bold;">
        Police Information
    </legend>

    <table id="formPolice">
        <tr>
            <td>
                Were the police notifed?
            </td>
            <td>
                <select name="police_notified">
                    <option value="0">No</option>
                    <option value="1">No</option>
                </select>
            </td>
            <td>
                Case Number:
            </td>
            <td>
                <input name="case_number"/>
            </td>
        </tr>
        <tr>
            <td>
                Officer Name:
            </td>
            <td>
                <input name="officer_name"/>
            </td>
            <td>
                Badge Number:
            </td>
            <td>
                <input name="badge_number"/>
            </td>
        </tr>

    </table>

    <br/>
</fieldset>