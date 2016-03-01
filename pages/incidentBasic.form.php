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
            <select>
                <option>SPEEDY'S OFFICE</option>
            </select>
        </td>
        <td>
            <b>Employee:</b>
        </td>
        <td>
            <select>
                <option>Matt Knowlton</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <b>Date / Time:</b>
        </td>
        <td>
            <input >
        </td>
        <td>
            <b>Incident Type:</b>
        </td>
        <td>
            <select>
                <option>NONE</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <b>Status:</b>
        </td>
        <td>
            <select>
                <option>Open</option>
            </select>
        </td>
        <td>
            Reported On:
        </td>
        <td>
            <select>
                <option>Store Clerk</option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            No contact acquired:&nbsp;
            <input type="checkbox" />
        </td>
        <td></td>
        <td>
            <input type="checkbox" />
            High Priority
        </td>
    </tr>
    <tr>
        <td colspan="4">
            CLOSED BY:
        </td>
    </tr>
</table>