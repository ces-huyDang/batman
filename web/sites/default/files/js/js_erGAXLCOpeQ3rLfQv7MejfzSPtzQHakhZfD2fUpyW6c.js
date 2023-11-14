/**
 * @file
 * Media Library overrides for Claro
 */
(($, Drupal, window) => {
  /**
   * Update the media library selection when loaded or media items are selected.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to select media items.
   */
  Drupal.behaviors.MediaLibraryItemSelectionClaro = {
    attach() {
      // Move the selection count to the beginning of the button pane after it
      // has been added to the Media Library dialog.
      // @todo replace with theme function override in
      //   https://drupal.org/node/3134526
      if (!once('media-library-selection-info-claro-event', 'html').length) {
        return;
      }
      $(window).on(
        'dialog:aftercreate',
        (event, dialog, $element, settings) => {
          // Since the dialog HTML is not part of the context, we can't use
          // context here.
          const moveCounter = ($selectedCount, $buttonPane) => {
            const $moveSelectedCount = $selectedCount.detach();
            $buttonPane.prepend($moveSelectedCount);
          };

          const $buttonPane = $element
            .closest('.media-library-widget-modal')
            .find('.ui-dialog-buttonpane');
          if (!$buttonPane.length) {
            return;
          }
          const $selectedCount = $buttonPane.find(
            '.js-media-library-selected-count',
          );

          // If the `selected` counter is already present, it can be moved from
          // the end of the button pane to the beginning.
          if ($selectedCount.length) {
            moveCounter($selectedCount, $buttonPane);
          } else {
            // If the `selected` counter is not yet present, create a mutation
            // observer that checks for items added to the button pane. As soon
            // as the counter is added, move it from the end of the button pane
            // to the beginning.
            const selectedCountObserver = new MutationObserver(() => {
              const $selectedCountFind = $buttonPane.find(
                '.js-media-library-selected-count',
              );
              if ($selectedCountFind.length) {
                moveCounter($selectedCountFind, $buttonPane);
                selectedCountObserver.disconnect();
              }
            });
            selectedCountObserver.observe($buttonPane[0], {
              attributes: false,
              childList: true,
              characterData: false,
              subtree: true,
            });
          }
        },
      );
    },
  };
})(jQuery, Drupal, window);
;
/**
 * @file
 * Defines checkbox theme functions.
 */

((Drupal) => {
  /**
   * Theme function for a checkbox.
   *
   * @return {string}
   *   The HTML markup for the checkbox.
   */
  Drupal.theme.checkbox = () =>
    `<input type="checkbox" class="form-checkbox"/>`;
})(Drupal);
;
/**
 * @file
 * Theme override for checkbox.
 */

((Drupal) => {
  /**
   * Constructs a checkbox input element.
   *
   * @return {string}
   *   A string representing a DOM fragment.
   */
  Drupal.theme.checkbox = () =>
    '<input type="checkbox" class="form-checkbox form-boolean form-boolean--type-checkbox"/>';
})(Drupal);
;
/**
 * @file media_library.click_to_select.js
 */

(($, Drupal) => {
  /**
   * Allows users to select an element which checks a hidden checkbox.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior for selecting media library item.
   */
  Drupal.behaviors.ClickToSelect = {
    attach(context) {
      $(
        once(
          'media-library-click-to-select',
          '.js-click-to-select-trigger',
          context,
        ),
      ).on('click', (event) => {
        // Links inside the trigger should not be click-able.
        event.preventDefault();
        // Click the hidden checkbox when the trigger is clicked.
        const $input = $(event.currentTarget)
          .closest('.js-click-to-select')
          .find('.js-click-to-select-checkbox input');
        $input.prop('checked', !$input.prop('checked')).trigger('change');
      });

      $(
        once(
          'media-library-click-to-select',
          '.js-click-to-select-checkbox input',
          context,
        ),
      )
        .on('change', ({ currentTarget }) => {
          $(currentTarget)
            .closest('.js-click-to-select')
            .toggleClass('checked', $(currentTarget).prop('checked'));
        })
        // Adds is-focus class to the click-to-select element.
        .on('focus blur', ({ currentTarget, type }) => {
          $(currentTarget)
            .closest('.js-click-to-select')
            .toggleClass('is-focus', type === 'focus');
        });

      // Adds hover class to the click-to-select element.
      $(
        once(
          'media-library-click-to-select-hover',
          '.js-click-to-select-trigger, .js-click-to-select-checkbox',
          context,
        ),
      ).on('mouseover mouseout', ({ currentTarget, type }) => {
        $(currentTarget)
          .closest('.js-click-to-select')
          .toggleClass('is-hover', type === 'mouseover');
      });
    },
  };
})(jQuery, Drupal);
;
/**
 * @file media_library.view.js
 */
