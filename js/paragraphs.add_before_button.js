/**
 * @file
 * Paragraphs actions JS code for paragraphs actions button.
 */

(function ($, Drupal) {

  'use strict';

  /**
   * Handle event when "add paragraph above" button is clicked
   * @param event
   *   clickevent
   */
  var clickHandler = function(event) {
    event.preventDefault();
    var $button = $(this);
    var $add_more_wrapper = $button.closest('table')
      .siblings('.clearfix')
      .find('.paragraphs-add-dialog');
    var delta = $button.closest('tr').index();

    // Set delta before opening of dialog.
    var $delta = $add_more_wrapper.closest('.clearfix')
      .find('.paragraph-type-add-modal-delta');
    $delta.val(delta);
    Drupal.paragraphsAddModal.openDialog($add_more_wrapper, Drupal.t('Add before'));
  };

  /**
   * Process paragraph_AddBeforeButton elements.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches paragraphsAddBeforeButton behaviors.
   */
  Drupal.behaviors.paragraphsAddBeforeButton = {
    attach: function (context, settings) {
      var button = '<input class="paragraphs-dropdown-action paragraphs-dropdown-action--add-before button js-form-submit form-submit" type="submit" value="' + Drupal.t('Add above') + '">';
      var $actions = $(context).once().find('.paragraphs-dropdown-actions');
      $actions.each(function() {
        if ($(this).closest('.paragraph-top').hasClass('add-before-on')) {
          $(this).once().prepend(button);
        }
      });
      var $addButtons = $actions.find('.paragraphs-dropdown-action--add-before');
      // "Mousedown" is used since the original actions created by paragraphs use
      // the event "focusout" to hide the actions dropdown.
      $addButtons.on('mousedown', clickHandler);
    }
  };

})(jQuery, Drupal);
