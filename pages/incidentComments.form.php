<style>
    #incidentCommments{
        padding:2px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 13px;
    }
    #incidentCommments textarea{
        width: 100%;
        height: 75px;
    }
</style>

<div id="incidentCommments">
    <b>Description:</b>
    <br/>
    <textarea name="description"></textarea>

    <br/><br/>

    <b>Employee Action Taken:</b>
    <br/>
    <textarea name="employee_action"></textarea>

    <br/><br/>

    <b>Office Action Taken:</b>
    <br/>
    <textarea name="office_action"></textarea>

    <br/><br/>

    <b>Incident Photo:</b><input type="file" accept="image/*" capture="camera"/>
    <br/>
    <div style="width:170px;height: 100px; border:1px solid black;"></div>
</div>