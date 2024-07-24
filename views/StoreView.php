<?php

namespace PHPMaker2024\Sakila;

// Page object
$StoreView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="fstoreview" id="fstoreview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { store: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fstoreview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstoreview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="store">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->store_id->Visible) { // store_id ?>
    <tr id="r_store_id"<?= $Page->store_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_store_store_id"><?= $Page->store_id->caption() ?></span></td>
        <td data-name="store_id"<?= $Page->store_id->cellAttributes() ?>>
<span id="el_store_store_id">
<span<?= $Page->store_id->viewAttributes() ?>>
<?= $Page->store_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->manager_staff_id->Visible) { // manager_staff_id ?>
    <tr id="r_manager_staff_id"<?= $Page->manager_staff_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_store_manager_staff_id"><?= $Page->manager_staff_id->caption() ?></span></td>
        <td data-name="manager_staff_id"<?= $Page->manager_staff_id->cellAttributes() ?>>
<span id="el_store_manager_staff_id">
<span<?= $Page->manager_staff_id->viewAttributes() ?>>
<?= $Page->manager_staff_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
    <tr id="r_address_id"<?= $Page->address_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_store_address_id"><?= $Page->address_id->caption() ?></span></td>
        <td data-name="address_id"<?= $Page->address_id->cellAttributes() ?>>
<span id="el_store_address_id">
<span<?= $Page->address_id->viewAttributes() ?>>
<?= $Page->address_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_store_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_store_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<?= $Page->last_update->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