(($, Drupal) => {
  /**
   * Adds checkbox to select all items in the library.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to select all media items.
   */
  Drupal.behaviors.MediaLibrarySelectAll = {
    attach(context) {
      const $view = $(
        once(
          'media-library-select-all',
          '.js-media-library-view[data-view-display-id="page"]',
          context,
        ),
      );
      if ($view.length && $view.find('.js-media-library-item').length) {
        const $checkbox = $(Drupal.theme('checkbox')).on(
          'click',
          ({ currentTarget }) => {
            // Toggle all checkboxes.
            const $checkboxes = $(currentTarget)
              .closest('.js-media-library-view')
              .find('.js-media-library-item input[type="checkbox"]');
            $checkboxes
              .prop('checked', $(currentTarget).prop('checked'))
              .trigger('change');
            // Announce the selection.
            const announcement = $(currentTarget).prop('checked')
              ? Drupal.t('All @count items selected', {
                  '@count': $checkboxes.length,
                })
              : Drupal.t('Zero items selected');
            Drupal.announce(announcement);
          },
        );
        const $label = $('<label class="media-library-select-all"></label>');
        $label[0].textContent = Drupal.t('Select all media');
        $label.prepend($checkbox);
        $view.find('.js-media-library-item').first().before($label);
      }
    },
  };
})(jQuery, Drupal);
;
/**
 * @file media_library.ui.js
 */
