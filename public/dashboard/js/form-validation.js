(function($) {
    'use strict';
    // $.validator.setDefaults({
    //     // submitHandler: function() {
    //     //     alert("ok");
    //     // }
    // });
    $(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate({
            errorPlacement: function(label, element) {
                label.addClass('mt-2 text-danger');
                label.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            }
        });
        $("#changePassword").validate({
            rules: {

                password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password"
                }
            },
            messages: {
                password: {
                    required: "Vui lòng nhập mật khẩu",
                    // minlength: "Mật khẩu phải có ít nhất 6 ký tự"
                },
                new_password: {
                    required: "Vui lòng nhập mật khẩu mới",
                    minlength: "Mật khẩu phải có ít nhất 6 ký tự"
                },
                confirm_password: {
                    required: "Vui nhập lòng mật khẩu xác nhận",
                    minlength: "Mật khẩu phải có ít nhất 6 ký tự",
                    equalTo: "Mật khẩu không chính xác"
                },

            },
            errorPlacement: function(label, element) {
                label.addClass('mt-2 text-danger');
                label.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            }
        });
        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                fullname: "required",
                username: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },

                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: "Please enter your firstname",
                fullname: "Vui lòng nhập họ tên",
                username: {
                    required: "Vui lòng nhập username",
                    minlength: "username của bạn phải có ít nhất 5 ký tự"
                },
                email: "Vui lòng nhập email",
                password: {
                    required: "Vui lòng nhập mật khẩu",
                    minlength: "Mật khẩu phải có ít nhất 6 ký tự"
                },
                confirm_password: {
                    required: "Vui nhập lòng mật khẩu xác nhận",
                    minlength: "Mật khẩu phải có ít nhất 6 ký tự",
                    equalTo: "Mật khẩu không chính xác"
                },

                agree: "Please accept our policy",
                topic: "Please select at least 2 topics"
            },
            errorPlacement: function(label, element) {
                label.addClass('mt-2 text-danger');
                label.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            }
        });
        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var fullname = $("#fullname").val();
            if (firstname && fullname && !this.value) {
                this.value = firstname + "." + fullname;
            }
        });
        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.on("click", function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });
})(jQuery);