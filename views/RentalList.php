<?php

namespace PHPMaker2024\Sakila;

// Page object
$RentalList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rental: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
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
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rental">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_rental" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_rentallist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->rental_id->Visible) { // rental_id ?>
        <th data-name="rental_id" class="<?= $Page->rental_id->headerCellClass() ?>"><div id="elh_rental_rental_id" class="rental_rental_id"><?= $Page->renderFieldHeader($Page->rental_id) ?></div></th>
<?php } ?>
<?php if ($Page->rental_date->Visible) { // rental_date ?>
        <th data-name="rental_date" class="<?= $Page->rental_date->headerCellClass() ?>"><div id="elh_rental_rental_date" class="rental_rental_date"><?= $Page->renderFieldHeader($Page->rental_date) ?></div></th>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <th data-name="inventory_id" class="<?= $Page->inventory_id->headerCellClass() ?>"><div id="elh_rental_inventory_id" class="rental_inventory_id"><?= $Page->renderFieldHeader($Page->inventory_id) ?></div></th>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
        <th data-name="customer_id" class="<?= $Page->customer_id->headerCellClass() ?>"><div id="elh_rental_customer_id" class="rental_customer_id"><?= $Page->renderFieldHeader($Page->customer_id) ?></div></th>
<?php } ?>
<?php if ($Page->return_date->Visible) { // return_date ?>
        <th data-name="return_date" class="<?= $Page->return_date->headerCellClass() ?>"><div id="elh_rental_return_date" class="rental_return_date"><?= $Page->renderFieldHeader($Page->return_date) ?></div></th>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
        <th data-name="staff_id" class="<?= $Page->staff_id->headerCellClass() ?>"><div id="elh_rental_staff_id" class="rental_staff_id"><?= $Page->renderFieldHeader($Page->staff_id) ?></div></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th data-name="last_update" class="<?= $Page->last_update->headerCellClass() ?>"><div id="elh_rental_last_update" class="rental_last_update"><?= $Page->renderFieldHeader($Page->last_update) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->rental_id->Visible) { // rental_id ?>
        <td data-name="rental_id"<?= $Page->rental_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_rental_id" class="el_rental_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<?= $Page->rental_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rental_date->Visible) { // rental_date ?>
        <td data-name="rental_date"<?= $Page->rental_date->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_rental_date" class="el_rental_rental_date">
<span<?= $Page->rental_date->viewAttributes() ?>>
<?= $Page->rental_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->inventory_id->Visible) { // inventory_id ?>
        <td data-name="inventory_id"<?= $Page->inventory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_inventory_id" class="el_rental_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<?= $Page->inventory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->customer_id->Visible) { // customer_id ?>
        <td data-name="customer_id"<?= $Page->customer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_customer_id" class="el_rental_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<?= $Page->customer_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->return_date->Visible) { // return_date ?>
        <td data-name="return_date"<?= $Page->return_date->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_return_date" class="el_rental_return_date">
<span<?= $Page->return_date->viewAttributes() ?>>
<?= $Page->return_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->staff_id->Visible) { // staff_id ?>
        <td data-name="staff_id"<?= $Page->staff_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_staff_id" class="el_rental_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<?= $Page->staff_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->last_update->Visible) { // last_update ?>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_rental_last_update" class="el_rental_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<?= $Page->last_update->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("rental");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
