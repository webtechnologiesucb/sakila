<?php

namespace PHPMaker2024\Sakila;

// Page object
$PaymentView = &$Page;
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
<form name="fpaymentview" id="fpaymentview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { payment: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fpaymentview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpaymentview")
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
<input type="hidden" name="t" value="payment">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->payment_id->Visible) { // payment_id ?>
    <tr id="r_payment_id"<?= $Page->payment_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_payment_id"><?= $Page->payment_id->caption() ?></span></td>
        <td data-name="payment_id"<?= $Page->payment_id->cellAttributes() ?>>
<span id="el_payment_payment_id">
<span<?= $Page->payment_id->viewAttributes() ?>>
<?= $Page->payment_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
    <tr id="r_customer_id"<?= $Page->customer_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_customer_id"><?= $Page->customer_id->caption() ?></span></td>
        <td data-name="customer_id"<?= $Page->customer_id->cellAttributes() ?>>
<span id="el_payment_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
    <tr id="r_staff_id"<?= $Page->staff_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_staff_id"><?= $Page->staff_id->caption() ?></span></td>
        <td data-name="staff_id"<?= $Page->staff_id->cellAttributes() ?>>
<span id="el_payment_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<?= $Page->staff_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_id->Visible) { // rental_id ?>
    <tr id="r_rental_id"<?= $Page->rental_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_rental_id"><?= $Page->rental_id->caption() ?></span></td>
        <td data-name="rental_id"<?= $Page->rental_id->cellAttributes() ?>>
<span id="el_payment_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<?= $Page->rental_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <tr id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_amount"><?= $Page->amount->caption() ?></span></td>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el_payment_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <tr id="r_payment_date"<?= $Page->payment_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_payment_date"><?= $Page->payment_date->caption() ?></span></td>
        <td data-name="payment_date"<?= $Page->payment_date->cellAttributes() ?>>
<span id="el_payment_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<?= $Page->payment_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_payment_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_payment_last_update">
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
