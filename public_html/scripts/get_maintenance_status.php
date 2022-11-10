<?php
    function getMaintenanceStatus($site_settings) {
        if ($site_settings[11]["value_info"] == "false") return false;
        else return true;
    }
?>