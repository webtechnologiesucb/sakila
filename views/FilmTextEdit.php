<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmTextEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffilm_textedit" id="ffilm_textedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film_text: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffilm_textedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilm_textedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["film_id", [fields.film_id.visible && fields.film_id.required ? ew.Validators.required(fields.film_id.caption) : null, ew.Validators.integer], fields.film_id.isInvalid],
            ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid]
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
            "film_id": <?= $Page->film_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="film_text">
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
        <label id="elh_film_text_film_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->film_id->caption() ?><?= $Page->film_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->film_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_text_film_id">
    <select
        id="x_film_id"
        name="x_film_id"
        class="form-control ew-select<?= $Page->film_id->isInvalidClass() ?>"
        data-select2-id="ffilm_textedit_x_film_id"
        data-table="film_text"
        data-field="x_film_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->film_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->film_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->film_id->getPlaceHolder()) ?>"
        <?= $Page->film_id->editAttributes() ?>>
        <?= $Page->film_id->selectOptionListHtml("x_film_id") ?>
    </select>
    <?= $Page->film_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->film_id->getErrorMessage() ?></div>
<?= $Page->film_id->Lookup->getParamTag($Page, "p_x_film_id") ?>
<script>
loadjs.ready("ffilm_textedit", function() {
    var options = { name: "x_film_id", selectId: "ffilm_textedit_x_film_id" };
    if (ffilm_textedit.lists.film_id?.lookupOptions.length) {
        options.data = { id: "x_film_id", form: "ffilm_textedit" };
    } else {
        options.ajax = { id: "x_film_id", form: "ffilm_textedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film_text.fields.film_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
<input type="hidden" data-table="film_text" data-field="x_film_id" data-hidden="1" data-old name="o_film_id" id="o_film_id" value="<?= HtmlEncode($Page->film_id->OldValue ?? $Page->film_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_film_text_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->film_id->getDisplayValue($Page->film_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film_text" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->FormValue) ?>">
<input type="hidden" data-table="film_text" data-field="x_film_id" data-hidden="1" data-old name="o_film_id" id="o_film_id" value="<?= HtmlEncode($Page->film_id->OldValue ?? $Page->film_id->CurrentValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <div id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <label id="elh_film_text__title" for="x__title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?><?= $Page->_title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_text__title">
<input type="<?= $Page->_title->getInputTextType() ?>" name="x__title" id="x__title" data-table="film_text" data-field="x__title" value="<?= $Page->_title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_title->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_title->formatPattern()) ?>"<?= $Page->_title->editAttributes() ?> aria-describedby="x__title_help">
<?= $Page->_title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_text__title">
<span<?= $Page->_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_title->getDisplayValue($Page->_title->ViewValue))) ?>"></span>
<input type="hidden" data-table="film_text" data-field="x__title" data-hidden="1" name="x__title" id="x__title" value="<?= HtmlEncode($Page->_title->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_film_text_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_text_description">
<input type="<?= $Page->description->getInputTextType() ?>" name="x_description" id="x_description" data-table="film_text" data-field="x_description" value="<?= $Page->description->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->description->formatPattern()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help">
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_film_text_description">
<span<?= $Page->description->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->description->getDisplayValue($Page->description->ViewValue))) ?>"></span>
<input type="hidden" data-table="film_text" data-field="x_description" data-hidden="1" name="x_description" id="x_description" value="<?= HtmlEncode($Page->description->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_textedit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="ffilm_textedit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_textedit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffilm_textedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_textedit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="ffilm_textedit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("film_text");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
