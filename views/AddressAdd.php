<?php

namespace PHPMaker2024\Sakila;

// Page object
$AddressAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { address: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var faddressadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("faddressadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
            ["address2", [fields.address2.visible && fields.address2.required ? ew.Validators.required(fields.address2.caption) : null], fields.address2.isInvalid],
            ["district", [fields.district.visible && fields.district.required ? ew.Validators.required(fields.district.caption) : null], fields.district.isInvalid],
            ["city_id", [fields.city_id.visible && fields.city_id.required ? ew.Validators.required(fields.city_id.caption) : null, ew.Validators.integer], fields.city_id.isInvalid],
            ["postal_code", [fields.postal_code.visible && fields.postal_code.required ? ew.Validators.required(fields.postal_code.caption) : null], fields.postal_code.isInvalid],
            ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
            ["location", [fields.location.visible && fields.location.required ? ew.Validators.required(fields.location.caption) : null], fields.location.isInvalid],
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
            "city_id": <?= $Page->city_id->toClientList($Page) ?>,
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
<form name="faddressadd" id="faddressadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="address">
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
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_address_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="address" data-field="x_address" value="<?= $Page->address->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->address->formatPattern()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_address">
<span<?= $Page->address->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->address->getDisplayValue($Page->address->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_address" data-hidden="1" name="x_address" id="x_address" value="<?= HtmlEncode($Page->address->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address2->Visible) { // address2 ?>
    <div id="r_address2"<?= $Page->address2->rowAttributes() ?>>
        <label id="elh_address_address2" for="x_address2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address2->caption() ?><?= $Page->address2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address2->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_address2">
<input type="<?= $Page->address2->getInputTextType() ?>" name="x_address2" id="x_address2" data-table="address" data-field="x_address2" value="<?= $Page->address2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->address2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->address2->formatPattern()) ?>"<?= $Page->address2->editAttributes() ?> aria-describedby="x_address2_help">
<?= $Page->address2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_address2">
<span<?= $Page->address2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->address2->getDisplayValue($Page->address2->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_address2" data-hidden="1" name="x_address2" id="x_address2" value="<?= HtmlEncode($Page->address2->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->district->Visible) { // district ?>
    <div id="r_district"<?= $Page->district->rowAttributes() ?>>
        <label id="elh_address_district" for="x_district" class="<?= $Page->LeftColumnClass ?>"><?= $Page->district->caption() ?><?= $Page->district->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->district->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_district">
<input type="<?= $Page->district->getInputTextType() ?>" name="x_district" id="x_district" data-table="address" data-field="x_district" value="<?= $Page->district->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->district->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->district->formatPattern()) ?>"<?= $Page->district->editAttributes() ?> aria-describedby="x_district_help">
<?= $Page->district->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->district->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_district">
<span<?= $Page->district->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->district->getDisplayValue($Page->district->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_district" data-hidden="1" name="x_district" id="x_district" value="<?= HtmlEncode($Page->district->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city_id->Visible) { // city_id ?>
    <div id="r_city_id"<?= $Page->city_id->rowAttributes() ?>>
        <label id="elh_address_city_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city_id->caption() ?><?= $Page->city_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_city_id">
    <select
        id="x_city_id"
        name="x_city_id"
        class="form-control ew-select<?= $Page->city_id->isInvalidClass() ?>"
        data-select2-id="faddressadd_x_city_id"
        data-table="address"
        data-field="x_city_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->city_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->city_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->city_id->getPlaceHolder()) ?>"
        <?= $Page->city_id->editAttributes() ?>>
        <?= $Page->city_id->selectOptionListHtml("x_city_id") ?>
    </select>
    <?= $Page->city_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->city_id->getErrorMessage() ?></div>
<?= $Page->city_id->Lookup->getParamTag($Page, "p_x_city_id") ?>
<script>
loadjs.ready("faddressadd", function() {
    var options = { name: "x_city_id", selectId: "faddressadd_x_city_id" };
    if (faddressadd.lists.city_id?.lookupOptions.length) {
        options.data = { id: "x_city_id", form: "faddressadd" };
    } else {
        options.ajax = { id: "x_city_id", form: "faddressadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.address.fields.city_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_address_city_id">
<span<?= $Page->city_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->city_id->getDisplayValue($Page->city_id->ViewValue) ?></span></span>
<input type="hidden" data-table="address" data-field="x_city_id" data-hidden="1" name="x_city_id" id="x_city_id" value="<?= HtmlEncode($Page->city_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->postal_code->Visible) { // postal_code ?>
    <div id="r_postal_code"<?= $Page->postal_code->rowAttributes() ?>>
        <label id="elh_address_postal_code" for="x_postal_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->postal_code->caption() ?><?= $Page->postal_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->postal_code->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_postal_code">
<input type="<?= $Page->postal_code->getInputTextType() ?>" name="x_postal_code" id="x_postal_code" data-table="address" data-field="x_postal_code" value="<?= $Page->postal_code->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->postal_code->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->postal_code->formatPattern()) ?>"<?= $Page->postal_code->editAttributes() ?> aria-describedby="x_postal_code_help">
<?= $Page->postal_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->postal_code->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_postal_code">
<span<?= $Page->postal_code->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->postal_code->getDisplayValue($Page->postal_code->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_postal_code" data-hidden="1" name="x_postal_code" id="x_postal_code" value="<?= HtmlEncode($Page->postal_code->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_address_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="address" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->phone->formatPattern()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help">
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->phone->getDisplayValue($Page->phone->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_phone" data-hidden="1" name="x_phone" id="x_phone" value="<?= HtmlEncode($Page->phone->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
    <div id="r_location"<?= $Page->location->rowAttributes() ?>>
        <label id="elh_address_location" for="x_location" class="<?= $Page->LeftColumnClass ?>"><?= $Page->location->caption() ?><?= $Page->location->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->location->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_location">
<input type="<?= $Page->location->getInputTextType() ?>" name="x_location" id="x_location" data-table="address" data-field="x_location" value="<?= $Page->location->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->location->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->location->formatPattern()) ?>"<?= $Page->location->editAttributes() ?> aria-describedby="x_location_help">
<?= $Page->location->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->location->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_address_location">
<span<?= $Page->location->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->location->getDisplayValue($Page->location->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_location" data-hidden="1" name="x_location" id="x_location" value="<?= HtmlEncode($Page->location->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_address_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_address_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="address" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["faddressadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("faddressadd", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_address_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="address" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="faddressadd" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="faddressadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="faddressadd"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="faddressadd" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("address");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
