<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film: currentTable } });
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="ffilmsrch" id="ffilmsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="ffilmsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film: currentTable } });
var currentForm;
var ffilmsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("ffilmsrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ffilmsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ffilmsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ffilmsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ffilmsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
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
<input type="hidden" name="t" value="film">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_film" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_filmlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->film_id->Visible) { // film_id ?>
        <th data-name="film_id" class="<?= $Page->film_id->headerCellClass() ?>"><div id="elh_film_film_id" class="film_film_id"><?= $Page->renderFieldHeader($Page->film_id) ?></div></th>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Page->_title->headerCellClass() ?>"><div id="elh_film__title" class="film__title"><?= $Page->renderFieldHeader($Page->_title) ?></div></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th data-name="description" class="<?= $Page->description->headerCellClass() ?>"><div id="elh_film_description" class="film_description"><?= $Page->renderFieldHeader($Page->description) ?></div></th>
<?php } ?>
<?php if ($Page->release_year->Visible) { // release_year ?>
        <th data-name="release_year" class="<?= $Page->release_year->headerCellClass() ?>"><div id="elh_film_release_year" class="film_release_year"><?= $Page->renderFieldHeader($Page->release_year) ?></div></th>
<?php } ?>
<?php if ($Page->language_id->Visible) { // language_id ?>
        <th data-name="language_id" class="<?= $Page->language_id->headerCellClass() ?>"><div id="elh_film_language_id" class="film_language_id"><?= $Page->renderFieldHeader($Page->language_id) ?></div></th>
<?php } ?>
<?php if ($Page->original_language_id->Visible) { // original_language_id ?>
        <th data-name="original_language_id" class="<?= $Page->original_language_id->headerCellClass() ?>"><div id="elh_film_original_language_id" class="film_original_language_id"><?= $Page->renderFieldHeader($Page->original_language_id) ?></div></th>
<?php } ?>
<?php if ($Page->rental_duration->Visible) { // rental_duration ?>
        <th data-name="rental_duration" class="<?= $Page->rental_duration->headerCellClass() ?>"><div id="elh_film_rental_duration" class="film_rental_duration"><?= $Page->renderFieldHeader($Page->rental_duration) ?></div></th>
<?php } ?>
<?php if ($Page->rental_rate->Visible) { // rental_rate ?>
        <th data-name="rental_rate" class="<?= $Page->rental_rate->headerCellClass() ?>"><div id="elh_film_rental_rate" class="film_rental_rate"><?= $Page->renderFieldHeader($Page->rental_rate) ?></div></th>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <th data-name="length" class="<?= $Page->length->headerCellClass() ?>"><div id="elh_film_length" class="film_length"><?= $Page->renderFieldHeader($Page->length) ?></div></th>
<?php } ?>
<?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
        <th data-name="replacement_cost" class="<?= $Page->replacement_cost->headerCellClass() ?>"><div id="elh_film_replacement_cost" class="film_replacement_cost"><?= $Page->renderFieldHeader($Page->replacement_cost) ?></div></th>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
        <th data-name="rating" class="<?= $Page->rating->headerCellClass() ?>"><div id="elh_film_rating" class="film_rating"><?= $Page->renderFieldHeader($Page->rating) ?></div></th>
<?php } ?>
<?php if ($Page->special_features->Visible) { // special_features ?>
        <th data-name="special_features" class="<?= $Page->special_features->headerCellClass() ?>"><div id="elh_film_special_features" class="film_special_features"><?= $Page->renderFieldHeader($Page->special_features) ?></div></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th data-name="last_update" class="<?= $Page->last_update->headerCellClass() ?>"><div id="elh_film_last_update" class="film_last_update"><?= $Page->renderFieldHeader($Page->last_update) ?></div></th>
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
    <?php if ($Page->film_id->Visible) { // film_id ?>
        <td data-name="film_id"<?= $Page->film_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_film_id" class="el_film_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<?= $Page->film_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film__title" class="el_film__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->description->Visible) { // description ?>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_description" class="el_film_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->release_year->Visible) { // release_year ?>
        <td data-name="release_year"<?= $Page->release_year->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_release_year" class="el_film_release_year">
<span<?= $Page->release_year->viewAttributes() ?>>
<?= $Page->release_year->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->language_id->Visible) { // language_id ?>
        <td data-name="language_id"<?= $Page->language_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_language_id" class="el_film_language_id">
<span<?= $Page->language_id->viewAttributes() ?>>
<?= $Page->language_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->original_language_id->Visible) { // original_language_id ?>
        <td data-name="original_language_id"<?= $Page->original_language_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_original_language_id" class="el_film_original_language_id">
<span<?= $Page->original_language_id->viewAttributes() ?>>
<?= $Page->original_language_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rental_duration->Visible) { // rental_duration ?>
        <td data-name="rental_duration"<?= $Page->rental_duration->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_rental_duration" class="el_film_rental_duration">
<span<?= $Page->rental_duration->viewAttributes() ?>>
<?= $Page->rental_duration->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rental_rate->Visible) { // rental_rate ?>
        <td data-name="rental_rate"<?= $Page->rental_rate->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_rental_rate" class="el_film_rental_rate">
<span<?= $Page->rental_rate->viewAttributes() ?>>
<?= $Page->rental_rate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->length->Visible) { // length ?>
        <td data-name="length"<?= $Page->length->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_length" class="el_film_length">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
        <td data-name="replacement_cost"<?= $Page->replacement_cost->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_replacement_cost" class="el_film_replacement_cost">
<span<?= $Page->replacement_cost->viewAttributes() ?>>
<?= $Page->replacement_cost->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rating->Visible) { // rating ?>
        <td data-name="rating"<?= $Page->rating->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_rating" class="el_film_rating">
<span<?= $Page->rating->viewAttributes() ?>>
<?= $Page->rating->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->special_features->Visible) { // special_features ?>
        <td data-name="special_features"<?= $Page->special_features->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_special_features" class="el_film_special_features">
<span<?= $Page->special_features->viewAttributes() ?>>
<?= $Page->special_features->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->last_update->Visible) { // last_update ?>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_film_last_update" class="el_film_last_update">
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
    ew.addEventHandlers("film");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
