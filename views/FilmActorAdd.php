<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmActorAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film_actor: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var ffilm_actoradd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilm_actoradd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["actor_id", [fields.actor_id.visible && fields.actor_id.required ? ew.Validators.required(fields.actor_id.caption) : null, ew.Validators.integer], fields.actor_id.isInvalid],
            ["film_id", [fields.film_id.visible && fields.film_id.required ? ew.Validators.required(fields.film_id.caption) : null, ew.Validators.integer], fields.film_id.isInvalid],
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
            "actor_id": <?= $Page->actor_id->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffilm_actoradd" id="ffilm_actoradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="film_actor">
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
<?php if ($Page->actor_id->Visible) { // actor_id ?>
    <div id="r_actor_id"<?= $Page->actor_id->rowAttributes() ?>>
        <label id="elh_film_actor_actor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->actor_id->caption() ?><?= $Page->actor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->actor_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_actor_actor_id">
    <select
        id="x_actor_id"
        name="x_actor_id"
        class="form-control ew-select<?= $Page->actor_id->isInvalidClass() ?>"
        data-select2-id="ffilm_actoradd_x_actor_id"
        data-table="film_actor"
        data-field="x_actor_id"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->actor_id->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->actor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->actor_id->getPlaceHolder()) ?>"
        <?= $Page->actor_id->editAttributes() ?>>
        <?= $Page->actor_id->selectOptionListHtml("x_actor_id") ?>
    </select>
    <?= $Page->actor_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->actor_id->getErrorMessage() ?></div>
<?= $Page->actor_id->Lookup->getParamTag($Page, "p_x_actor_id") ?>
<script>
loadjs.ready("ffilm_actoradd", function() {
    var options = { name: "x_actor_id", selectId: "ffilm_actoradd_x_actor_id" };
    if (ffilm_actoradd.lists.actor_id?.lookupOptions.length) {
        options.data = { id: "x_actor_id", form: "ffilm_actoradd" };
    } else {
        options.ajax = { id: "x_actor_id", form: "ffilm_actoradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film_actor.fields.actor_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_film_actor_actor_id">
<span<?= $Page->actor_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->actor_id->getDisplayValue($Page->actor_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film_actor" data-field="x_actor_id" data-hidden="1" name="x_actor_id" id="x_actor_id" value="<?= HtmlEncode($Page->actor_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->film_id->Visible) { // film_id ?>
    <div id="r_film_id"<?= $Page->film_id->rowAttributes() ?>>
        <label id="elh_film_actor_film_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->film_id->caption() ?><?= $Page->film_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->film_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_actor_film_id">
    <select
        id="x_film_id"
        name="x_film_id"
        class="form-control ew-select<?= $Page->film_id->isInvalidClass() ?>"
        data-select2-id="ffilm_actoradd_x_film_id"
        data-table="film_actor"
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
loadjs.ready("ffilm_actoradd", function() {
    var options = { name: "x_film_id", selectId: "ffilm_actoradd_x_film_id" };
    if (ffilm_actoradd.lists.film_id?.lookupOptions.length) {
        options.data = { id: "x_film_id", form: "ffilm_actoradd" };
    } else {
        options.ajax = { id: "x_film_id", form: "ffilm_actoradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.film_actor.fields.film_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_film_actor_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->film_id->getDisplayValue($Page->film_id->ViewValue) ?></span></span>
<input type="hidden" data-table="film_actor" data-field="x_film_id" data-hidden="1" name="x_film_id" id="x_film_id" value="<?= HtmlEncode($Page->film_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_film_actor_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_film_actor_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="film_actor" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffilm_actoradd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffilm_actoradd", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_film_actor_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="film_actor" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_actoradd" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ffilm_actoradd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ffilm_actoradd"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="ffilm_actoradd" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("film_actor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
