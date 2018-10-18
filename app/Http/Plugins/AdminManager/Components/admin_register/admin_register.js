define(function(){
            var handle = function(node,d){
                console.log(d.data);
                    swal('注册成功！','点击ok转向登录页面！','success').then((value)=>{
                        $("#register-back-btn").click();
                    });
            }
            return {
                handle : handle
            }
        })