(($, Drupal, window, { tabbable }) => {
  /**
   * Wrapper object for the current state of the media library.
   */
  Drupal.MediaLibrary = {
    /**
     * When a user interacts with the media library we want the selection to
     * persist as long as the media library modal is opened. We temporarily
     * store the selected items while the user filters the media library view or
     * navigates to different tabs.
     */
    currentSelection: [],
  };

  /**
   * Command to update the current media library selection.
   *
   * @param {Drupal.Ajax} [ajax]
   *   The Drupal Ajax object.
   * @param {object} response
   *   Object holding the server response.
   * @param {number} [status]
   *   The HTTP status code.
   */
  Drupal.AjaxCommands.prototype.updateMediaLibrarySelection = function (
    ajax,
    response,
    status,
  ) {
    Object.values(response.mediaIds).forEach((value) => {
      Drupal.MediaLibrary.currentSelection.push(value);
    });
  };

  /**
   * Load media library content through AJAX.
   *
   * Standard AJAX links (using the 'use-ajax' class) replace the entire library
   * dialog. When navigating to a media type through the vertical tabs, we only
   * want to load the changed library content. This is not only more efficient,
   * but also provides a more accessible user experience for screen readers.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to vertical tabs in the media library.
   *
   * @todo Remove when the AJAX system adds support for replacing a specific
   *   selector via a link.
   *   https://www.drupal.org/project/drupal/issues/3026636
   */
  Drupal.behaviors.MediaLibraryTabs = {
    attach(context) {
      const $menu = $('.js-media-library-menu');
      $(once('media-library-menu-item', $menu.find('a')))
        .on('keypress', (e) => {
          // The AJAX link has the button role, so we need to make sure the link
          // is also triggered when pressing the spacebar.
          if (e.which === 32) {
            e.preventDefault();
            e.stopPropagation();
            $(e.currentTarget).trigger('click');
          }
        })
        .on('click', (e) => {
          e.preventDefault();
          e.stopPropagation();

          // Replace the library content.
          const ajaxObject = Drupal.ajax({
            wrapper: 'media-library-content',
            url: e.currentTarget.href,
            dialogType: 'ajax',
            progress: {
              type: 'fullscreen',
              message: Drupal.t('Please wait...'),
            },
          });

          // Override the AJAX success callback to shift focus to the media
          // library content.
          ajaxObject.success = function (response, status) {
            return Promise.resolve(
              Drupal.Ajax.prototype.success.call(ajaxObject, response, status),
            ).then(() => {
              // Set focus to the first tabbable element in the media library
              // content.
              const mediaLibraryContent = document.getElementById(
                'media-library-content',
              );
              if (mediaLibraryContent) {
                const tabbableContent = tabbable(mediaLibraryContent);
                if (tabbableContent.length) {
                  tabbableContent[0].focus();
                }
              }
            });
          };
          ajaxObject.execute();

          // Set the selected tab.
          $menu.find('.active-tab').remove();
          $menu.find('a').removeClass('active');
          $(e.currentTarget)
            .addClass('active')
            .html(
              Drupal.t(
                '<span class="visually-hidden">Show </span>@title<span class="visually-hidden"> media</span><span class="active-tab visually-hidden"> (selected)</span>',
                { '@title': $(e.currentTarget).data('title') },
              ),
            );

          // Announce the updated content.
          Drupal.announce(
            Drupal.t('Showing @title media.', {
              '@title': $(e.currentTarget).data('title'),
            }),
          );
        });
    },
  };

  /**
   * Load media library displays through AJAX.
   *
   * Standard AJAX links (using the 'use-ajax' class) replace the entire library
   * dialog. When navigating to a media library views display, we only want to
   * load the changed views display content. This is not only more efficient,
   * but also provides a more accessible user experience for screen readers.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to vertical tabs in the media library.
   *
   * @todo Remove when the AJAX system adds support for replacing a specific
   *   selector via a link.
   *   https://www.drupal.org/project/drupal/issues/3026636
   */
  Drupal.behaviors.MediaLibraryViewsDisplay = {
    attach(context) {
      const $view = $(context).hasClass('.js-media-library-view')
        ? $(context)
        : $('.js-media-library-view', context);

      // Add a class to the view to allow it to be replaced via AJAX.
      // @todo Remove the custom ID when the AJAX system allows replacing
      //    elements by selector.
      //    https://www.drupal.org/project/drupal/issues/2821793
      $view
        .closest('.views-element-container')
        .attr('id', 'media-library-view');

      // We would ideally use a generic JavaScript specific class to detect the
      // display links. Since we have no good way of altering display links yet,
      // this is the best we can do for now.
      // @todo Add media library specific classes and data attributes to the
      //    media library display links when we can alter display links.
      //    https://www.drupal.org/project/drupal/issues/3036694
      $(
        once(
          'media-library-views-display-link',
          '.views-display-link-widget, .views-display-link-widget_table',
          context,
        ),
      ).on('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const $link = $(e.currentTarget);

        // Add a loading and display announcement for screen reader users.
        let loadingAnnouncement = '';
        let displayAnnouncement = '';
        let focusSelector = '';
        if ($link.hasClass('views-display-link-widget')) {
          loadingAnnouncement = Drupal.t('Loading grid view.');
          displayAnnouncement = Drupal.t('Changed to grid view.');
          focusSelector = '.views-display-link-widget';
        } else if ($link.hasClass('views-display-link-widget_table')) {
          loadingAnnouncement = Drupal.t('Loading table view.');
          displayAnnouncement = Drupal.t('Changed to table view.');
          focusSelector = '.views-display-link-widget_table';
        }

        // Replace the library view.
        const ajaxObject = Drupal.ajax({
          wrapper: 'media-library-view',
          url: e.currentTarget.href,
          dialogType: 'ajax',
          progress: {
            type: 'fullscreen',
            message: loadingAnnouncement || Drupal.t('Please wait...'),
          },
        });

        // Override the AJAX success callback to announce the updated content
        // to screen readers.
        if (displayAnnouncement || focusSelector) {
          const success = ajaxObject.success;
          ajaxObject.success = function (response, status) {
            success.bind(this)(response, status);
            // The AJAX link replaces the whole view, including the clicked
            // link. Move the focus back to the clicked link when the view is
            // replaced.
            if (focusSelector) {
              $(focusSelector).focus();
            }
            // Announce the new view is loaded to screen readers.
            if (displayAnnouncement) {
              Drupal.announce(displayAnnouncement);
            }
          };
        }

        ajaxObject.execute();

        // Announce the new view is being loaded to screen readers.
        // @todo Replace custom announcement when
        //   https://www.drupal.org/project/drupal/issues/2973140 is in.
        if (loadingAnnouncement) {
          Drupal.announce(loadingAnnouncement);
        }
      });
    },
  };

  /**
   * Update the media library selection when loaded or media items are selected.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to select media items.
   */
  Drupal.behaviors.MediaLibraryItemSelection = {
    attach(context, settings) {
      const $form = $(
        '.js-media-library-views-form, .js-media-library-add-form',
        context,
      );
      const currentSelection = Drupal.MediaLibrary.currentSelection;

      if (!$form.length) {
        return;
      }

      const $mediaItems = $(
        '.js-media-library-item input[type="checkbox"]',
        $form,
      );

      /**
       * Disable media items.
       *
       * @param {jQuery} $items
       *   A jQuery object representing the media items that should be disabled.
       */
      function disableItems($items) {
        $items
          .prop('disabled', true)
          .closest('.js-media-library-item')
          .addClass('media-library-item--disabled');
      }

      /**
       * Enable media items.
       *
       * @param {jQuery} $items
       *   A jQuery object representing the media items that should be enabled.
       */
      function enableItems($items) {
        $items
          .prop('disabled', false)
          .closest('.js-media-library-item')
          .removeClass('media-library-item--disabled');
      }

      /**
       * Update the number of selected items in the button pane.
       *
       * @param {number} remaining
       *   The number of remaining slots.
       */
      function updateSelectionCount(remaining) {
        // When the remaining number of items is a negative number, we allow an
        // unlimited number of items. In that case we don't want to show the
        // number of remaining slots.
        const selectItemsText =
          remaining < 0
            ? Drupal.formatPlural(
                currentSelection.length,
                '1 item selected',
                '@count items selected',
              )
            : Drupal.formatPlural(
                remaining,
                '@selected of @count item selected',
                '@selected of @count items selected',
                {
                  '@selected': currentSelection.length,
                },
              );
        // The selected count div could have been created outside of the
        // context, so we unfortunately can't use context here.
        $('.js-media-library-selected-count').html(selectItemsText);
      }

      // Update the selection array and the hidden form field when a media item
      // is selected.
      $(once('media-item-change', $mediaItems)).on('change', (e) => {
        const id = e.currentTarget.value;

        // Update the selection.
        const position = currentSelection.indexOf(id);
        if (e.currentTarget.checked) {
          // Check if the ID is not already in the selection and add if needed.
          if (position === -1) {
            currentSelection.push(id);
          }
        } else if (position !== -1) {
          // Remove the ID when it is in the current selection.
          currentSelection.splice(position, 1);
        }

        const mediaLibraryModalSelection = document.querySelector(
          '#media-library-modal-selection',
        );

        if (mediaLibraryModalSelection) {
          // Set the selection in the hidden form element.
          mediaLibraryModalSelection.value = currentSelection.join();
          $(mediaLibraryModalSelection).trigger('change');
        }

        // Set the selection in the media library add form. Since the form is
        // not necessarily loaded within the same context, we can't use the
        // context here.
        document
          .querySelectorAll('.js-media-library-add-form-current-selection')
          .forEach((item) => {
            item.value = currentSelection.join();
          });
      });

      // The hidden selection form field changes when the selection is updated.
      $(
        once(
          'media-library-selection-change',
          $form.find('#media-library-modal-selection'),
        ),
      ).on('change', (e) => {
        updateSelectionCount(settings.media_library.selection_remaining);

        // Prevent users from selecting more items than allowed.
        if (
          currentSelection.length === settings.media_library.selection_remaining
        ) {
          disableItems($mediaItems.not(':checked'));
          enableItems($mediaItems.filter(':checked'));
        } else {
          enableItems($mediaItems);
        }
      });

      // Apply the current selection to the media library view. Changing the
      // checkbox values triggers the change event for the media items. The
      // change event handles updating the hidden selection field for the form.
      currentSelection.forEach((value) => {
        $form
          .find(`input[type="checkbox"][value="${value}"]`)
          .prop('checked', true)
          .trigger('change');
      });

      // Add the selection count to the button pane when a media library dialog
      // is created.
      if (!once('media-library-selection-info', 'html').length) {
        return;
      }
      $(window).on('dialog:aftercreate', () => {
        // Since the dialog HTML is not part of the context, we can't use
        // context here.
        const $buttonPane = $(
          '.media-library-widget-modal .ui-dialog-buttonpane',
        );
        if (!$buttonPane.length) {
          return;
        }
        $buttonPane.append(Drupal.theme('mediaLibrarySelectionCount'));
        updateSelectionCount(settings.media_library.selection_remaining);
      });
    },
  };

  /**
   * Clear the current selection.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches behavior to clear the selection when the library modal closes.
   */
  Drupal.behaviors.MediaLibraryModalClearSelection = {
    attach() {
      if (!once('media-library-clear-selection', 'html').length) {
        return;
      }
      $(window).on('dialog:afterclose', () => {
        Drupal.MediaLibrary.currentSelection = [];
      });
    },
  };

  /**
   * Theme function for the selection count.
   *
   * @return {string}
   *   The corresponding HTML.
   */
  Drupal.theme.mediaLibrarySelectionCount = function () {
    return `<div class="media-library-selected-count js-media-library-selected-count" role="status" aria-live="polite" aria-atomic="true"></div>`;
  };
})(jQuery, Drupal, window, window.tabbable);
;
/**
 * @file
 * Some basic behaviors and utility functions for Views.
 */

