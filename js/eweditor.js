/**
 * Create HTML Editor (for Sakila 2024)
 * @license Copyright (c) SakilaSoft. All rights reserved.
 */
CKEDITOR.env.cssClass = "ew-editor";
ew.ckeditorSettings = {};
ew.createEditor = function (formid, name, cols, rows, readonly) {
  if (typeof CKEDITOR == "undefined" || name.includes("$rowindex$")) return;
  let form = document.getElementById(formid),
    el = ew.getElement(name, form);
  if (!el) return;
  let $ = jQuery,
    settings = Object.assign({}, ew.ckeditorSettings, {
      language: (ew.LANGUAGE_ID || "").toLowerCase(),
      height: ((rows ? Math.abs(rows) : 4) + 4) * 1.5 + "em",
      autoUpdateElement: false,
      baseHref: "",
      removeButtons: "Save",
    });
  if (ew.isDark()) settings.skin = "moono-dark";
  let args = { id: name, enabled: true, form: form, settings: settings };
  $(document).trigger("create.editor", [args]);
  if (!args.enabled) return;
  if (readonly) {
    args.settings.readOnly = true;
    args.settings.toolbar = [["Source"]];
  }
  let editor = {
    name: name,
    active: false,
    instance: null,
    create: function () {
      this.instance = CKEDITOR.replace(el, args.settings);
      this.instance.on("loaded", ew.fixLayoutHeight);
      this.active = true;
    },
    set: function () {
      this.instance?.setData(this.instance.element.value);
    },
    save: function () {
      this.instance?.updateElement();
      let args = { id: name, form: form, value: ew.removeSpaces(el.value) };
      $(document).trigger("save.editor", [args]).val(args.value);
    },
    focus: function () {
      this.instance?.focus();
    },
    destroy: function () {
      this.instance?.destroy();
    },
  };
  $(el).data("editor", editor).addClass("editor");
};
