<?php

namespace PHPMaker2024\Sakila;

// Page object
$StoreAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { store: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fstoreadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstoreadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["manager_staff_id", [fields.manager_staff_id.visible && fields.manager_staff_id.required ? ew.Validators.required(fields.manager_staff_id.caption) : null, ew.Validators.integer], fields.manager_staff_id.isInvalid],
            ["address_id", [fields.address_id.visible && fields.address_id.required ? ew.Validators.required(fields.address_id.caption) : null, ew.Validators.integer], fields.address_id.isInvalid],
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
            "manager_staff_id": <?= $Page->manager_staff_id->toClientList($Page) ?>,
            "address_id": <?= $Page->address_id->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstoreadd" id="fstoreadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="store">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->manager_staff_id->Visible) { // manager_staff_id ?>
    <div id="r_manager_staff_id"<?= $Page->manager_staff_id->rowAttributes() ?>>
        <label id="elh_store_manager_staff_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->manager_staff_id->caption() ?><?= $Page->manager_staff_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->manager_staff_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_store_manager_staff_id">
    <select
        id="x_manager_staff_id"
        name="x_manager_staff_id"
        class="form-control ew-select<?= $Page->manager_staff_id->isInvalidClass() ?>"
        data-select2-id="fstoreadd_x_manager_staff_id"
        data-table="store"
        data-field="x_manager_staff_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->manager_staff_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->manager_staff_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->manager_staff_id->getPlaceHolder()) ?>"
        <?= $Page->manager_staff_id->editAttributes() ?>>
        <?= $Page->manager_staff_id->selectOptionListHtml("x_manager_staff_id") ?>
    </select>
    <?= $Page->manager_staff_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->manager_staff_id->getErrorMessage() ?></div>
<?= $Page->manager_staff_id->Lookup->getParamTag($Page, "p_x_manager_staff_id") ?>
<script>
loadjs.ready("fstoreadd", function() {
    var options = { name: "x_manager_staff_id", selectId: "fstoreadd_x_manager_staff_id" };
    if (fstoreadd.lists.manager_staff_id?.lookupOptions.length) {
        options.data = { id: "x_manager_staff_id", form: "fstoreadd" };
    } else {
        options.ajax = { id: "x_manager_staff_id", form: "fstoreadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.store.fields.manager_staff_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_store_manager_staff_id">
<span<?= $Page->manager_staff_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->manager_staff_id->getDisplayValue($Page->manager_staff_id->ViewValue) ?></span></span>
<input type="hidden" data-table="store" data-field="x_manager_staff_id" data-hidden="1" name="x_manager_staff_id" id="x_manager_staff_id" value="<?= HtmlEncode($Page->manager_staff_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
    <div id="r_address_id"<?= $Page->address_id->rowAttributes() ?>>
        <label id="elh_store_address_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address_id->caption() ?><?= $Page->address_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_store_address_id">
    <select
        id="x_address_id"
        name="x_address_id"
        class="form-control ew-select<?= $Page->address_id->isInvalidClass() ?>"
        data-select2-id="fstoreadd_x_address_id"
        data-table="store"
        data-field="x_address_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->address_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->address_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->address_id->getPlaceHolder()) ?>"
        <?= $Page->address_id->editAttributes() ?>>
        <?= $Page->address_id->selectOptionListHtml("x_address_id") ?>
    </select>
    <?= $Page->address_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->address_id->getErrorMessage() ?></div>
<?= $Page->address_id->Lookup->getParamTag($Page, "p_x_address_id") ?>
<script>
loadjs.ready("fstoreadd", function() {
    var options = { name: "x_address_id", selectId: "fstoreadd_x_address_id" };
    if (fstoreadd.lists.address_id?.lookupOptions.length) {
        options.data = { id: "x_address_id", form: "fstoreadd" };
    } else {
        options.ajax = { id: "x_address_id", form: "fstoreadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.store.fields.address_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_store_address_id">
<span<?= $Page->address_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->address_id->getDisplayValue($Page->address_id->ViewValue) ?></span></span>
<input type="hidden" data-table="store" data-field="x_address_id" data-hidden="1" name="x_address_id" id="x_address_id" value="<?= HtmlEncode($Page->address_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_store_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_store_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="store" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstoreadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fstoreadd", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_store_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="store" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstoreadd" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstoreadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstoreadd"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fstoreadd" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("store");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
