<?php

namespace PHPMaker2024\Sakila;

// Page object
$CustomerView = &$Page;
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
<form name="fcustomerview" id="fcustomerview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { customer: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fcustomerview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcustomerview")
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
<input type="hidden" name="t" value="customer">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->customer_id->Visible) { // customer_id ?>
    <tr id="r_customer_id"<?= $Page->customer_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_customer_id"><?= $Page->customer_id->caption() ?></span></td>
        <td data-name="customer_id"<?= $Page->customer_id->cellAttributes() ?>>
<span id="el_customer_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->store_id->Visible) { // store_id ?>
    <tr id="r_store_id"<?= $Page->store_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_store_id"><?= $Page->store_id->caption() ?></span></td>
        <td data-name="store_id"<?= $Page->store_id->cellAttributes() ?>>
<span id="el_customer_store_id">
<span<?= $Page->store_id->viewAttributes() ?>>
<?= $Page->store_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <tr id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_first_name"><?= $Page->first_name->caption() ?></span></td>
        <td data-name="first_name"<?= $Page->first_name->cellAttributes() ?>>
<span id="el_customer_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <tr id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_last_name"><?= $Page->last_name->caption() ?></span></td>
        <td data-name="last_name"<?= $Page->last_name->cellAttributes() ?>>
<span id="el_customer_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_customer__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
    <tr id="r_address_id"<?= $Page->address_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_address_id"><?= $Page->address_id->caption() ?></span></td>
        <td data-name="address_id"<?= $Page->address_id->cellAttributes() ?>>
<span id="el_customer_address_id">
<span<?= $Page->address_id->viewAttributes() ?>>
<?= $Page->address_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <tr id="r_active"<?= $Page->active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_active"><?= $Page->active->caption() ?></span></td>
        <td data-name="active"<?= $Page->active->cellAttributes() ?>>
<span id="el_customer_active">
<span<?= $Page->active->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->active->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
    <tr id="r_create_date"<?= $Page->create_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_create_date"><?= $Page->create_date->caption() ?></span></td>
        <td data-name="create_date"<?= $Page->create_date->cellAttributes() ?>>
<span id="el_customer_create_date">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_customer_last_update">
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
