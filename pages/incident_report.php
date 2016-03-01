<?php $footerButtons = ['Save', 'Refresh', 'Close', 'Print']; ?>
<script>
    window.actions['incident_report'] = []

    window.actions['incident_report']['Save'] = function(){
        formData = $('#form_incident_report').serializeArray();

    };
    window.actions['incident_report']['Refresh'] = function() {
        $('#form_incident_report').load('pages/incident_report.php #form_incident_report>*');
    };
    window.actions['incident_report']['Close'] = function(){

    };
    window.actions['incident_report']['Print'] = function(){

    };
</script>

<form id="form_incident_report">
    <table style="height:485px; width:100%;">
        <tr>
            <td style="padding:10px; width:70%;">
                <div style="border:1px solid #476971; border-radius: 6px; min-height:485px; width:100%; padding-top:5px;">
                    <?php include('incidentBasic.form.php'); ?>
                    <div id="formExtras">

                    </div>
                    <?php include('incidentContact.form.php'); ?>
                    <?php include('incidentPolice.form.php'); ?>
                </div>
            </td>
            <td style="padding:10px; width:30%;">
                <div style="border:1px solid #476971; border-radius: 6px; min-height:485px; width:100%; padding-top:5px;">
                    <?php include('incidentComments.form.php'); ?>
                </div>
            </td>
        </tr>
    </table>
</form>


<?php include('footer.php'); ?>