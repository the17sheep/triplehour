/**
 * 提交验证
 */
$(document).ready(function(){
    $("#registerForm").validate({
        rules: {
            user_name: {
                required: true,
                maxlength: 16
            },
            user_email: {
                required: true,
                maxlength: 255
            },
            user_pass: {
                required: true,
                minlength: 4,
                maxlength: 16
            },
            user_pass2: {
                required: true,
                minlength: 4,
                maxlength: 16,
                equalTo: "#user_pass"
            },
            tp_verify: {
                required: true,
                maxlength: 16
            }
        },
        messages: {
            user_name: {
                required: "*请填写账号！",
                maxlength: jQuery.format("*帐号长度不超过{0}位！")
            },
            user_email: {
                required: "*请填写电子邮件地址!",
                email: "*请填写正确的电子邮件格式!"
            },
            user_pass: {
                required: "*请填写密码!",
                minlength: "*密码需要至少{0}位!",
                maxlength: "*密码最多为{0}位!"
            },
            user_pass2: {
                required: "*请再次输入密码!",
                minlength: "*密码需要至少{0}位!",
                maxlength: "*密码最多为{0}位!",
                equalTo: "*两次输入的密码不一样!"
            },
            tp_verify: {
                required: "*请输入验证码!",
                maxlength: "*验证码小于{0}位!"
            }
        
        }
    })
    
    $("#loginForm").validate({
        rules: {
            user_name: {
                required: true,
                maxlength: 16
            },
            user_pass: {
                required: true,
                maxlength: 16
            },
            tp_verify: {
                required: true,
                maxlength: 16
            }
        },
        messages: {
            user_name: {
                required: "*请输入用户名!",
                maxlength: "*用户名不超过{0}位!"
            },
            user_pass: {
                required: "*请输入密码!",
                maxlength: "*密码不超过{0}位!"
            },
            tp_verify: {
                required: "*请输入验证码!",
                maxlength: "*验证码小于{0}位!"
            }
        }
    })
})

$(function(){
    $(".tp_verify").click(function(){
        var newUrl = $(this).attr("src") + "?F=" + Math.random();
        $(this).attr("src", newUrl);
    });
});

$(function(){
    $('#add_user_pro_form').validate({
        rules: {
            content: {
                required: true
            },
            tp_verify: {
                required: true,
                maxlength: 16
            },
            title: {
                required: true,
                maxlength: 128
            },
            pro_province: {
                required: true,
                maxlength: 128
            },
            brief: {
                required: true,
                maxlength: 256
            },
            tol_price: {
                required: true,
                digits: true,
                min: 1,
                max: 10000000
            },
            kucun: {
                required: true,
                digits: true,
                min: 1,
                max: 100
            },
            partners: {
                required: true,
                digits: true,
                min: 1,
                max: 100
            },
            days: {
                required: true,
                digits: true,
                min: 1,
                max: 10000
            },
            vedio: {
                maxlength: 512
            },
            keywords: {
                maxlength: 64
            },
            description: {
                maxlength: 256
            }
        },
        messages: {
            content: {
                required: "*内容必填"
            },
            tp_verify: {
                required: "*验证码必填",
                maxlength: "*最多{0}"
            },
            title: {
                required: "*项目标题必填",
                maxlength: "*最多{0}"
            },
            pro_province: {
                required: "*城市必填",
                maxlength: "*最多{0}"
            },
            brief: {
                required: "*简要说明必填",
                maxlength: "*最多{0}"
            },
            tol_price: {
                required: "*总价必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            kucun: {
                required: "*份数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            partners: {
                required: "*合伙人数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            days: {
                required: "*上线天数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            vedio: {
                maxlength: "*最多{0}"
            },
            keywords: {
                maxlength: "*最多{0}"
            },
            description: {
                maxlength: "*最多{0}"
            }
        }
    })
})

$(function(){
    $('#edit_user_pro_form').validate({
        rules: {
            content: {
                required: true
            },
            tp_verify: {
                required: true,
                maxlength: 16
            },
            title: {
                required: true,
                maxlength: 128
            },
            pro_province: {
                required: true,
                maxlength: 128
            },
            brief: {
                required: true,
                maxlength: 256
            },
            tol_price: {
                required: true,
                digits: true,
                min: 1,
                max: 10000000
            },
            kucun: {
                required: true,
                digits: true,
                min: 1,
                max: 100
            },
            partners: {
                required: true,
                digits: true,
                min: 1,
                max: 100
            },
            days: {
                required: true,
                digits: true,
                min: 1,
                max: 10000
            },
            vedio: {
                maxlength: 512
            },
            keywords: {
                maxlength: 64
            },
            description: {
                maxlength: 256
            }
        },
        messages: {
            content: {
                required: "*内容必填"
            },
            tp_verify: {
                required: "*验证码必填",
                maxlength: "*最多{0}"
            },
            title: {
                required: "*项目标题必填",
                maxlength: "*最多{0}"
            },
            pro_province: {
                required: "*城市必填",
                maxlength: "*最多{0}"
            },
            brief: {
                required: "*简要说明必填",
                maxlength: "*最多{0}"
            },
            tol_price: {
                required: "*总价必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            kucun: {
                required: "*份数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            partners: {
                required: "*合伙人数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            days: {
                required: "*上线天数必填",
                digits: "*请填正整数",
                min: "*最小{0}",
                max: "*最多{0}"
            },
            vedio: {
                maxlength: "*最多{0}"
            },
            keywords: {
                maxlength: "*最多{0}"
            },
            description: {
                maxlength: "*最多{0}"
            }
        }
    })
})
