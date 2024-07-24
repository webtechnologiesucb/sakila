<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmCategoryEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="ffilm_categoryedit" id="ffilm_categoryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film_category: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var ffilm_categoryedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilm_categoryedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["film_id", [fields.film_id.visible && fields.film_id.required ? ew.Validators.required(fields.film_id.caption) : null, ew.Validators.integer], fields.film_id.isInvalid],
            ["category_id", [fields.category_id.visible && fields.category_id.required ? ew.Validators.required(fields.category_id.caption) : null, ew.Validators.integer], fields.category_id.isInvalid],
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
            "film_id": <?= $Page->film_id->toClientList($Page) ?>,
            "category_id": <?= $Page->category_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="film_category">
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
        <label id="elh_film_category_film_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->film_id->caption() ?><?= $Page->film_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->film_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_category_film_id">
    <select
        id="x_film_id"
        name="x_film_id"
        class="form-control ew-select<?= $Page->film_id->isInvalidClass() ?>"
        data-select2-id="ffilm_categoryedit_x_film_id"
        data-table="film_category"
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
loadjs.ready("ffilm_categoryedit", function() {
    var options = { name: "x_film_id", selectId: "ffilm_categoryedit_x_film_id" };
    if (ffilm_categoryedit.lists.film_id?.lookupOptions.length) {
        options.data = { id: "x_film_id", form: "ffilm_categoryedit" };
    } else {
        options.ajax = { id: "x_film_id", form: "ffilm_categoryedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film_category.fields.film_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
<input type="hidden" data-table="film_category" data-field="x_film_id" data-hidden="1" data-old name="o_film_id" id="o_film_id" value="<?= HtmlEncode($Page->film_id->OldValue ?? $Page->film_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_film_category_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->film_id->getDisplayValue($Page->film_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film_category" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->FormValue) ?>">
<input type="hidden" data-table="film_category" data-field="x_film_id" data-hidden="1" data-old name="o_film_id" id="o_film_id" value="<?= HtmlEncode($Page->film_id->OldValue ?? $Page->film_id->CurrentValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category_id->Visible) { // category_id ?>
    <div id="r_category_id"<?= $Page->category_id->rowAttributes() ?>>
        <label id="elh_film_category_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category_id->caption() ?><?= $Page->category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_category_category_id">
    <select
        id="x_category_id"
        name="x_category_id"
        class="form-control ew-select<?= $Page->category_id->isInvalidClass() ?>"
        data-select2-id="ffilm_categoryedit_x_category_id"
        data-table="film_category"
        data-field="x_category_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->category_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->category_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->category_id->getPlaceHolder()) ?>"
        <?= $Page->category_id->editAttributes() ?>>
        <?= $Page->category_id->selectOptionListHtml("x_category_id") ?>
    </select>
    <?= $Page->category_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->category_id->getErrorMessage() ?></div>
<?= $Page->category_id->Lookup->getParamTag($Page, "p_x_category_id") ?>
<script>
loadjs.ready("ffilm_categoryedit", function() {
    var options = { name: "x_category_id", selectId: "ffilm_categoryedit_x_category_id" };
    if (ffilm_categoryedit.lists.category_id?.lookupOptions.length) {
        options.data = { id: "x_category_id", form: "ffilm_categoryedit" };
    } else {
        options.ajax = { id: "x_category_id", form: "ffilm_categoryedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film_category.fields.category_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
<input type="hidden" data-table="film_category" data-field="x_category_id" data-hidden="1" data-old name="o_category_id" id="o_category_id" value="<?= HtmlEncode($Page->category_id->OldValue ?? $Page->category_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_film_category_category_id">
<span<?= $Page->category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->category_id->getDisplayValue($Page->category_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film_category" data-field="x_category_id" data-hidden="1" name="x_category_id" id="x_category_id" value="<?= HtmlEncode($Page->category_id->FormValue) ?>">
<input type="hidden" data-table="film_category" data-field="x_category_id" data-hidden="1" data-old name="o_category_id" id="o_category_id" value="<?= HtmlEncode($Page->category_id->OldValue ?? $Page->category_id->CurrentValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_film_category_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_category_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="film_category" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffilm_categoryedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffilm_categoryedit", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_film_category_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="film_category" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_categoryedit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="ffilm_categoryedit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_categoryedit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffilm_categoryedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_categoryedit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="ffilm_categoryedit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("film_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
