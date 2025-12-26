(function ($) {
  let sidebar = $(".bdt-sidebar");
  let custom_header = $(".bdt-custom-header");
  let custom_footer = $(".bdt-custom-footer");

  // page layout
  const page_layout = $("#eooten_page_layout");
  let page_layout_selected_data = page_layout.data("selected");
  if (
    page_layout_selected_data === "sidebar-right" ||
    page_layout_selected_data === "sidebar-left"
  ) {
    sidebar.show();
  } else {
    sidebar.hide();
  }
  $(page_layout).on("change", function () {
    const selected_page_layout = $(this).val();
    if (
      selected_page_layout === "sidebar-right" ||
      selected_page_layout === "sidebar-left"
    ) {
      sidebar.show();
    } else {
      sidebar.hide();
    }
  });

  // header layout
  const header_layout = $("#eooten_header_layout");
  let header_layout_selected_data = header_layout.data("selected");
  if (header_layout_selected_data === "custom") {
    custom_header.show();
  } else {
    custom_header.hide();
  }

  $(header_layout).on("change", function () {
    const selected_header_layout = $(this).val();
    if (selected_header_layout === "custom") {
      custom_header.show();
    } else {
      custom_header.hide();
    }
  });
  // footer widget
  const footer_widgets = $("#eooten_footer_widgets");
  let footer_widgets_selected_data = footer_widgets.data("selected");
  if (footer_widgets_selected_data === "custom") {
    custom_footer.show();
  } else {
    custom_footer.hide();
  }
  $(footer_widgets).on("change", function () {
    const selected_footer_widget = $(this).val();
    if (selected_footer_widget === "custom") {
      custom_footer.show();
    } else {
      custom_footer.hide();
    }
  });
})(jQuery);