(function ($, Drupal, drupalSettings) {
  /**
   * @namespace
   */
  Drupal.Views = {};

  /**
   * Helper function to parse a querystring.
   *
   * @param {string} query
   *   The querystring to parse.
   *
   * @return {object}
   *   A map of query parameters.
   */
  Drupal.Views.parseQueryString = function (query) {
    const args = {};
    const pos = query.indexOf('?');
    if (pos !== -1) {
      query = query.substring(pos + 1);
    }
    let pair;
    const pairs = query.split('&');
    for (let i = 0; i < pairs.length; i++) {
      pair = pairs[i].split('=');
      // Ignore the 'q' path argument, if present.
      if (pair[0] !== 'q' && pair[1]) {
        args[decodeURIComponent(pair[0].replace(/\+/g, ' '))] =
          decodeURIComponent(pair[1].replace(/\+/g, ' '));
      }
    }
    return args;
  };

  /**
   * Helper function to return a view's arguments based on a path.
   *
   * @param {string} href
   *   The href to check.
   * @param {string} viewPath
   *   The views path to check.
   *
   * @return {object}
   *   An object containing `view_args` and `view_path`.
   */
  Drupal.Views.parseViewArgs = function (href, viewPath) {
    const returnObj = {};
    const path = Drupal.Views.getPath(href);
    // Get viewPath url without baseUrl portion.
    const viewHref = Drupal.url(viewPath).substring(
      drupalSettings.path.baseUrl.length,
    );
    // Ensure we have a correct path.
    if (viewHref && path.substring(0, viewHref.length + 1) === `${viewHref}/`) {
      returnObj.view_args = decodeURIComponent(
        path.substring(viewHref.length + 1, path.length),
      );
      returnObj.view_path = path;
    }
    return returnObj;
  };

  /**
   * Strip off the protocol plus domain from an href.
   *
   * @param {string} href
   *   The href to strip.
   *
   * @return {string}
   *   The href without the protocol and domain.
   */
  Drupal.Views.pathPortion = function (href) {
    // Remove e.g. http://example.com if present.
    const protocol = window.location.protocol;
    if (href.substring(0, protocol.length) === protocol) {
      // 2 is the length of the '//' that normally follows the protocol.
      href = href.substring(href.indexOf('/', protocol.length + 2));
    }
    return href;
  };

  /**
   * Return the Drupal path portion of an href.
   *
   * @param {string} href
   *   The href to check.
   *
   * @return {string}
   *   An internal path.
   */
  Drupal.Views.getPath = function (href) {
    href = Drupal.Views.pathPortion(href);
    href = href.substring(drupalSettings.path.baseUrl.length, href.length);
    // 3 is the length of the '?q=' added to the url without clean urls.
    if (href.substring(0, 3) === '?q=') {
      href = href.substring(3, href.length);
    }
    const chars = ['#', '?', '&'];
    for (let i = 0; i < chars.length; i++) {
      if (href.indexOf(chars[i]) > -1) {
        href = href.substr(0, href.indexOf(chars[i]));
      }
    }
    return href;
  };
})(jQuery, Drupal, drupalSettings);
;
/**
 * @file
 * Handles AJAX fetching of views, including filter submission and response.
 */

