/**
 * Content Type Ajax Preview
 *
 * @copyright: Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license:   GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

'use strict';

var FabrikContentTypeList = new Class({

    options: {},

    initialize: function (id) {
        var showUpdate = this.showUpdate;
        showUpdate(jQuery('#' + id).val());
        jQuery('#' + id).on('change', function () {
            showUpdate(jQuery(this).val());
        });
    },

    showUpdate: function (contentType) {
        Fabrik.loader.start('contentTypeListPreview', Joomla.JText._('COM_FABRIK_LOADING'));
        jQuery.ajax({
            dataType: 'text',
            url: 'index.php',
            data: {
                option: 'com_fabrik',
                task: 'contenttype.preview',
                contentType: contentType
            }
        }).done(function (data) {
            var html = "", realData;
            var dataLoc = data.indexOf('{"preview');
            if (dataLoc > 0) {
                document.body.insertAdjacentHTML('beforeend', data.slice(0, dataLoc));
            }
            data = JSON.parse(data.slice(dataLoc));
            Fabrik.loader.stop('contentTypeListPreview');
            jQuery('#contentTypeListPreview').empty().html(data.preview);
            jQuery('#contentTypeListAclUi').empty().html(data.aclMap);
        });
    }

});