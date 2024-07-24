<?php

namespace PHPMaker2024\Sakila;

// Page object
$AddressDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { address: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var faddressdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("faddressdelete")
        .setPageId("delete")
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
<form name="faddressdelete" id="faddressdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="address">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->address_id->Visible) { // address_id ?>
        <th class="<?= $Page->address_id->headerCellClass() ?>"><span id="elh_address_address_id" class="address_address_id"><?= $Page->address_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><span id="elh_address_address" class="address_address"><?= $Page->address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address2->Visible) { // address2 ?>
        <th class="<?= $Page->address2->headerCellClass() ?>"><span id="elh_address_address2" class="address_address2"><?= $Page->address2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->district->Visible) { // district ?>
        <th class="<?= $Page->district->headerCellClass() ?>"><span id="elh_address_district" class="address_district"><?= $Page->district->caption() ?></span></th>
<?php } ?>
<?php if ($Page->city_id->Visible) { // city_id ?>
        <th class="<?= $Page->city_id->headerCellClass() ?>"><span id="elh_address_city_id" class="address_city_id"><?= $Page->city_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->postal_code->Visible) { // postal_code ?>
        <th class="<?= $Page->postal_code->headerCellClass() ?>"><span id="elh_address_postal_code" class="address_postal_code"><?= $Page->postal_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <th class="<?= $Page->phone->headerCellClass() ?>"><span id="elh_address_phone" class="address_phone"><?= $Page->phone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
        <th class="<?= $Page->location->headerCellClass() ?>"><span id="elh_address_location" class="address_location"><?= $Page->location->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <th class="<?= $Page->last_update->headerCellClass() ?>"><span id="elh_address_last_update" class="address_last_update"><?= $Page->last_update->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->address_id->Visible) { // address_id ?>
        <td<?= $Page->address_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->address_id->viewAttributes() ?>>
<?= $Page->address_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <td<?= $Page->address->cellAttributes() ?>>
<span id="">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->address2->Visible) { // address2 ?>
        <td<?= $Page->address2->cellAttributes() ?>>
<span id="">
<span<?= $Page->address2->viewAttributes() ?>>
<?= $Page->address2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->district->Visible) { // district ?>
        <td<?= $Page->district->cellAttributes() ?>>
<span id="">
<span<?= $Page->district->viewAttributes() ?>>
<?= $Page->district->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->city_id->Visible) { // city_id ?>
        <td<?= $Page->city_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->city_id->viewAttributes() ?>>
<?= $Page->city_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->postal_code->Visible) { // postal_code ?>
        <td<?= $Page->postal_code->cellAttributes() ?>>
<span id="">
<span<?= $Page->postal_code->viewAttributes() ?>>
<?= $Page->postal_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
        <td<?= $Page->phone->cellAttributes() ?>>
<span id="">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
        <td<?= $Page->location->cellAttributes() ?>>
<span id="">
<span<?= $Page->location->viewAttributes() ?>>
<?= $Page->location->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
        <td<?= $Page->last_update->cellAttributes() ?>>
<span id="">
<span<?= $Page->last_update->viewAttributes() ?>>
<?= $Page->last_update->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