(function ($, Drupal, drupalSettings) {
  /**
   * Attaches the AJAX behavior to exposed filters forms and key View links.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches ajaxView functionality to relevant elements.
   */
  Drupal.behaviors.ViewsAjaxView = {};
  Drupal.behaviors.ViewsAjaxView.attach = function (context, settings) {
    if (settings && settings.views && settings.views.ajaxViews) {
      const {
        views: { ajaxViews },
      } = settings;
      Object.keys(ajaxViews || {}).forEach((i) => {
        Drupal.views.instances[i] = new Drupal.views.ajaxView(ajaxViews[i]);
      });
    }
  };
  Drupal.behaviors.ViewsAjaxView.detach = (context, settings, trigger) => {
    if (trigger === 'unload') {
      if (settings && settings.views && settings.views.ajaxViews) {
        const {
          views: { ajaxViews },
        } = settings;
        Object.keys(ajaxViews || {}).forEach((i) => {
          const selector = `.js-view-dom-id-${ajaxViews[i].view_dom_id}`;
          if ($(selector, context).length) {
            delete Drupal.views.instances[i];
            delete settings.views.ajaxViews[i];
          }
        });
      }
    }
  };

  /**
   * @namespace
   */
  Drupal.views = {};

  /**
   * @type {object.<string, Drupal.views.ajaxView>}
   */
  Drupal.views.instances = {};

  /**
   * JavaScript object for a certain view.
   *
   * @constructor
   *
   * @param {object} settings
   *   Settings object for the ajax view.
   * @param {string} settings.view_dom_id
   *   The DOM id of the view.
   */
  Drupal.views.ajaxView = function (settings) {
    const selector = `.js-view-dom-id-${settings.view_dom_id}`;
    this.$view = $(selector);

    // Retrieve the path to use for views' ajax.
    let ajaxPath = drupalSettings.views.ajax_path;

    // If there are multiple views this might've ended up showing up multiple
    // times.
    if (ajaxPath.constructor.toString().indexOf('Array') !== -1) {
      ajaxPath = ajaxPath[0];
    }

    // Check if there are any GET parameters to send to views.
    let queryString = window.location.search || '';
    if (queryString !== '') {
      // Remove the question mark and Drupal path component if any.
      queryString = queryString
        .slice(1)
        .replace(/q=[^&]+&?|&?render=[^&]+/, '');
      if (queryString !== '') {
        // If there is a '?' in ajaxPath, clean url are on and & should be
        // used to add parameters.
        queryString = (/\?/.test(ajaxPath) ? '&' : '?') + queryString;
      }
    }

    this.element_settings = {
      url: ajaxPath + queryString,
      submit: settings,
      setClick: true,
      event: 'click',
      selector,
      progress: { type: 'fullscreen' },
    };

    this.settings = settings;

    // Add the ajax to exposed forms.
    this.$exposed_form = $(
      `form#views-exposed-form-${settings.view_name.replace(
        /_/g,
        '-',
      )}-${settings.view_display_id.replace(/_/g, '-')}`,
    );
    once('exposed-form', this.$exposed_form).forEach(
      $.proxy(this.attachExposedFormAjax, this),
    );

    // Add the ajax to pagers.
    once(
      'ajax-pager',
      this.$view
        // Don't attach to nested views. Doing so would attach multiple behaviors
        // to a given element.
        .filter($.proxy(this.filterNestedViews, this)),
    ).forEach($.proxy(this.attachPagerAjax, this));

    // Add a trigger to update this view specifically. In order to trigger a
    // refresh use the following code.
    //
    // @code
    // $('.view-name').trigger('RefreshView');
    // @endcode
    const selfSettings = $.extend({}, this.element_settings, {
      event: 'RefreshView',
      base: this.selector,
      element: this.$view.get(0),
    });
    this.refreshViewAjax = Drupal.ajax(selfSettings);
  };

  /**
   * @method
   */
  Drupal.views.ajaxView.prototype.attachExposedFormAjax = function () {
    const that = this;
    this.exposedFormAjax = [];
    // Exclude the reset buttons so no AJAX behaviors are bound. Many things
    // break during the form reset phase if using AJAX.
    $(
      'input[type=submit], button[type=submit], input[type=image]',
      this.$exposed_form,
    )
      .not('[data-drupal-selector=edit-reset]')
      .each(function (index) {
        const selfSettings = $.extend({}, that.element_settings, {
          base: $(this).attr('id'),
          element: this,
        });
        that.exposedFormAjax[index] = Drupal.ajax(selfSettings);
      });
  };

  /**
   * @return {boolean}
   *   If there is at least one parent with a view class return false.
   */
  Drupal.views.ajaxView.prototype.filterNestedViews = function () {
    // If there is at least one parent with a view class, this view
    // is nested (e.g., an attachment). Bail.
    return !this.$view.parents('.view').length;
  };

  /**
   * Attach the ajax behavior to each link.
   */
  Drupal.views.ajaxView.prototype.attachPagerAjax = function () {
    this.$view
      .find(
        'ul.js-pager__items > li > a, th.views-field a, .attachment .views-summary a',
      )
      .each($.proxy(this.attachPagerLinkAjax, this));
  };

  /**
   * Attach the ajax behavior to a singe link.
   *
   * @param {string} [id]
   *   The ID of the link.
   * @param {HTMLElement} link
   *   The link element.
   */
  Drupal.views.ajaxView.prototype.attachPagerLinkAjax = function (id, link) {
    const $link = $(link);
    const viewData = {};
    const href = $link.attr('href');
    // Construct an object using the settings defaults and then overriding
    // with data specific to the link.
    $.extend(
      viewData,
      this.settings,
      Drupal.Views.parseQueryString(href),
      // Extract argument data from the URL.
      Drupal.Views.parseViewArgs(href, this.settings.view_base_path),
    );

    const selfSettings = $.extend({}, this.element_settings, {
      submit: viewData,
      base: false,
      element: link,
    });
    this.pagerAjax = Drupal.ajax(selfSettings);
  };

  /**
   * Views scroll to top ajax command.
   *
   * @param {Drupal.Ajax} [ajax]
   *   A {@link Drupal.ajax} object.
   * @param {object} response
   *   Ajax response.
   * @param {string} response.selector
   *   Selector to use.
   */
  Drupal.AjaxCommands.prototype.viewsScrollTop = function (ajax, response) {
    // Scroll to the top of the view. This will allow users
    // to browse newly loaded content after e.g. clicking a pager
    // link.
    const offset = $(response.selector).offset();
    // We can't guarantee that the scrollable object should be
    // the body, as the view could be embedded in something
    // more complex such as a modal popup. Recurse up the DOM
    // and scroll the first element that has a non-zero top.
    let scrollTarget = response.selector;
    while ($(scrollTarget).scrollTop() === 0 && $(scrollTarget).parent()) {
      scrollTarget = $(scrollTarget).parent();
    }
    // Only scroll upward.
    if (offset.top - 10 < $(scrollTarget).scrollTop()) {
      $(scrollTarget).animate({ scrollTop: offset.top - 10 }, 500);
    }
  };
})(jQuery, Drupal, drupalSettings);
;
/**
 * @file
 * Provides JavaScript additions to the managed file field type.
 *
 * This file provides progress bar support (if available), popup windows for
 * file previews, and disabling of other file fields during Ajax uploads (which
 * prevents separate file fields from accidentally uploading files).
 */

