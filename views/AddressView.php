<?php

namespace PHPMaker2024\Sakila;

// Page object
$AddressView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<form name="faddressview" id="faddressview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { address: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var faddressview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("faddressview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="address">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->address_id->Visible) { // address_id ?>
    <tr id="r_address_id"<?= $Page->address_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_address_id"><?= $Page->address_id->caption() ?></span></td>
        <td data-name="address_id"<?= $Page->address_id->cellAttributes() ?>>
<span id="el_address_address_id">
<span<?= $Page->address_id->viewAttributes() ?>>
<?= $Page->address_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_address_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address2->Visible) { // address2 ?>
    <tr id="r_address2"<?= $Page->address2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_address2"><?= $Page->address2->caption() ?></span></td>
        <td data-name="address2"<?= $Page->address2->cellAttributes() ?>>
<span id="el_address_address2">
<span<?= $Page->address2->viewAttributes() ?>>
<?= $Page->address2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->district->Visible) { // district ?>
    <tr id="r_district"<?= $Page->district->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_district"><?= $Page->district->caption() ?></span></td>
        <td data-name="district"<?= $Page->district->cellAttributes() ?>>
<span id="el_address_district">
<span<?= $Page->district->viewAttributes() ?>>
<?= $Page->district->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->city_id->Visible) { // city_id ?>
    <tr id="r_city_id"<?= $Page->city_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_city_id"><?= $Page->city_id->caption() ?></span></td>
        <td data-name="city_id"<?= $Page->city_id->cellAttributes() ?>>
<span id="el_address_city_id">
<span<?= $Page->city_id->viewAttributes() ?>>
<?= $Page->city_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->postal_code->Visible) { // postal_code ?>
    <tr id="r_postal_code"<?= $Page->postal_code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_postal_code"><?= $Page->postal_code->caption() ?></span></td>
        <td data-name="postal_code"<?= $Page->postal_code->cellAttributes() ?>>
<span id="el_address_postal_code">
<span<?= $Page->postal_code->viewAttributes() ?>>
<?= $Page->postal_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <tr id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_phone"><?= $Page->phone->caption() ?></span></td>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<span id="el_address_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
    <tr id="r_location"<?= $Page->location->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_location"><?= $Page->location->caption() ?></span></td>
        <td data-name="location"<?= $Page->location->cellAttributes() ?>>
<span id="el_address_location">
<span<?= $Page->location->viewAttributes() ?>>
<?= $Page->location->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_address_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_address_last_update">
<span<?= $Page->last_update->viewAttributes() ?>>
<?= $Page->last_update->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
