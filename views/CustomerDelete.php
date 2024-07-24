<?php

namespace PHPMaker2024\Sakila;

// Page object
$CustomerDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { customer: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fcustomerdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcustomerdelete")
        .setPageId("delete")
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcustomerdelete" id="fcustomerdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customer">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <th class="<?= $Page->customer_id->headerCellClass() ?>"><span id="elh_customer_customer_id" class="customer_customer_id"><?= $Page->customer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->store_id->Visible) { // store_id ?>
        <th class="<?= $Page->store_id->headerCellClass() ?>"><span id="elh_customer_store_id" class="customer_store_id"><?= $Page->store_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
        <th class="<?= $Page->first_name->headerCellClass() ?>"><span id="elh_customer_first_name" class="customer_first_name"><?= $Page->first_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
        <th class="<?= $Page->last_name->headerCellClass() ?>"><span id="elh_customer_last_name" class="customer_last_name"><?= $Page->last_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_customer__email" class="customer__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
        <th class="<?= $Page->address_id->headerCellClass() ?>"><span id="elh_customer_address_id" class="customer_address_id"><?= $Page->address_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><span id="elh_customer_active" class="customer_active"><?= $Page->active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <th class="<?= $Page->create_date->headerCellClass() ?>"><span id="elh_customer_create_date" class="customer_create_date"><?= $Page->create_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_customer_last_update" class="customer_last_update"><?= $Page->last_update->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <td<?= $Page->customer_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->store_id->Visible) { // store_id ?>
        <td<?= $Page->store_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->store_id->viewAttributes() ?>>
<?= $Page->store_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
        <td<?= $Page->first_name->cellAttributes() ?>>
<span id="">
<span<?= $Page->first_name->viewAttributes() ?>>
<?= $Page->first_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
        <td<?= $Page->last_name->cellAttributes() ?>>
<span id="">
<span<?= $Page->last_name->viewAttributes() ?>>
<?= $Page->last_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
        <td<?= $Page->address_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->address_id->viewAttributes() ?>>
<?= $Page->address_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <td<?= $Page->active->cellAttributes() ?>>
<span id="">
<span<?= $Page->active->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->active->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_date->Visible) { // create_date ?>
        <td<?= $Page->create_date->cellAttributes() ?>>
<span id="">
<span<?= $Page->create_date->viewAttributes() ?>>
<?= $Page->create_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <td<?= $Page->last_update->cellAttributes() ?>>
<span id="">
<span<?= $Page->last_update->viewAttributes() ?>>
<?= $Page->last_update->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