(function ($, Drupal) {
  /**
   * Attach behaviors to the file fields passed in the settings.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches validation for file extensions.
   * @prop {Drupal~behaviorDetach} detach
   *   Detaches validation for file extensions.
   */
  Drupal.behaviors.fileValidateAutoAttach = {
    attach(context, settings) {
      const $context = $(context);
      let elements;

      function initFileValidation(selector) {
        $(once('fileValidate', $context.find(selector))).on(
          'change.fileValidate',
          { extensions: elements[selector] },
          Drupal.file.validateExtension,
        );
      }

      if (settings.file && settings.file.elements) {
        elements = settings.file.elements;
        Object.keys(elements).forEach(initFileValidation);
      }
    },
    detach(context, settings, trigger) {
      const $context = $(context);
      let elements;

      function removeFileValidation(selector) {
        $(once.remove('fileValidate', $context.find(selector))).off(
          'change.fileValidate',
          Drupal.file.validateExtension,
        );
      }

      if (trigger === 'unload' && settings.file && settings.file.elements) {
        elements = settings.file.elements;
        Object.keys(elements).forEach(removeFileValidation);
      }
    },
  };

  /**
   * Attach behaviors to file element auto upload.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches triggers for the upload button.
   * @prop {Drupal~behaviorDetach} detach
   *   Detaches auto file upload trigger.
   */
  Drupal.behaviors.fileAutoUpload = {
    attach(context) {
      $(once('auto-file-upload', 'input[type="file"]', context)).on(
        'change.autoFileUpload',
        Drupal.file.triggerUploadButton,
      );
    },
    detach(context, settings, trigger) {
      if (trigger === 'unload') {
        $(once.remove('auto-file-upload', 'input[type="file"]', context)).off(
          '.autoFileUpload',
        );
      }
    },
  };

  /**
   * Attach behaviors to the file upload and remove buttons.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches form submit events.
   * @prop {Drupal~behaviorDetach} detach
   *   Detaches form submit events.
   */
  Drupal.behaviors.fileButtons = {
    attach(context) {
      const $context = $(context);
      $context
        .find('.js-form-submit')
        .on('mousedown', Drupal.file.disableFields);
      $context
        .find('.js-form-managed-file .js-form-submit')
        .on('mousedown', Drupal.file.progressBar);
    },
    detach(context, settings, trigger) {
      if (trigger === 'unload') {
        const $context = $(context);
        $context
          .find('.js-form-submit')
          .off('mousedown', Drupal.file.disableFields);
        $context
          .find('.js-form-managed-file .js-form-submit')
          .off('mousedown', Drupal.file.progressBar);
      }
    },
  };

  /**
   * Attach behaviors to links within managed file elements for preview windows.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches triggers.
   * @prop {Drupal~behaviorDetach} detach
   *   Detaches triggers.
   */
  Drupal.behaviors.filePreviewLinks = {
    attach(context) {
      $(context)
        .find('div.js-form-managed-file .file a')
        .on('click', Drupal.file.openInNewWindow);
    },
    detach(context) {
      $(context)
        .find('div.js-form-managed-file .file a')
        .off('click', Drupal.file.openInNewWindow);
    },
  };

  /**
   * File upload utility functions.
   *
   * @namespace
   */
  Drupal.file = Drupal.file || {
    /**
     * Client-side file input validation of file extensions.
     *
     * @name Drupal.file.validateExtension
     *
     * @param {jQuery.Event} event
     *   The event triggered. For example `change.fileValidate`.
     */
    validateExtension(event) {
      event.preventDefault();
      // Remove any previous errors.
      $('.file-upload-js-error').remove();

      // Add client side validation for the input[type=file].
      const extensionPattern = event.data.extensions.replace(/,\s*/g, '|');
      if (extensionPattern.length > 1 && this.value.length > 0) {
        const acceptableMatch = new RegExp(`\\.(${extensionPattern})$`, 'gi');
        if (!acceptableMatch.test(this.value)) {
          const error = Drupal.t(
            'The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.',
            {
              // According to the specifications of HTML5, a file upload control
              // should not reveal the real local path to the file that a user
              // has selected. Some web browsers implement this restriction by
              // replacing the local path with "C:\fakepath\", which can cause
              // confusion by leaving the user thinking perhaps Drupal could not
              // find the file because it messed up the file path. To avoid this
              // confusion, therefore, we strip out the bogus fakepath string.
              '%filename': this.value.replace('C:\\fakepath\\', ''),
              '%extensions': extensionPattern.replace(/\|/g, ', '),
            },
          );
          $(this)
            .closest('div.js-form-managed-file')
            .prepend(
              `<div class="messages messages--error file-upload-js-error" aria-live="polite">${error}</div>`,
            );
          this.value = '';
          // Cancel all other change event handlers.
          event.stopImmediatePropagation();
        }
      }
    },

    /**
     * Trigger the upload_button mouse event to auto-upload as a managed file.
     *
     * @name Drupal.file.triggerUploadButton
     *
     * @param {jQuery.Event} event
     *   The event triggered. For example `change.autoFileUpload`.
     */
    triggerUploadButton(event) {
      $(event.target)
        .closest('.js-form-managed-file')
        .find('.js-form-submit[data-drupal-selector$="upload-button"]')
        .trigger('mousedown');
    },

    /**
     * Prevent file uploads when using buttons not intended to upload.
     *
     * @name Drupal.file.disableFields
     *
     * @param {jQuery.Event} event
     *   The event triggered, most likely a `mousedown` event.
     */
    disableFields(event) {
      const $clickedButton = $(this);
      $clickedButton.trigger('formUpdated');

      // Check if we're working with an "Upload" button.
      let $enabledFields = [];
      if ($clickedButton.closest('div.js-form-managed-file').length > 0) {
        $enabledFields = $clickedButton
          .closest('div.js-form-managed-file')
          .find('input.js-form-file');
      }

      // Temporarily disable upload fields other than the one we're currently
      // working with. Filter out fields that are already disabled so that they
      // do not get enabled when we re-enable these fields at the end of
      // behavior processing. Re-enable in a setTimeout set to a relatively
      // short amount of time (1 second). All the other mousedown handlers
      // (like Drupal's Ajax behaviors) are executed before any timeout
      // functions are called, so we don't have to worry about the fields being
      // re-enabled too soon. @todo If the previous sentence is true, why not
      // set the timeout to 0?
      const $fieldsToTemporarilyDisable = $(
        'div.js-form-managed-file input.js-form-file',
      )
        .not($enabledFields)
        .not(':disabled');
      $fieldsToTemporarilyDisable.prop('disabled', true);
      setTimeout(() => {
        $fieldsToTemporarilyDisable.prop('disabled', false);
      }, 1000);
    },

    /**
     * Add progress bar support if possible.
     *
     * @name Drupal.file.progressBar
     *
     * @param {jQuery.Event} event
     *   The event triggered, most likely a `mousedown` event.
     */
    progressBar(event) {
      const $clickedButton = $(this);
      const $progressId = $clickedButton
        .closest('div.js-form-managed-file')
        .find('input.file-progress');
      if ($progressId.length) {
        const originalName = $progressId.attr('name');

        // Replace the name with the required identifier.
        $progressId.attr(
          'name',
          originalName.match(/APC_UPLOAD_PROGRESS|UPLOAD_IDENTIFIER/)[0],
        );

        // Restore the original name after the upload begins.
        setTimeout(() => {
          $progressId.attr('name', originalName);
        }, 1000);
      }
      // Show the progress bar if the upload takes longer than half a second.
      setTimeout(() => {
        $clickedButton
          .closest('div.js-form-managed-file')
          .find('div.ajax-progress-bar')
          .slideDown();
      }, 500);
      $clickedButton.trigger('fileUpload');
    },

    /**
     * Open links to files within forms in a new window.
     *
     * @name Drupal.file.openInNewWindow
     *
     * @param {jQuery.Event} event
     *   The event triggered, most likely a `click` event.
     */
    openInNewWindow(event) {
      event.preventDefault();
      $(this).attr('target', '_blank');
      window.open(
        this.href,
        'filePreview',
        'toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,width=500,height=550',
      );
    },
  };
})(jQuery, Drupal);
;
