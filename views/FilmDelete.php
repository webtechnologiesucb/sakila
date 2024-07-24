<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var ffilmdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilmdelete")
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
<form name="ffilmdelete" id="ffilmdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="film">
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
        <th class="<?= $Page->film_id->headerCellClass() ?>"><span id="elh_film_film_id" class="film_film_id"><?= $Page->film_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><span id="elh_film__title" class="film__title"><?= $Page->_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_film_description" class="film_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->release_year->Visible) { // release_year ?>
        <th class="<?= $Page->release_year->headerCellClass() ?>"><span id="elh_film_release_year" class="film_release_year"><?= $Page->release_year->caption() ?></span></th>
<?php } ?>
<?php if ($Page->language_id->Visible) { // language_id ?>
        <th class="<?= $Page->language_id->headerCellClass() ?>"><span id="elh_film_language_id" class="film_language_id"><?= $Page->language_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->original_language_id->Visible) { // original_language_id ?>
        <th class="<?= $Page->original_language_id->headerCellClass() ?>"><span id="elh_film_original_language_id" class="film_original_language_id"><?= $Page->original_language_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_duration->Visible) { // rental_duration ?>
        <th class="<?= $Page->rental_duration->headerCellClass() ?>"><span id="elh_film_rental_duration" class="film_rental_duration"><?= $Page->rental_duration->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rental_rate->Visible) { // rental_rate ?>
        <th class="<?= $Page->rental_rate->headerCellClass() ?>"><span id="elh_film_rental_rate" class="film_rental_rate"><?= $Page->rental_rate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <th class="<?= $Page->length->headerCellClass() ?>"><span id="elh_film_length" class="film_length"><?= $Page->length->caption() ?></span></th>
<?php } ?>
<?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
        <th class="<?= $Page->replacement_cost->headerCellClass() ?>"><span id="elh_film_replacement_cost" class="film_replacement_cost"><?= $Page->replacement_cost->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
        <th class="<?= $Page->rating->headerCellClass() ?>"><span id="elh_film_rating" class="film_rating"><?= $Page->rating->caption() ?></span></th>
<?php } ?>
<?php if ($Page->special_features->Visible) { // special_features ?>
        <th class="<?= $Page->special_features->headerCellClass() ?>"><span id="elh_film_special_features" class="film_special_features"><?= $Page->special_features->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_film_last_update" class="film_last_update"><?= $Page->last_update->caption() ?></span></th>
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
<?php if ($Page->_title->Visible) { // title ?>
        <td<?= $Page->_title->cellAttributes() ?>>
<span id="">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td<?= $Page->description->cellAttributes() ?>>
<span id="">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->release_year->Visible) { // release_year ?>
        <td<?= $Page->release_year->cellAttributes() ?>>
<span id="">
<span<?= $Page->release_year->viewAttributes() ?>>
<?= $Page->release_year->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->language_id->Visible) { // language_id ?>
        <td<?= $Page->language_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->language_id->viewAttributes() ?>>
<?= $Page->language_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->original_language_id->Visible) { // original_language_id ?>
        <td<?= $Page->original_language_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->original_language_id->viewAttributes() ?>>
<?= $Page->original_language_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_duration->Visible) { // rental_duration ?>
        <td<?= $Page->rental_duration->cellAttributes() ?>>
<span id="">
<span<?= $Page->rental_duration->viewAttributes() ?>>
<?= $Page->rental_duration->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rental_rate->Visible) { // rental_rate ?>
        <td<?= $Page->rental_rate->cellAttributes() ?>>
<span id="">
<span<?= $Page->rental_rate->viewAttributes() ?>>
<?= $Page->rental_rate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <td<?= $Page->length->cellAttributes() ?>>
<span id="">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
        <td<?= $Page->replacement_cost->cellAttributes() ?>>
<span id="">
<span<?= $Page->replacement_cost->viewAttributes() ?>>
<?= $Page->replacement_cost->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
        <td<?= $Page->rating->cellAttributes() ?>>
<span id="">
<span<?= $Page->rating->viewAttributes() ?>>
<?= $Page->rating->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->special_features->Visible) { // special_features ?>
        <td<?= $Page->special_features->cellAttributes() ?>>
<span id="">
<span<?= $Page->special_features->viewAttributes() ?>>
<?= $Page->special_features->getViewValue() ?></span>
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
