var UIGeneral = function () {

    var handlePulsate = function () {
        if (!jQuery().pulsate) {
            return;
        }

        if (App.isIE8() == true) {
            return; // pulsate plugin does not support IE8 and below
        }

        if (jQuery().pulsate) {
            jQuery('#pulsate-regular').pulsate({
                color: "#bf1c56"
            });

            jQuery('#pulsate-once').click(function () {
                $('#pulsate-once-target').pulsate({
                    color: "#399bc3",
                    repeat: false
                });
            });

            jQuery('#pulsate-crazy').click(function () {
                $('#pulsate-crazy-target').pulsate({
                    color: "#fdbe41",
                    reach: 50,
                    repeat: 10,
                    speed: 100,
                    glow: true
                });
            });
        }
    }

    var handleGritterNotifications = function () {
        if (!jQuery.gritter) {
            return;
        }

        $('#gritter-sticky').click(function () {
            var unique_id = $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'This is a sticky notice!',
                // (string | mandatory) the text inside the notification
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#">some link sample</a> montes, nascetur ridiculus mus.',
                // (string | optional) the image to display on the left
                image: './assets/img/avatar1.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: true,
                // (int | optional) the time you want it to be alive for before fading out
                time: '',
                // (string | optional) the class name you want to apply to that specific message
                class_name: 'my-sticky-class'
            });
            return false;
        });

        $('#gritter-regular').click(function () {

            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'This is a regular notice!',
                // (string | mandatory) the text inside the notification
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#">some link sample</a> montes, nascetur ridiculus mus.',
                // (string | optional) the image to display on the left
                image: './assets/img/avatar1.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
            });

            return false;

        });

        $('#gritter-max').click(function () {

            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'This is a notice with a max of 3 on screen at one time!',
                // (string | mandatory) the text inside the notification
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#">some link sample</a> montes, nascetur ridiculus mus.',
                // (string | optional) the image to display on the left
                image: './assets/img/avatar1.jpg',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (function) before the gritter notice is opened
                before_open: function () {
                    if ($('.gritter-item-wrapper').length == 3) {
                        // Returning false prevents a new gritter from opening
                        return false;
                    }
                }
            });
            return false;
        });

        $('#gritter-without-image').click(function () {
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'This is a notice without an image!',
                // (string | mandatory) the text inside the notification
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#">some link sample</a> montes, nascetur ridiculus mus.'
            });

            return false;
        });

        $('#gritter-light').click(function () {

            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'This is a light notification',
                // (string | mandatory) the text inside the notification
                text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
                class_name: 'gritter-light'
            });

            return false;
        });

        $("#gritter-remove-all").click(function () {

            $.gritter.removeAll();
            return false;

        });
    }

    var handleDynamicPagination = function() {
        $('#dynamic_pager_demo1').bootpag({
            paginationClass: 'pagination',
            next: '<i class="fa fa-angle-right"></i>',
            prev: '<i class="fa fa-angle-left"></i>',
            total: 6,
            page: 1,
        }).on("page", function(event, num){
            $("#dynamic_pager_content1").html("Page " + num + " content here"); // or some ajax content loading...
        });

        $('#dynamic_pager_demo2').bootpag({
            paginationClass: 'pagination pagination-sm',
            next: '<i class="fa fa-angle-right"></i>',
            prev: '<i class="fa fa-angle-left"></i>',
        ��OP?Ju�����~��c)m�Z��4!�񦈂Q_K$[���r�M2M��R�8U��S�I��}��j��\�2�F�wB�CSz�6a��tC�J���z� 1`�&��η
��j�����*B��O{���X���>w��'��b ��4>,¥�i�\P/�f��Q۫��
��r���?����uG(v��$�D��Ń``����T|����J�
شW{��`w�R�`M��tf(-�,�@`�.GQ�8Z�Yc��ЏV}<)> �����G[�x���h�����,��ҧ�#<{��ʀ&�
Z�I�V�d��9M۵lrk�����4?'m�2��M	E/�v#�S�����F�7$kT��_�T.�)	(7��q� �(��L���^��tّ�!T�ޏY�c���]��h���p��:}X�S��~���`p����~�b)l�^=5�&�U4�g��Ysb�����S���К+x