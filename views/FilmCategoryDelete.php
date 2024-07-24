<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmCategoryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film_category: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ffilm_categorydelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilm_categorydelete")
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
<form name="ffilm_categorydelete" id="ffilm_categorydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="film_category">
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
<?php if ($Page->film_id->Visible) { // film_id ?>
        <th class="<?= $Page->film_id->headerCellClass() ?>"><span id="elh_film_category_film_id" class="film_category_film_id"><?= $Page->film_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
        <th class="<?= $Page->category_id->headerCellClass() ?>"><span id="elh_film_category_category_id" class="film_category_category_id"><?= $Page->category_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_film_category_last_update" class="film_category_last_update"><?= $Page->last_update->caption() ?></span></th>
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
<?php if ($Page->film_id->Visible) { // film_id ?>
        <td<?= $Page->film_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->film_id->viewAttributes() ?>>
<?= $Page->film_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
        <td<?= $Page->category_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->category_id->viewAttributes() ?>>
<?= $Page->category_id->getViewValue() ?></span>
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
