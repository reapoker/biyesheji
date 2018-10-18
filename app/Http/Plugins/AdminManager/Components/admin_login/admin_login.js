define(function(){
            var handle = function(node,d){
                        // console.log(d);
                        // return false;
                        localStorage.api_token = d.data.token;
                        swal('验证成功！','即将转向首页！','success');
                        window.location.href="/Admin/p.AdminManager.index";
            }
            return {
                handle : handle
            }
        })