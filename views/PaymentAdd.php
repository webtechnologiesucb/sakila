<?php

namespace PHPMaker2024\Sakila;

// Page object
$PaymentAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { payment: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fpaymentadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpaymentadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["customer_id", [fields.customer_id.visible && fields.customer_id.required ? ew.Validators.required(fields.customer_id.caption) : null, ew.Validators.integer], fields.customer_id.isInvalid],
            ["staff_id", [fields.staff_id.visible && fields.staff_id.required ? ew.Validators.required(fields.staff_id.caption) : null, ew.Validators.integer], fields.staff_id.isInvalid],
            ["rental_id", [fields.rental_id.visible && fields.rental_id.required ? ew.Validators.required(fields.rental_id.caption) : null, ew.Validators.integer], fields.rental_id.isInvalid],
            ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.float], fields.amount.isInvalid],
            ["payment_date", [fields.payment_date.visible && fields.payment_date.required ? ew.Validators.required(fields.payment_date.caption) : null, ew.Validators.datetime(fields.payment_date.clientFormatPattern)], fields.payment_date.isInvalid],
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
            "customer_id": <?= $Page->customer_id->toClientList($Page) ?>,
            "staff_id": <?= $Page->staff_id->toClientList($Page) ?>,
            "rental_id": <?= $Page->rental_id->toClientList($Page) ?>,
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
<form name="fpaymentadd" id="fpaymentadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="payment">
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
<?php if ($Page->customer_id->Visible) { // customer_id ?>
    <div id="r_customer_id"<?= $Page->customer_id->rowAttributes() ?>>
        <label id="elh_payment_customer_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->customer_id->caption() ?><?= $Page->customer_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->customer_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_customer_id">
    <select
        id="x_customer_id"
        name="x_customer_id"
        class="form-control ew-select<?= $Page->customer_id->isInvalidClass() ?>"
        data-select2-id="fpaymentadd_x_customer_id"
        data-table="payment"
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
loadjs.ready("fpaymentadd", function() {
    var options = { name: "x_customer_id", selectId: "fpaymentadd_x_customer_id" };
    if (fpaymentadd.lists.customer_id?.lookupOptions.length) {
        options.data = { id: "x_customer_id", form: "fpaymentadd" };
    } else {
        options.ajax = { id: "x_customer_id", form: "fpaymentadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.payment.fields.customer_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_payment_customer_id">
<span<?= $Page->customer_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->customer_id->getDisplayValue($Page->customer_id->ViewValue) ?></span></span>
<input type="hidden" data-table="payment" data-field="x_customer_id" data-hidden="1" name="x_customer_id" id="x_customer_id" value="<?= HtmlEncode($Page->customer_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->staff_id->Visible) { // staff_id ?>
    <div id="r_staff_id"<?= $Page->staff_id->rowAttributes() ?>>
        <label id="elh_payment_staff_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->staff_id->caption() ?><?= $Page->staff_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->staff_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_staff_id">
    <select
        id="x_staff_id"
        name="x_staff_id"
        class="form-control ew-select<?= $Page->staff_id->isInvalidClass() ?>"
        data-select2-id="fpaymentadd_x_staff_id"
        data-table="payment"
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
loadjs.ready("fpaymentadd", function() {
    var options = { name: "x_staff_id", selectId: "fpaymentadd_x_staff_id" };
    if (fpaymentadd.lists.staff_id?.lookupOptions.length) {
        options.data = { id: "x_staff_id", form: "fpaymentadd" };
    } else {
        options.ajax = { id: "x_staff_id", form: "fpaymentadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.payment.fields.staff_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_payment_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->staff_id->getDisplayValue($Page->staff_id->ViewValue) ?></span></span>
<input type="hidden" data-table="payment" data-field="x_staff_id" data-hidden="1" name="x_staff_id" id="x_staff_id" value="<?= HtmlEncode($Page->staff_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rental_id->Visible) { // rental_id ?>
    <div id="r_rental_id"<?= $Page->rental_id->rowAttributes() ?>>
        <label id="elh_payment_rental_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rental_id->caption() ?><?= $Page->rental_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rental_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_rental_id">
    <select
        id="x_rental_id"
        name="x_rental_id"
        class="form-control ew-select<?= $Page->rental_id->isInvalidClass() ?>"
        data-select2-id="fpaymentadd_x_rental_id"
        data-table="payment"
        data-field="x_rental_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->rental_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->rental_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rental_id->getPlaceHolder()) ?>"
        <?= $Page->rental_id->editAttributes() ?>>
        <?= $Page->rental_id->selectOptionListHtml("x_rental_id") ?>
    </select>
    <?= $Page->rental_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->rental_id->getErrorMessage() ?></div>
<?= $Page->rental_id->Lookup->getParamTag($Page, "p_x_rental_id") ?>
<script>
loadjs.ready("fpaymentadd", function() {
    var options = { name: "x_rental_id", selectId: "fpaymentadd_x_rental_id" };
    if (fpaymentadd.lists.rental_id?.lookupOptions.length) {
        options.data = { id: "x_rental_id", form: "fpaymentadd" };
    } else {
        options.ajax = { id: "x_rental_id", form: "fpaymentadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.payment.fields.rental_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_payment_rental_id">
<span<?= $Page->rental_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->rental_id->getDisplayValue($Page->rental_id->ViewValue) ?></span></span>
<input type="hidden" data-table="payment" data-field="x_rental_id" data-hidden="1" name="x_rental_id" id="x_rental_id" value="<?= HtmlEncode($Page->rental_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <div id="r_amount"<?= $Page->amount->rowAttributes() ?>>
        <label id="elh_payment_amount" for="x_amount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->amount->caption() ?><?= $Page->amount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->amount->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_amount">
<input type="<?= $Page->amount->getInputTextType() ?>" name="x_amount" id="x_amount" data-table="payment" data-field="x_amount" value="<?= $Page->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->amount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->amount->formatPattern()) ?>"<?= $Page->amount->editAttributes() ?> aria-describedby="x_amount_help">
<?= $Page->amount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_payment_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->amount->getDisplayValue($Page->amount->ViewValue))) ?>"></span>
<input type="hidden" data-table="payment" data-field="x_amount" data-hidden="1" name="x_amount" id="x_amount" value="<?= HtmlEncode($Page->amount->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->payment_date->Visible) { // payment_date ?>
    <div id="r_payment_date"<?= $Page->payment_date->rowAttributes() ?>>
        <label id="elh_payment_payment_date" for="x_payment_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->payment_date->caption() ?><?= $Page->payment_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->payment_date->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_payment_date">
<input type="<?= $Page->payment_date->getInputTextType() ?>" name="x_payment_date" id="x_payment_date" data-table="payment" data-field="x_payment_date" value="<?= $Page->payment_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->payment_date->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->payment_date->formatPattern()) ?>"<?= $Page->payment_date->editAttributes() ?> aria-describedby="x_payment_date_help">
<?= $Page->payment_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->payment_date->getErrorMessage() ?></div>
<?php if (!$Page->payment_date->ReadOnly && !$Page->payment_date->Disabled && !isset($Page->payment_date->EditAttrs["readonly"]) && !isset($Page->payment_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpaymentadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpaymentadd", "x_payment_date", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_payment_payment_date">
<span<?= $Page->payment_date->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->payment_date->getDisplayValue($Page->payment_date->ViewValue))) ?>"></span>
<input type="hidden" data-table="payment" data-field="x_payment_date" data-hidden="1" name="x_payment_date" id="x_payment_date" value="<?= HtmlEncode($Page->payment_date->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_payment_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_payment_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="payment" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpaymentadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fpaymentadd", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_payment_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="payment" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpaymentadd" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fpaymentadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpaymentadd"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fpaymentadd" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("payment");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
