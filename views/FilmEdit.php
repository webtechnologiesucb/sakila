<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffilmedit" id="ffilmedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffilmedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilmedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["film_id", [fields.film_id.visible && fields.film_id.required ? ew.Validators.required(fields.film_id.caption) : null], fields.film_id.isInvalid],
            ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["release_year", [fields.release_year.visible && fields.release_year.required ? ew.Validators.required(fields.release_year.caption) : null, ew.Validators.integer], fields.release_year.isInvalid],
            ["language_id", [fields.language_id.visible && fields.language_id.required ? ew.Validators.required(fields.language_id.caption) : null, ew.Validators.integer], fields.language_id.isInvalid],
            ["original_language_id", [fields.original_language_id.visible && fields.original_language_id.required ? ew.Validators.required(fields.original_language_id.caption) : null, ew.Validators.integer], fields.original_language_id.isInvalid],
            ["rental_duration", [fields.rental_duration.visible && fields.rental_duration.required ? ew.Validators.required(fields.rental_duration.caption) : null, ew.Validators.integer], fields.rental_duration.isInvalid],
            ["rental_rate", [fields.rental_rate.visible && fields.rental_rate.required ? ew.Validators.required(fields.rental_rate.caption) : null, ew.Validators.float], fields.rental_rate.isInvalid],
            ["length", [fields.length.visible && fields.length.required ? ew.Validators.required(fields.length.caption) : null, ew.Validators.integer], fields.length.isInvalid],
            ["replacement_cost", [fields.replacement_cost.visible && fields.replacement_cost.required ? ew.Validators.required(fields.replacement_cost.caption) : null, ew.Validators.float], fields.replacement_cost.isInvalid],
            ["rating", [fields.rating.visible && fields.rating.required ? ew.Validators.required(fields.rating.caption) : null], fields.rating.isInvalid],
            ["special_features", [fields.special_features.visible && fields.special_features.required ? ew.Validators.required(fields.special_features.caption) : null], fields.special_features.isInvalid],
            ["last_update", [fields.last_update.visible && fields.last_update.required ? ew.Validators.required(fields.last_update.caption) : null, ew.Validators.datetime(fields.last_update.clientFormatPattern)], fields.last_update.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "language_id": <?= $Page->language_id->toClientList($Page) ?>,
            "original_language_id": <?= $Page->original_language_id->toClientList($Page) ?>,
            "rating": <?= $Page->rating->toClientList($Page) ?>,
            "special_features": <?= $Page->special_features->toClientList($Page) ?>,
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="film">
<input type="hidden" name="k_hash" id="k_hash" value="<?= $Page->HashValue ?>">
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->film_id->Visible) { // film_id ?>
    <div id="r_film_id"<?= $Page->film_id->rowAttributes() ?>>
        <label id="elh_film_film_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->film_id->caption() ?><?= $Page->film_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->film_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->film_id->getDisplayValue($Page->film_id->EditValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_film_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->film_id->getDisplayValue($Page->film_id->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_film__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="film" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="128" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_title->formatPattern()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film__title">
<span<?= $Page->_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_title->getDisplayValue($Page->_title->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x__title" data-hidden="1" name="x__title" id="x__title" value="<?= HtmlEncode($Page->_title->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_film_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_description">
<input type="<?= $Page->description->getInputTextType() ?>" name="x_description" id="x_description" data-table="film" data-field="x_description" value="<?= $Page->description->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->description->formatPattern()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help">
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_description">
<span<?= $Page->description->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->description->getDisplayValue($Page->description->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_description" data-hidden="1" name="x_description" id="x_description" value="<?= HtmlEncode($Page->description->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->release_year->Visible) { // release_year ?>
    <div id="r_release_year"<?= $Page->release_year->rowAttributes() ?>>
        <label id="elh_film_release_year" for="x_release_year" class="<?= $Page->LeftColumnClass ?>"><?= $Page->release_year->caption() ?><?= $Page->release_year->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->release_year->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_release_year">
<input type="<?= $Page->release_year->getInputTextType() ?>" name="x_release_year" id="x_release_year" data-table="film" data-field="x_release_year" value="<?= $Page->release_year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->release_year->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->release_year->formatPattern()) ?>"<?= $Page->release_year->editAttributes() ?> aria-describedby="x_release_year_help">
<?= $Page->release_year->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->release_year->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_release_year">
<span<?= $Page->release_year->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->release_year->getDisplayValue($Page->release_year->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_release_year" data-hidden="1" name="x_release_year" id="x_release_year" value="<?= HtmlEncode($Page->release_year->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->language_id->Visible) { // language_id ?>
    <div id="r_language_id"<?= $Page->language_id->rowAttributes() ?>>
        <label id="elh_film_language_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->language_id->caption() ?><?= $Page->language_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->language_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_language_id">
    <select
        id="x_language_id"
        name="x_language_id"
        class="form-control ew-select<?= $Page->language_id->isInvalidClass() ?>"
        data-select2-id="ffilmedit_x_language_id"
        data-table="film"
        data-field="x_language_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->language_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->language_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->language_id->getPlaceHolder()) ?>"
        <?= $Page->language_id->editAttributes() ?>>
        <?= $Page->language_id->selectOptionListHtml("x_language_id") ?>
    </select>
    <?= $Page->language_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->language_id->getErrorMessage() ?></div>
<?= $Page->language_id->Lookup->getParamTag($Page, "p_x_language_id") ?>
<script>
loadjs.ready("ffilmedit", function() {
    var options = { name: "x_language_id", selectId: "ffilmedit_x_language_id" };
    if (ffilmedit.lists.language_id?.lookupOptions.length) {
        options.data = { id: "x_language_id", form: "ffilmedit" };
    } else {
        options.ajax = { id: "x_language_id", form: "ffilmedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film.fields.language_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_film_language_id">
<span<?= $Page->language_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->language_id->getDisplayValue($Page->language_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film" data-field="x_language_id" data-hidden="1" name="x_language_id" id="x_language_id" value="<?= HtmlEncode($Page->language_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->original_language_id->Visible) { // original_language_id ?>
    <div id="r_original_language_id"<?= $Page->original_language_id->rowAttributes() ?>>
        <label id="elh_film_original_language_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->original_language_id->caption() ?><?= $Page->original_language_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->original_language_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_original_language_id">
    <select
        id="x_original_language_id"
        name="x_original_language_id"
        class="form-control ew-select<?= $Page->original_language_id->isInvalidClass() ?>"
        data-select2-id="ffilmedit_x_original_language_id"
        data-table="film"
        data-field="x_original_language_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->original_language_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->original_language_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->original_language_id->getPlaceHolder()) ?>"
        <?= $Page->original_language_id->editAttributes() ?>>
        <?= $Page->original_language_id->selectOptionListHtml("x_original_language_id") ?>
    </select>
    <?= $Page->original_language_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->original_language_id->getErrorMessage() ?></div>
<?= $Page->original_language_id->Lookup->getParamTag($Page, "p_x_original_language_id") ?>
<script>
loadjs.ready("ffilmedit", function() {
    var options = { name: "x_original_language_id", selectId: "ffilmedit_x_original_language_id" };
    if (ffilmedit.lists.original_language_id?.lookupOptions.length) {
        options.data = { id: "x_original_language_id", form: "ffilmedit" };
    } else {
        options.ajax = { id: "x_original_language_id", form: "ffilmedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film.fields.original_language_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_film_original_language_id">
<span<?= $Page->original_language_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->original_language_id->getDisplayValue($Page->original_language_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film" data-field="x_original_language_id" data-hidden="1" name="x_original_language_id" id="x_original_language_id" value="<?= HtmlEncode($Page->original_language_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_duration->Visible) { // rental_duration ?>
    <div id="r_rental_duration"<?= $Page->rental_duration->rowAttributes() ?>>
        <label id="elh_film_rental_duration" for="x_rental_duration" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_duration->caption() ?><?= $Page->rental_duration->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_duration->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_rental_duration">
<input type="<?= $Page->rental_duration->getInputTextType() ?>" name="x_rental_duration" id="x_rental_duration" data-table="film" data-field="x_rental_duration" value="<?= $Page->rental_duration->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rental_duration->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rental_duration->formatPattern()) ?>"<?= $Page->rental_duration->editAttributes() ?> aria-describedby="x_rental_duration_help">
<?= $Page->rental_duration->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rental_duration->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_rental_duration">
<span<?= $Page->rental_duration->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->rental_duration->getDisplayValue($Page->rental_duration->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_rental_duration" data-hidden="1" name="x_rental_duration" id="x_rental_duration" value="<?= HtmlEncode($Page->rental_duration->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_rate->Visible) { // rental_rate ?>
    <div id="r_rental_rate"<?= $Page->rental_rate->rowAttributes() ?>>
        <label id="elh_film_rental_rate" for="x_rental_rate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_rate->caption() ?><?= $Page->rental_rate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_rate->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_rental_rate">
<input type="<?= $Page->rental_rate->getInputTextType() ?>" name="x_rental_rate" id="x_rental_rate" data-table="film" data-field="x_rental_rate" value="<?= $Page->rental_rate->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->rental_rate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rental_rate->formatPattern()) ?>"<?= $Page->rental_rate->editAttributes() ?> aria-describedby="x_rental_rate_help">
<?= $Page->rental_rate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rental_rate->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_rental_rate">
<span<?= $Page->rental_rate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->rental_rate->getDisplayValue($Page->rental_rate->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_rental_rate" data-hidden="1" name="x_rental_rate" id="x_rental_rate" value="<?= HtmlEncode($Page->rental_rate->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
    <div id="r_length"<?= $Page->length->rowAttributes() ?>>
        <label id="elh_film_length" for="x_length" class="<?= $Page->LeftColumnClass ?>"><?= $Page->length->caption() ?><?= $Page->length->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->length->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_length">
<input type="<?= $Page->length->getInputTextType() ?>" name="x_length" id="x_length" data-table="film" data-field="x_length" value="<?= $Page->length->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->length->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->length->formatPattern()) ?>"<?= $Page->length->editAttributes() ?> aria-describedby="x_length_help">
<?= $Page->length->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->length->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_length">
<span<?= $Page->length->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->length->getDisplayValue($Page->length->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_length" data-hidden="1" name="x_length" id="x_length" value="<?= HtmlEncode($Page->length->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->replacement_cost->Visible) { // replacement_cost ?>
    <div id="r_replacement_cost"<?= $Page->replacement_cost->rowAttributes() ?>>
        <label id="elh_film_replacement_cost" for="x_replacement_cost" class="<?= $Page->LeftColumnClass ?>"><?= $Page->replacement_cost->caption() ?><?= $Page->replacement_cost->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->replacement_cost->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_replacement_cost">
<input type="<?= $Page->replacement_cost->getInputTextType() ?>" name="x_replacement_cost" id="x_replacement_cost" data-table="film" data-field="x_replacement_cost" value="<?= $Page->replacement_cost->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->replacement_cost->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->replacement_cost->formatPattern()) ?>"<?= $Page->replacement_cost->editAttributes() ?> aria-describedby="x_replacement_cost_help">
<?= $Page->replacement_cost->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->replacement_cost->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_replacement_cost">
<span<?= $Page->replacement_cost->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->replacement_cost->getDisplayValue($Page->replacement_cost->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_replacement_cost" data-hidden="1" name="x_replacement_cost" id="x_replacement_cost" value="<?= HtmlEncode($Page->replacement_cost->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rating->Visible) { // rating ?>
    <div id="r_rating"<?= $Page->rating->rowAttributes() ?>>
        <label id="elh_film_rating" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rating->caption() ?><?= $Page->rating->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rating->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_rating">
<template id="tp_x_rating">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="film" data-field="x_rating" name="x_rating" id="x_rating"<?= $Page->rating->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_rating" class="ew-item-list"></div>
<selection-list hidden
    id="x_rating"
    name="x_rating"
    value="<?= HtmlEncode($Page->rating->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_rating"
    data-target="dsl_x_rating"
    data-repeatcolumn="5"
    class="form-control<?= $Page->rating->isInvalidClass() ?>"
    data-table="film"
    data-field="x_rating"
    data-value-separator="<?= $Page->rating->displayValueSeparatorAttribute() ?>"
    <?= $Page->rating->editAttributes() ?>></selection-list>
<?= $Page->rating->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rating->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_rating">
<span<?= $Page->rating->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->rating->getDisplayValue($Page->rating->ViewValue) ?></span></span>
<input type="hidden" data-table="film" data-field="x_rating" data-hidden="1" name="x_rating" id="x_rating" value="<?= HtmlEncode($Page->rating->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->special_features->Visible) { // special_features ?>
    <div id="r_special_features"<?= $Page->special_features->rowAttributes() ?>>
        <label id="elh_film_special_features" class="<?= $Page->LeftColumnClass ?>"><?= $Page->special_features->caption() ?><?= $Page->special_features->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->special_features->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_special_features">
<template id="tp_x_special_features">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="film" data-field="x_special_features" name="x_special_features" id="x_special_features"<?= $Page->special_features->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_special_features" class="ew-item-list"></div>
<selection-list hidden
    id="x_special_features[]"
    name="x_special_features[]"
    value="<?= HtmlEncode($Page->special_features->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_special_features"
    data-target="dsl_x_special_features"
    data-repeatcolumn="5"
    class="form-control<?= $Page->special_features->isInvalidClass() ?>"
    data-table="film"
    data-field="x_special_features"
    data-value-separator="<?= $Page->special_features->displayValueSeparatorAttribute() ?>"
    <?= $Page->special_features->editAttributes() ?>></selection-list>
<?= $Page->special_features->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->special_features->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_special_features">
<span<?= $Page->special_features->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->special_features->getDisplayValue($Page->special_features->ViewValue) ?></span></span>
<input type="hidden" data-table="film" data-field="x_special_features" data-hidden="1" name="x_special_features" id="x_special_features" value="<?= HtmlEncode($Page->special_features->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_film_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="film" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffilmedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("ffilmedit", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_film_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="film" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilmedit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="ffilmedit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilmedit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffilmedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilmedit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="ffilmedit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
