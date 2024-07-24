<?php

namespace PHPMaker2024\Sakila;

// Page object
$CityEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fcityedit" id="fcityedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { city: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcityedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcityedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["city_id", [fields.city_id.visible && fields.city_id.required ? ew.Validators.required(fields.city_id.caption) : null], fields.city_id.isInvalid],
            ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
            ["country_id", [fields.country_id.visible && fields.country_id.required ? ew.Validators.required(fields.country_id.caption) : null], fields.country_id.isInvalid],
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
            "country_id": <?= $Page->country_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="city">
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
<?php if ($Page->city_id->Visible) { // city_id ?>
    <div id="r_city_id"<?= $Page->city_id->rowAttributes() ?>>
        <label id="elh_city_city_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city_id->caption() ?><?= $Page->city_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_city_city_id">
<span<?= $Page->city_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->city_id->getDisplayValue($Page->city_id->EditValue))) ?>"></span>
<input type="hidden" data-table="city" data-field="x_city_id" data-hidden="1" name="x_city_id" id="x_city_id" value="<?= HtmlEncode($Page->city_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_city_city_id">
<span<?= $Page->city_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->city_id->getDisplayValue($Page->city_id->ViewValue))) ?>"></span>
<input type="hidden" data-table="city" data-field="x_city_id" data-hidden="1" name="x_city_id" id="x_city_id" value="<?= HtmlEncode($Page->city_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city"<?= $Page->city->rowAttributes() ?>>
        <label id="elh_city_city" for="x_city" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_city_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="city" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->city->formatPattern()) ?>"<?= $Page->city->editAttributes() ?> aria-describedby="x_city_help">
<?= $Page->city->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_city_city">
<span<?= $Page->city->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->city->getDisplayValue($Page->city->ViewValue))) ?>"></span>
<input type="hidden" data-table="city" data-field="x_city" data-hidden="1" name="x_city" id="x_city" value="<?= HtmlEncode($Page->city->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country_id->Visible) { // country_id ?>
    <div id="r_country_id"<?= $Page->country_id->rowAttributes() ?>>
        <label id="elh_city_country_id" for="x_country_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->country_id->caption() ?><?= $Page->country_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->country_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_city_country_id">
    <select
        id="x_country_id"
        name="x_country_id"
        class="form-control ew-select<?= $Page->country_id->isInvalidClass() ?>"
        data-select2-id="fcityedit_x_country_id"
        data-table="city"
        data-field="x_country_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->country_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->country_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->country_id->getPlaceHolder()) ?>"
        <?= $Page->country_id->editAttributes() ?>>
        <?= $Page->country_id->selectOptionListHtml("x_country_id") ?>
    </select>
    <?= $Page->country_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->country_id->getErrorMessage() ?></div>
<?= $Page->country_id->Lookup->getParamTag($Page, "p_x_country_id") ?>
<script>
loadjs.ready("fcityedit", function() {
    var options = { name: "x_country_id", selectId: "fcityedit_x_country_id" };
    if (fcityedit.lists.country_id?.lookupOptions.length) {
        options.data = { id: "x_country_id", form: "fcityedit" };
    } else {
        options.ajax = { id: "x_country_id", form: "fcityedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.city.fields.country_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_city_country_id">
<span<?= $Page->country_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->country_id->getDisplayValue($Page->country_id->ViewValue) ?></span></span>
<input type="hidden" data-table="city" data-field="x_country_id" data-hidden="1" name="x_country_id" id="x_country_id" value="<?= HtmlEncode($Page->country_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_city_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_city_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="city" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcityedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcityedit", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_city_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="city" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcityedit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="fcityedit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcityedit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcityedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcityedit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fcityedit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("city");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
