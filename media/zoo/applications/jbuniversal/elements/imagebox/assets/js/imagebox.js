/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Alexander Oganov <t_tapak@yahoo.com>
 * @coder       Sergey Kalistratov <kalistratov.s.m@gmail.com>
 */

;
(function ($, window, document, undefined) {

    JBZoo.widget('JBZoo.ImageBox',
        {
            'multiple': true,
            'type'    : 'radio'
        },
        {
            init: function () {
                this.el.find('input[type=' + this.options.type + ']:checked').next().addClass('checked');
            },

            reset: function () {

                var $this = this;

                $this.$('.image-box-input')
                    .removeAttr('checked')
                    .addClass('unchecked')
                    .removeClass('checked')
                    .next()
                    .removeClass('checked');
            },

            'click .image-box-label': function (e, $this) {

                var $field = $(this);

                if (!$this.options.multiple) {
                    if ($field.hasClass('checked')) {
                        $field
                            .removeAttr('checked')
                            .addClass('unchecked')
                            .removeClass('checked')
                            .next()
                            .removeClass('checked');

                        $field.trigger('change');
                    } else {
                        $this.$('.image-box-input').removeClass('checked');
                        $this.$('.image-box-label').removeClass('checked');

                        $field
                            .attr('checked', true)
                            .addClass('checked')
                            .removeClass('unchecked')
                            .next()
                            .addClass('checked');
                    }
                } else {

                    if ($field.hasClass('checked')) {
                        $field
                            .removeClass('checked')
                            .next()
                            .removeClass('checked');

                        $field.trigger('change');
                    } else {
                        $field
                            .addClass('checked')
                            .next()
                            .addClass('checked');
                    }

                }
            }
        }
    );

})(jQuery, window, document);