<?php

namespace PHPMaker2024\Sakila;

// Page object
$InventoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { inventory: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var finventoryadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("finventoryadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["film_id", [fields.film_id.visible && fields.film_id.required ? ew.Validators.required(fields.film_id.caption) : null, ew.Validators.integer], fields.film_id.isInvalid],
            ["store_id", [fields.store_id.visible && fields.store_id.required ? ew.Validators.required(fields.store_id.caption) : null, ew.Validators.integer], fields.store_id.isInvalid],
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
            "store_id": <?= $Page->store_id->toClientList($Page) ?>,
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
<form name="finventoryadd" id="finventoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="inventory">
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
<?php if ($Page->film_id->Visible) { // film_id ?>
    <div id="r_film_id"<?= $Page->film_id->rowAttributes() ?>>
        <label id="elh_inventory_film_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->film_id->caption() ?><?= $Page->film_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->film_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_inventory_film_id">
    <select
        id="x_film_id"
        name="x_film_id"
        class="form-control ew-select<?= $Page->film_id->isInvalidClass() ?>"
        data-select2-id="finventoryadd_x_film_id"
        data-table="inventory"
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
loadjs.ready("finventoryadd", function() {
    var options = { name: "x_film_id", selectId: "finventoryadd_x_film_id" };
    if (finventoryadd.lists.film_id?.lookupOptions.length) {
        options.data = { id: "x_film_id", form: "finventoryadd" };
    } else {
        options.ajax = { id: "x_film_id", form: "finventoryadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.inventory.fields.film_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_inventory_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->film_id->getDisplayValue($Page->film_id->ViewValue) ?></span></span>
<input type="hidden" data-table="inventory" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->store_id->Visible) { // store_id ?>
    <div id="r_store_id"<?= $Page->store_id->rowAttributes() ?>>
        <label id="elh_inventory_store_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->store_id->caption() ?><?= $Page->store_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->store_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_inventory_store_id">
    <select
        id="x_store_id"
        name="x_store_id"
        class="form-control ew-select<?= $Page->store_id->isInvalidClass() ?>"
        data-select2-id="finventoryadd_x_store_id"
        data-table="inventory"
        data-field="x_store_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->store_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->store_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->store_id->getPlaceHolder()) ?>"
        <?= $Page->store_id->editAttributes() ?>>
        <?= $Page->store_id->selectOptionListHtml("x_store_id") ?>
    </select>
    <?= $Page->store_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->store_id->getErrorMessage() ?></div>
<?= $Page->store_id->Lookup->getParamTag($Page, "p_x_store_id") ?>
<script>
loadjs.ready("finventoryadd", function() {
    var options = { name: "x_store_id", selectId: "finventoryadd_x_store_id" };
    if (finventoryadd.lists.store_id?.lookupOptions.length) {
        options.data = { id: "x_store_id", form: "finventoryadd" };
    } else {
        options.ajax = { id: "x_store_id", form: "finventoryadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.inventory.fields.store_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_inventory_store_id">
<span<?= $Page->store_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->store_id->getDisplayValue($Page->store_id->ViewValue) ?></span></span>
<input type="hidden" data-table="inventory" data-field="x_store_id" data-hidden="1" name="x_store_id" id="x_store_id" value="<?= HtmlEncode($Page->store_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_inventory_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_inventory_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="inventory" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finventoryadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("finventoryadd", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_inventory_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="inventory" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="finventoryadd" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="finventoryadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="finventoryadd"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="finventoryadd" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("inventory");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
