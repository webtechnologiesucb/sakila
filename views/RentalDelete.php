<?php

namespace PHPMaker2024\Sakila;

// Page object
$RentalDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rental: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var frentaldelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frentaldelete")
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
<form name="frentaldelete" id="frentaldelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rental">
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
<?php if ($Page->rental_id->Visible) { // rental_id ?>
        <th class="<?= $Page->rental_id->headerCellClass() ?>"><span id="elh_rental_rental_id" class="rental_rental_id"><?= $Page->rental_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_date->Visible) { // rental_date ?>
        <th class="<?= $Page->rental_date->headerCellClass() ?>"><span id="elh_rental_rental_date" class="rental_rental_date"><?= $Page->rental_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <th class="<?= $Page->inventory_id->headerCellClass() ?>"><span id="elh_rental_inventory_id" class="rental_inventory_id"><?= $Page->inventory_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <th class="<?= $Page->customer_id->headerCellClass() ?>"><span id="elh_rental_customer_id" class="rental_customer_id"><?= $Page->customer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->return_date->Visible) { // return_date ?>
        <th class="<?= $Page->return_date->headerCellClass() ?>"><span id="elh_rental_return_date" class="rental_return_date"><?= $Page->return_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
        <th class="<?= $Page->staff_id->headerCellClass() ?>"><span id="elh_rental_staff_id" class="rental_staff_id"><?= $Page->staff_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_rental_last_update" class="rental_last_update"><?= $Page->last_update->caption() ?></span></th>
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
<?php if ($Page->rental_id->Visible) { // rental_id ?>
        <td<?= $Page->rental_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->rental_id->viewAttributes() ?>>
<?= $Page->rental_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_date->Visible) { // rental_date ?>
        <td<?= $Page->rental_date->cellAttributes() ?>>
<span id="">
<span<?= $Page->rental_date->viewAttributes() ?>>
<?= $Page->rental_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td<?= $Page->inventory_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <td<?= $Page->customer_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->return_date->Visible) { // return_date ?>
        <td<?= $Page->return_date->cellAttributes() ?>>
<span id="">
<span<?= $Page->return_date->viewAttributes() ?>>
<?= $Page->return_date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
        <td<?= $Page->staff_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->staff_id->viewAttributes() ?>>
<?= $Page->staff_id->getViewValue() ?></span>
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
