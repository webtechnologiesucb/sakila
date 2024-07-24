<?php

namespace PHPMaker2024\Sakila;

// Dashboard Page object
$DashboardAll = $Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { DashboardAll: currentTable } });
var currentPageID = ew.PAGE_ID = "dashboard";
var currentForm;
var fDashboardAllsrch;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fDashboardAllsrch")
        .setPageId("dashboard")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<!-- Content Container -->
<div id="ew-report" class="ew-report">
<div class="btn-toolbar ew-toolbar">
<?php
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<!-- Dashboard Container -->
<div id="ew-dashboard" class="ew-dashboard">
<div class="row">
<div class="<?= $DashboardAll->ItemClassNames[0] ?>" style=' min-width: 450px; min-height: 420px;'>
<div id="Item1" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("sales_by_film_category", "SalesByCategory", "ChartCaption") ?></h3>
    <?php if (!$DashboardAll->isExport()) { ?>
        <div class="card-tools">
    <?php if ($DashboardAll->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("salesbyfilmcategorylist/SalesByCategory?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "&width=400&height=400") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $DashboardAll->renderItem($this, 1) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $DashboardAll->ItemClassNames[1] ?>" style=' min-width: 450px; min-height: 420px;'>
<div id="Item2" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("sales_by_store", "SalesByStore", "ChartCaption") ?></h3>
    <?php if (!$DashboardAll->isExport()) { ?>
        <div class="card-tools">
    <?php if ($DashboardAll->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("salesbystorelist/SalesByStore?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "&width=400&height=400") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $DashboardAll->renderItem($this, 2) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $DashboardAll->ItemClassNames[2] ?>" style=' min-width: 450px; min-height: 420px;'>
<div id="Item3" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("sales_by_store", "SalesByManager", "ChartCaption") ?></h3>
    <?php if (!$DashboardAll->isExport()) { ?>
        <div class="card-tools">
    <?php if ($DashboardAll->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("salesbystorelist/SalesByManager?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "&width=400&height=400") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $DashboardAll->renderItem($this, 3) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $DashboardAll->ItemClassNames[3] ?>" style=' min-width: 450px; min-height: 420px;'>
<div id="Item4" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("sales_by_film_category", "SalesByCategory", "ChartCaption") ?></h3>
    <?php if (!$DashboardAll->isExport()) { ?>
        <div class="card-tools">
    <?php if ($DashboardAll->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("salesbyfilmcategorylist/SalesByCategory?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "&width=400&height=400") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $DashboardAll->renderItem($this, 4) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
<div class="<?= $DashboardAll->ItemClassNames[4] ?>" style=' min-width: 450px; min-height: 420px;'>
<div id="Item5" class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $Language->chartPhrase("staff_list2", "StaffByCity", "ChartCaption") ?></h3>
    <?php if (!$DashboardAll->isExport()) { ?>
        <div class="card-tools">
    <?php if ($DashboardAll->CanRefresh) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="<?= GetUrl("stafflist2list/StaffByCity?layout=false&" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport . "&width=400&height=400") ?>" data-load-on-init="<?= $Page->LoadOnInit ? "true" : "false" ?>"><i class="fa-solid fa-rotate"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanMaximize) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fa-solid fa-maximize"></i></button>
    <?php } ?>
    <?php if ($DashboardAll->CanCollapse) { ?>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa-solid fa-minus"></i></button>
    <?php } ?>
        </div>
    <?php } ?>
    </div><!-- /.card-header -->
    <div class="card-body">
        <?= $DashboardAll->renderItem($this, 5) ?>
    </div><!-- /.card-body -->
</div><!-- /.card -->
</div>
</div>
</div>
<!-- /.ew-dashboard -->
</div>
<!-- /.ew-report -->
<script>
loadjs.ready("load", () => jQuery('[data-card-widget="card-refresh"]')
    .on("loaded.fail.lte.cardrefresh", (e, jqXHR, textStatus, errorThrown) => console.error(errorThrown))
    .on("loaded.success.lte.cardrefresh", (e, result) => !ew.getError(result) || console.error(result)));
</script>
<?php if ($DashboardAll->isExport() && !$DashboardAll->isExport("print")) { ?>
<script class="ew-export-dashboard">
loadjs.ready("load", function() {
    ew.exportCustom("ew-dashboard", "<?= $DashboardAll->Export ?>", "DashboardAll");
    loadjs.done("exportdashboard");
});
</script>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
