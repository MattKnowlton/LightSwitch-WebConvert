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

    #formContact input{
        width: 100%;
    }
    #formContact td{
        padding:2px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 13px;
    }

    #formContact{
        width: 100%;
    }

    #formContact tr td:nth-child(1), #formContact tr td:nth-child(3){
        width: 105px;
    }
</style>

<fieldset style="margin:8px; border:1px solid #476971; border-radius: 6px; ">
    <legend style="font-size:14px; font-weight:bold;">
        Contact Information
    </legend>

    <table id="formContact">
        <tr>
            <td>
                Contact Type:
            </td>
            <td colspan="3">
                <select name="contact[contact_type]">
                    <option>Witness</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                First Name:
            </td>
            <td>
                <input name="contact[first_name]">
            </td>
            <td>
                Last Name:
            </td>
            <td>
                <input name="contact[last_name]">
            </td>
        </tr>
        <tr>
            <td>
                Phone 1:
            </td>
            <td>
                <input class="phoneNum" name="contact[phone_1]">
            </td>
            <td>
                Phone 2:
            </td>
            <td>
                <input class="phoneNum" name="contact[phone_2]">
            </td>
        </tr>
        <tr>
            <td>
                Address 1:
            </td>
            <td colspan="3">
                <input name="contact[address_1]">
            </td>
        </tr>
        <tr>
            <td>
                Address 2:
            </td>
            <td colspan="3">
                <input name="contact[address_2]">
            </td>
        </tr>
        <tr>
            <td>
                Zip Code:
            </td>
            <td>
                <input name="contact[zip_code]">
            </td>
            <td>
                Email Address:
            </td>
            <td>
                <input class="emailAddr" name="contact[email]">
            </td>
        </tr>
    </table>
</fieldset>