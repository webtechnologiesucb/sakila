<?php

namespace PHPMaker2024\Sakila;

// Page object
$RentalView = &$Page;
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
<form name="frentalview" id="frentalview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rental: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var frentalview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frentalview")
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
<input type="hidden" name="t" value="rental">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->rental_id->Visible) { // rental_id ?>
    <tr id="r_rental_id"<?= $Page->rental_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_rental_id"><?= $Page->rental_id->caption() ?></span></td>
        <td data-name="rental_id"<?= $Page->rental_id->cellAttributes() ?>>
<span id="el_rental_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<?= $Page->rental_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_date->Visible) { // rental_date ?>
    <tr id="r_rental_date"<?= $Page->rental_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_rental_date"><?= $Page->rental_date->caption() ?></span></td>
        <td data-name="rental_date"<?= $Page->rental_date->cellAttributes() ?>>
<span id="el_rental_rental_date">
<span<?= $Page->rental_date->viewAttributes() ?>>
<?= $Page->rental_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <tr id="r_inventory_id"<?= $Page->inventory_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_inventory_id"><?= $Page->inventory_id->caption() ?></span></td>
        <td data-name="inventory_id"<?= $Page->inventory_id->cellAttributes() ?>>
<span id="el_rental_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
    <tr id="r_customer_id"<?= $Page->customer_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_customer_id"><?= $Page->customer_id->caption() ?></span></td>
        <td data-name="customer_id"<?= $Page->customer_id->cellAttributes() ?>>
<span id="el_rental_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->return_date->Visible) { // return_date ?>
    <tr id="r_return_date"<?= $Page->return_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_return_date"><?= $Page->return_date->caption() ?></span></td>
        <td data-name="return_date"<?= $Page->return_date->cellAttributes() ?>>
<span id="el_rental_return_date">
<span<?= $Page->return_date->viewAttributes() ?>>
<?= $Page->return_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
    <tr id="r_staff_id"<?= $Page->staff_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_staff_id"><?= $Page->staff_id->caption() ?></span></td>
        <td data-name="staff_id"<?= $Page->staff_id->cellAttributes() ?>>
<span id="el_rental_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<?= $Page->staff_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rental_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_rental_last_update">
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
