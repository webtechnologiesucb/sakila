<?php

namespace PHPMaker2024\Sakila;

// Page object
$FilmActorView = &$Page;
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
<form name="ffilm_actorview" id="ffilm_actorview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { film_actor: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var ffilm_actorview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ffilm_actorview")
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
<input type="hidden" name="t" value="film_actor">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->actor_id->Visible) { // actor_id ?>
    <tr id="r_actor_id"<?= $Page->actor_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_actor_actor_id"><?= $Page->actor_id->caption() ?></span></td>
        <td data-name="actor_id"<?= $Page->actor_id->cellAttributes() ?>>
<span id="el_film_actor_actor_id">
<span<?= $Page->actor_id->viewAttributes() ?>>
<?= $Page->actor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->film_id->Visible) { // film_id ?>
    <tr id="r_film_id"<?= $Page->film_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_actor_film_id"><?= $Page->film_id->caption() ?></span></td>
        <td data-name="film_id"<?= $Page->film_id->cellAttributes() ?>>
<span id="el_film_actor_film_id">
<span<?= $Page->film_id->viewAttributes() ?>>
<?= $Page->film_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_update->Visible) { // last_update ?>
    <tr id="r_last_update"<?= $Page->last_update->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_film_actor_last_update"><?= $Page->last_update->caption() ?></span></td>
        <td data-name="last_update"<?= $Page->last_update->cellAttributes() ?>>
<span id="el_film_actor_last_update">
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
