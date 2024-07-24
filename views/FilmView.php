<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmView = &$Page;
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
<form name="ffilmview" id="ffilmview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ffilmview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilmview")
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
<input type="hidden" name="t" value="film">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->film_id->Visible) { // film_id ?>
    <tr id="r_film_id"<?= $Page->film_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_film_id"><?= $Page->film_id->caption() ?></span></td>
        <td data-name="film_id"<?= $Page->film_id->cellAttributes() ?>>
<span id="el_film_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<?= $Page->film_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_film__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_film_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->release_year->Visible) { // release_year ?>
    <tr id="r_release_year"<?= $Page->release_year->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_release_year"><?= $Page->release_year->caption() ?></span></td>
        <td data-name="release_year"<?= $Page->release_year->cellAttributes() ?>>
<span id="el_film_release_year">
<span<?= $Page->release_year->viewAttributes() ?>>
<?= $Page->release_year->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->language_id->Visible) { // language_id ?>
    <tr id="r_language_id"<?= $Page->language_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_language_id"><?= $Page->language_id->caption() ?></span></td>
        <td data-name="language_id"<?= $Page->language_id->cellAttributes() ?>>
<span id="el_film_language_id">
<span<?= $Page->language_id->viewAttributes() ?>>
<?= $Page->language_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->original_language_id->Visible) { // original_language_id ?>
    <tr id="r_original_language_id"<?= $Page->original_language_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_original_language_id"><?= $Page->original_language_id->caption() ?></span></td>
        <td data-name="original_language_id"<?= $Page->original_language_id->cellAttributes() ?>>
<span id="el_film_original_language_id">
<span<?= $Page->original_language_id->viewAttributes() ?>>
<?= $Page->original_language_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_duration->Visible) { // rental_duration ?>
    <tr id="r_rental_duration"<?= $Page->rental_duration->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_rental_duration"><?= $Page->rental_duration->caption() ?></span></td>
        <td data-name="rental_duration"<?= $Page->rental_duration->cellAttributes() ?>>
<span id="el_film_rental_duration">
<span<?= $Page->rental_duration->viewAttributes() ?>>
<?= $Page->rental_duration->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rental_rate->Visible) { // rental_rate ?>
    <tr id="r_rental_rate"<?= $Page->rental_rate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_rental_rate"><?= $Page->rental_rate->caption() ?></span></td>
        <td data-name="rental_rate"<?= $Page->rental_rate->cellAttributes() ?>>
<span id="el_film_rental_rate">
<span<?= $Page->rental_rate->viewAttributes() ?>>
<?= $Page->rental_rate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
    <tr id="r_length"<?= $Page->length->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_length"><?= $Page->length->caption() ?></span></td>
        <td data-name="length"<?= $Page->length->cellAttributes() ?>>
<span id="el_film_length">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
    <tr id="r_replacement_cost"<?= $Page->replacement_cost->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_replacement_cost"><?= $Page->replacement_cost->caption() ?></span></td>
        <td data-name="replacement_cost"<?= $Page->replacement_cost->cellAttributes() ?>>
<span id="el_film_replacement_cost">
<span<?= $Page->replacement_cost->viewAttributes() ?>>
<?= $Page->replacement_cost->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
    <tr id="r_rating"<?= $Page->rating->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_rating"><?= $Page->rating->caption() ?></span></td>
        <td data-name="rating"<?= $Page->rating->cellAttributes() ?>>
<span id="el_film_rating">
<span<?= $Page->rating->viewAttributes() ?>>
<?= $Page->rating->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->special_features->Visible) { // special_features ?>
    <tr id="r_special_features"<?= $Page->special_features->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_special_features"><?= $Page->special_features->caption() ?></span></td>
        <td data-name="special_features"<?= $Page->special_features->cellAttributes() ?>>
<span id="el_film_special_features">
<span<?= $Page->special_features->viewAttributes() ?>>
<?= $Page->special_features->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_film_last_update">
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
