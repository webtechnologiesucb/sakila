<?php

namespace PHPMaker2024\Sakila;

// Page object
$StaffEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fstaffedit" id="fstaffedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { staff: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fstaffedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstaffedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["staff_id", [fields.staff_id.visible && fields.staff_id.required ? ew.Validators.required(fields.staff_id.caption) : null], fields.staff_id.isInvalid],
            ["first_name", [fields.first_name.visible && fields.first_name.required ? ew.Validators.required(fields.first_name.caption) : null], fields.first_name.isInvalid],
            ["last_name", [fields.last_name.visible && fields.last_name.required ? ew.Validators.required(fields.last_name.caption) : null], fields.last_name.isInvalid],
            ["address_id", [fields.address_id.visible && fields.address_id.required ? ew.Validators.required(fields.address_id.caption) : null, ew.Validators.integer], fields.address_id.isInvalid],
            ["picture", [fields.picture.visible && fields.picture.required ? ew.Validators.fileRequired(fields.picture.caption) : null], fields.picture.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["store_id", [fields.store_id.visible && fields.store_id.required ? ew.Validators.required(fields.store_id.caption) : null, ew.Validators.integer], fields.store_id.isInvalid],
            ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
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
            "address_id": <?= $Page->address_id->toClientList($Page) ?>,
            "store_id": <?= $Page->store_id->toClientList($Page) ?>,
            "active": <?= $Page->active->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="staff">
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
<?php if ($Page->staff_id->Visible) { // staff_id ?>
    <div id="r_staff_id"<?= $Page->staff_id->rowAttributes() ?>>
        <label id="elh_staff_staff_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->staff_id->caption() ?><?= $Page->staff_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->staff_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->staff_id->getDisplayValue($Page->staff_id->EditValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x_staff_id" data-hidden="1" name="x_staff_id" id="x_staff_id" value="<?= HtmlEncode($Page->staff_id->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el_staff_staff_id">
<span<?= $Page->staff_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->staff_id->getDisplayValue($Page->staff_id->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x_staff_id" data-hidden="1" name="x_staff_id" id="x_staff_id" value="<?= HtmlEncode($Page->staff_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->first_name->Visible) { // first_name ?>
    <div id="r_first_name"<?= $Page->first_name->rowAttributes() ?>>
        <label id="elh_staff_first_name" for="x_first_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->first_name->caption() ?><?= $Page->first_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->first_name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_first_name">
<input type="<?= $Page->first_name->getInputTextType() ?>" name="x_first_name" id="x_first_name" data-table="staff" data-field="x_first_name" value="<?= $Page->first_name->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->first_name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->first_name->formatPattern()) ?>"<?= $Page->first_name->editAttributes() ?> aria-describedby="x_first_name_help">
<?= $Page->first_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->first_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_staff_first_name">
<span<?= $Page->first_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->first_name->getDisplayValue($Page->first_name->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x_first_name" data-hidden="1" name="x_first_name" id="x_first_name" value="<?= HtmlEncode($Page->first_name->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_name->Visible) { // last_name ?>
    <div id="r_last_name"<?= $Page->last_name->rowAttributes() ?>>
        <label id="elh_staff_last_name" for="x_last_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_name->caption() ?><?= $Page->last_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_last_name">
<input type="<?= $Page->last_name->getInputTextType() ?>" name="x_last_name" id="x_last_name" data-table="staff" data-field="x_last_name" value="<?= $Page->last_name->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->last_name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_name->formatPattern()) ?>"<?= $Page->last_name->editAttributes() ?> aria-describedby="x_last_name_help">
<?= $Page->last_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_staff_last_name">
<span<?= $Page->last_name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_name->getDisplayValue($Page->last_name->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x_last_name" data-hidden="1" name="x_last_name" id="x_last_name" value="<?= HtmlEncode($Page->last_name->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address_id->Visible) { // address_id ?>
    <div id="r_address_id"<?= $Page->address_id->rowAttributes() ?>>
        <label id="elh_staff_address_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address_id->caption() ?><?= $Page->address_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_address_id">
    <select
        id="x_address_id"
        name="x_address_id"
        class="form-control ew-select<?= $Page->address_id->isInvalidClass() ?>"
        data-select2-id="fstaffedit_x_address_id"
        data-table="staff"
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
loadjs.ready("fstaffedit", function() {
    var options = { name: "x_address_id", selectId: "fstaffedit_x_address_id" };
    if (fstaffedit.lists.address_id?.lookupOptions.length) {
        options.data = { id: "x_address_id", form: "fstaffedit" };
    } else {
        options.ajax = { id: "x_address_id", form: "fstaffedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.staff.fields.address_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_staff_address_id">
<span<?= $Page->address_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->address_id->getDisplayValue($Page->address_id->ViewValue) ?></span></span>
<input type="hidden" data-table="staff" data-field="x_address_id" data-hidden="1" name="x_address_id" id="x_address_id" value="<?= HtmlEncode($Page->address_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
    <div id="r_picture"<?= $Page->picture->rowAttributes() ?>>
        <label id="elh_staff_picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->picture->caption() ?><?= $Page->picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->picture->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_picture">
<div id="fd_x_picture" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_picture"
        name="x_picture"
        class="form-control ew-file-input"
        title="<?= $Page->picture->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="staff"
        data-field="x_picture"
        data-size="65535"
        data-accept-file-types="<?= $Page->picture->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->picture->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->picture->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_picture_help"
        <?= ($Page->picture->ReadOnly || $Page->picture->Disabled) ? " disabled" : "" ?>
        <?= $Page->picture->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->picture->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->picture->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_picture" id= "fn_x_picture" value="<?= $Page->picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="<?= (Post("fa_x_picture") == "0") ? "0" : "1" ?>">
<table id="ft_x_picture" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el_staff_picture">
<div id="fd_x_picture">
    <input
        type="file"
        id="x_picture"
        name="x_picture"
        class="form-control ew-file-input d-none"
        title="<?= $Page->picture->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="staff"
        data-field="x_picture"
        data-size="65535"
        data-accept-file-types="<?= $Page->picture->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->picture->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->picture->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_picture_help"
        <?= $Page->picture->editAttributes() ?>
    >
    <?= $Page->picture->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->picture->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_picture" id= "fn_x_picture" value="<?= $Page->picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="<?= (Post("fa_x_picture") == "0") ? "0" : "1" ?>">
<table id="ft_x_picture" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_staff__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="staff" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_staff__email">
<span<?= $Page->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->store_id->Visible) { // store_id ?>
    <div id="r_store_id"<?= $Page->store_id->rowAttributes() ?>>
        <label id="elh_staff_store_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->store_id->caption() ?><?= $Page->store_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->store_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_store_id">
    <select
        id="x_store_id"
        name="x_store_id"
        class="form-control ew-select<?= $Page->store_id->isInvalidClass() ?>"
        data-select2-id="fstaffedit_x_store_id"
        data-table="staff"
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
loadjs.ready("fstaffedit", function() {
    var options = { name: "x_store_id", selectId: "fstaffedit_x_store_id" };
    if (fstaffedit.lists.store_id?.lookupOptions.length) {
        options.data = { id: "x_store_id", form: "fstaffedit" };
    } else {
        options.ajax = { id: "x_store_id", form: "fstaffedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.staff.fields.store_id.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_staff_store_id">
<span<?= $Page->store_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->store_id->getDisplayValue($Page->store_id->ViewValue) ?></span></span>
<input type="hidden" data-table="staff" data-field="x_store_id" data-hidden="1" name="x_store_id" id="x_store_id" value="<?= HtmlEncode($Page->store_id->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active"<?= $Page->active->rowAttributes() ?>>
        <label id="elh_staff_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->active->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_active">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->active->isInvalidClass() ?>" data-table="staff" data-field="x_active" data-boolean name="x_active" id="x_active" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
    <div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</div>
<?= $Page->active->getCustomMessage() ?>
</span>
<?php } else { ?>
<span id="el_staff_active">
<span<?= $Page->active->viewAttributes() ?>>
<i class="fa-regular fa-square<?php if (ConvertToBool($Page->active->CurrentValue)) { ?>-check<?php } ?> ew-icon ew-boolean"></i>
</span>
<input type="hidden" data-table="staff" data-field="x_active" data-hidden="1" name="x_active" id="x_active" value="<?= HtmlEncode($Page->active->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_staff__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="staff" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="16" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_username->formatPattern()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_staff__username">
<span<?= $Page->_username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_username->getDisplayValue($Page->_username->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_staff__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-table="staff" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_staff__password">
<span<?= $Page->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_password->getDisplayValue($Page->_password->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x__password" data-hidden="1" name="x__password" id="x__password" value="<?= HtmlEncode($Page->_password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <div id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <label id="elh_staff_last_update" for="x_last_update" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_update->caption() ?><?= $Page->last_update->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->last_update->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_staff_last_update">
<input type="<?= $Page->last_update->getInputTextType() ?>" name="x_last_update" id="x_last_update" data-table="staff" data-field="x_last_update" value="<?= $Page->last_update->EditValue ?>" placeholder="<?= HtmlEncode($Page->last_update->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->last_update->formatPattern()) ?>"<?= $Page->last_update->editAttributes() ?> aria-describedby="x_last_update_help">
<?= $Page->last_update->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_update->getErrorMessage() ?></div>
<?php if (!$Page->last_update->ReadOnly && !$Page->last_update->Disabled && !isset($Page->last_update->EditAttrs["readonly"]) && !isset($Page->last_update->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstaffedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fstaffedit", "x_last_update", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_staff_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->last_update->getDisplayValue($Page->last_update->ViewValue))) ?>"></span>
<input type="hidden" data-table="staff" data-field="x_last_update" data-hidden="1" name="x_last_update" id="x_last_update" value="<?= HtmlEncode($Page->last_update->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstaffedit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" form="fstaffedit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstaffedit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstaffedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstaffedit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fstaffedit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("staff");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
