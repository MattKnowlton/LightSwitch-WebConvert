<style>
    #incidentBasic {
        width:100%;
    }

    #incidentBasic td {
        padding:2px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 13px;
    }

    #incidentBasic td input:not([type="radio"]):not([type="checkbox"]), #incidentBasic td select {
        width:100%;
    }
</style>
<table id="incidentBasic">
    <tr>
        <td>
            <b>Location:</b>
        </td>
        <td>
            <select name="location">
                <option>SPEEDY'S OFFICE</option>
            </select>
        </td>
        <td>
            <b>Employee:</b>
        </td>
        <td>
            <select name="employee">
                <option>Matt Knowlton</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <b>Date / Time:</b>
        </td>
        <td>
            <input name="incident_date">
        </td>
        <td>
            <b>Incident Type:</b>
        </td>
        <td>
            <select name="incident_type">
                <option>NONE</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <b>Status:</b>
        </td>
        <td>
            <select name="status">
                <option>Open</option>
            </select>
        </td>
        <td>
            Reported On:
        </td>
        <td>
            <select name="reported_on">
                <option>Store Clerk</option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            No contact acquired:&nbsp
            <input type="hidden" name="contact_acquired" value="0" />
            <input type="checkbox" name="contact_acquired" value="1" />
        </td>
        <td></td>
        <td>
            <input type="hidden" name="high_priority" value="0" />
            <input type="checkbox" name="high_priority" value="1" />
            High Priority
        </td>
    </tr>
    <tr>
        <td colspan="4">
            CLOSED BY:
        </td>
    </tr>
</table>