<?php

namespace PHPMaker2024\Sakila;

// Page object
$RentalEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="frentaledit" id="frentaledit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rental: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var frentaledit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frentaledit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["rental_id", [fields.rental_id.visible && fields.rental_id.required ? ew.Validators.required(fields.rental_id.caption) : null], fields.rental_id.isInvalid],
            ["rental_date", [fields.rental_date.visible && fields.rental_date.required ? ew.Validators.required(fields.rental_date.caption) : null, ew.Validators.datetime(fields.rental_date.clientFormatPattern)], fields.rental_date.isInvalid],
            ["inventory_id", [fields.inventory_id.visible && fields.inventory_id.required ? ew.Validators.required(fields.inventory_id.caption) : null, ew.Validators.integer], fields.inventory_id.isInvalid],
            ["customer_id", [fields.customer_id.visible && fields.customer_id.required ? ew.Validators.required(fields.customer_id.caption) : null, ew.Validators.integer], fields.customer_id.isInvalid],
            ["return_date", [fields.return_date.visible && fields.return_date.required ? ew.Validators.required(fields.return_date.caption) : null, ew.Validators.datetime(fields.return_date.clientFormatPattern)], fields.return_date.isInvalid],
            ["staff_id", [fields.staff_id.visible && fields.staff_id.required ? ew.Validators.required(fields.staff_id.caption) : null, ew.Validators.integer], fields.staff_id.isInvalid],
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
            "inventory_id": <?= $Page->inventory_id->toClientList($Page) ?>,
            "customer_id": <?= $Page->customer_id->toClientList($Page) ?>,
            "staff_id": <?= $Page->staff_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="rental">
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
<?php if ($Page->rental_id->Visible) { // rental_id ?>
    <div id="r_rental_id"<?= $Page->rental_id->rowAttributes() ?>>
        <label id="elh_rental_rental_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_id->caption() ?><?= $Page->rental_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->rental_id->getDisplayValue($Page->rental_id->EditValue))) ?>"></span>
<input type="hidden" data-table="rental" data-field="x_rental_id" data-hidden="1" name="x_rental_id" id="x_rental_id" value="<?= HtmlEncode($Page->rental_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_rental_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->rental_id->getDisplayValue($Page->rental_id->ViewValue))) ?>"></span>
<input type="hidden" data-table="rental" data-field="x_rental_id" data-hidden="1" name="x_rental_id" id="x_rental_id" value="<?= HtmlEncode($Page->rental_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_date->Visible) { // rental_date ?>
    <div id="r_rental_date"<?= $Page->rental_date->rowAttributes() ?>>
        <label id="elh_rental_rental_date" for="x_rental_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_date->caption() ?><?= $Page->rental_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_rental_date">
<input type="<?= $Page->rental_date->getInputTextType() ?>" name="x_rental_date" id="x_rental_date" data-table="rental" data-field="x_rental_date" value="<?= $Page->rental_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->rental_date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rental_date->formatPattern()) ?>"<?= $Page->rental_date->editAttributes() ?> aria-describedby="x_rental_date_help">
<?= $Page->rental_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rental_date->getErrorMessage() ?></div>
<?php if (!$Page->rental_date->ReadOnly && !$Page->rental_date->Disabled && !isset($Page->rental_date->EditAttrs["readonly"]) && !isset($Page->rental_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frentaledit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frentaledit", "x_rental_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_rental_rental_date">
<span<?= $Page->rental_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->rental_date->getDisplayValue($Page->rental_date->ViewValue))) ?>"></span>
<input type="hidden" data-table="rental" data-field="x_rental_date" data-hidden="1" name="x_rental_date" id="x_rental_date" value="<?= HtmlEncode($Page->rental_date->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->inventory_id->Visible) { // inventory_id ?>
    <div id="r_inventory_id"<?= $Page->inventory_id->rowAttributes() ?>>
        <label id="elh_rental_inventory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->inventory_id->caption() ?><?= $Page->inventory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->inventory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_inventory_id">
    <select
        id="x_inventory_id"
        name="x_inventory_id"
        class="form-control ew-select<?= $Page->inventory_id->isInvalidClass() ?>"
        data-select2-id="frentaledit_x_inventory_id"
        data-table="rental"
        data-field="x_inventory_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->inventory_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->inventory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->inventory_id->getPlaceHolder()) ?>"
        <?= $Page->inventory_id->editAttributes() ?>>
        <?= $Page->inventory_id->selectOptionListHtml("x_inventory_id") ?>
    </select>
    <?= $Page->inventory_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->inventory_id->getErrorMessage() ?></div>
<?= $Page->inventory_id->Lookup->getParamTag($Page, "p_x_inventory_id") ?>
<script>
loadjs.ready("frentaledit", function() {
    var options = { name: "x_inventory_id", selectId: "frentaledit_x_inventory_id" };
    if (frentaledit.lists.inventory_id?.lookupOptions.length) {
        options.data = { id: "x_inventory_id", form: "frentaledit" };
    } else {
        options.ajax = { id: "x_inventory_id", form: "frentaledit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rental.fields.inventory_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_rental_inventory_id">
<span<?= $Page->inventory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->inventory_id->getDisplayValue($Page->inventory_id->ViewValue) ?></span></span>
<input type="hidden" data-table="rental" data-field="x_inventory_id" data-hidden="1" name="x_inventory_id" id="x_inventory_id" value="<?= HtmlEncode($Page->inventory_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->customer_id->Visible) { // customer_id ?>
    <div id="r_customer_id"<?= $Page->customer_id->rowAttributes() ?>>
        <label id="elh_rental_customer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->customer_id->caption() ?><?= $Page->customer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->customer_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_customer_id">
    <select
        id="x_customer_id"
        name="x_customer_id"
        class="form-control ew-select<?= $Page->customer_id->isInvalidClass() ?>"
        data-select2-id="frentaledit_x_customer_id"
        data-table="rental"
        data-field="x_customer_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->customer_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->customer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->customer_id->getPlaceHolder()) ?>"
        <?= $Page->customer_id->editAttributes() ?>>
        <?= $Page->customer_id->selectOptionListHtml("x_customer_id") ?>
    </select>
    <?= $Page->customer_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->customer_id->getErrorMessage() ?></div>
<?= $Page->customer_id->Lookup->getParamTag($Page, "p_x_customer_id") ?>
<script>
loadjs.ready("frentaledit", function() {
    var options = { name: "x_customer_id", selectId: "frentaledit_x_customer_id" };
    if (frentaledit.lists.customer_id?.lookupOptions.length) {
        options.data = { id: "x_customer_id", form: "frentaledit" };
    } else {
        options.ajax = { id: "x_customer_id", form: "frentaledit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rental.fields.customer_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_rental_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->customer_id->getDisplayValue($Page->customer_id->ViewValue) ?></span></span>
<input type="hidden" data-table="rental" data-field="x_customer_id" data-hidden="1" name="x_customer_id" id="x_customer_id" value="<?= HtmlEncode($Page->customer_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->return_date->Visible) { // return_date ?>
    <div id="r_return_date"<?= $Page->return_date->rowAttributes() ?>>
        <label id="elh_rental_return_date" for="x_return_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->return_date->caption() ?><?= $Page->return_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->return_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_return_date">
<input type="<?= $Page->return_date->getInputTextType() ?>" name="x_return_date" id="x_return_date" data-table="rental" data-field="x_return_date" value="<?= $Page->return_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->return_date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->return_date->formatPattern()) ?>"<?= $Page->return_date->editAttributes() ?> aria-describedby="x_return_date_help">
<?= $Page->return_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->return_date->getErrorMessage() ?></div>
<?php if (!$Page->return_date->ReadOnly && !$Page->return_date->Disabled && !isset($Page->return_date->EditAttrs["readonly"]) && !isset($Page->return_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frentaledit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frentaledit", "x_return_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_rental_return_date">
<span<?= $Page->return_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->return_date->getDisplayValue($Page->return_date->ViewValue))) ?>"></span>
<input type="hidden" data-table="rental" data-field="x_return_date" data-hidden="1" name="x_return_date" id="x_return_date" value="<?= HtmlEncode($Page->return_date->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
    <div id="r_staff_id"<?= $Page->staff_id->rowAttributes() ?>>
        <label id="elh_rental_staff_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->staff_id->caption() ?><?= $Page->staff_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->staff_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_staff_id">
    <select
        id="x_staff_id"
        name="x_staff_id"
        class="form-control ew-select<?= $Page->staff_id->isInvalidClass() ?>"
        data-select2-id="frentaledit_x_staff_id"
        data-table="rental"
        data-field="x_staff_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->staff_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->staff_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->staff_id->getPlaceHolder()) ?>"
        <?= $Page->staff_id->editAttributes() ?>>
        <?= $Page->staff_id->selectOptionListHtml("x_staff_id") ?>
    </select>
    <?= $Page->staff_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->staff_id->getErrorMessage() ?></div>
<?= $Page->staff_id->Lookup->getParamTag($Page, "p_x_staff_id") ?>
<script>
loadjs.ready("frentaledit", function() {
    var options = { name: "x_staff_id", selectId: "frentaledit_x_staff_id" };
    if (frentaledit.lists.staff_id?.lookupOptions.length) {
        options.data = { id: "x_staff_id", form: "frentaledit" };
    } else {
        options.ajax = { id: "x_staff_id", form: "frentaledit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.rental.fields.staff_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_rental_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->staff_id->getDisplayValue($Page->staff_id->ViewValue) ?></span></span>
<input type="hidden" data-table="rental" data-field="x_staff_id" data-hidden="1" name="x_staff_id" id="x_staff_id" value="<?= HtmlEncode($Page->staff_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_rental_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_rental_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="rental" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["frentaledit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("frentaledit", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_rental_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="rental" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frentaledit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="frentaledit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frentaledit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frentaledit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frentaledit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="frentaledit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("rental");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
