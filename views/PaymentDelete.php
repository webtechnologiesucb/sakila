<?php

namespace PHPMaker2024\Sakila;

// Page object
$PaymentDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { payment: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fpaymentdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpaymentdelete")
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
<form name="fpaymentdelete" id="fpaymentdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="payment">
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
<?php if ($Page->payment_id->Visible) { // payment_id ?>
        <th class="<?= $Page->payment_id->headerCellClass() ?>"><span id="elh_payment_payment_id" class="payment_payment_id"><?= $Page->payment_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <th class="<?= $Page->customer_id->headerCellClass() ?>"><span id="elh_payment_customer_id" class="payment_customer_id"><?= $Page->customer_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
        <th class="<?= $Page->staff_id->headerCellClass() ?>"><span id="elh_payment_staff_id" class="payment_staff_id"><?= $Page->staff_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_id->Visible) { // rental_id ?>
        <th class="<?= $Page->rental_id->headerCellClass() ?>"><span id="elh_payment_rental_id" class="payment_rental_id"><?= $Page->rental_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><span id="elh_payment_amount" class="payment_amount"><?= $Page->amount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <th class="<?= $Page->payment_date->headerCellClass() ?>"><span id="elh_payment_payment_date" class="payment_payment_date"><?= $Page->payment_date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_payment_last_update" class="payment_last_update"><?= $Page->last_update->caption() ?></span></th>
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
<?php if ($Page->payment_id->Visible) { // payment_id ?>
        <td<?= $Page->payment_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->payment_id->viewAttributes() ?>>
<?= $Page->payment_id->getViewValue() ?></span>
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
<?php if ($Page->staff_id->Visible) { // staff_id ?>
        <td<?= $Page->staff_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->staff_id->viewAttributes() ?>>
<?= $Page->staff_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_id->Visible) { // rental_id ?>
        <td<?= $Page->rental_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->rental_id->viewAttributes() ?>>
<?= $Page->rental_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <td<?= $Page->amount->cellAttributes() ?>>
<span id="">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
        <td<?= $Page->payment_date->cellAttributes() ?>>
<span id="">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
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
